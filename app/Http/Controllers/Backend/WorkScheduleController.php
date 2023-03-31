<?php

namespace App\Http\Controllers\Backend;

use DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Lembur;
use App\Models\TanggalMerah;
use App\Models\Schedule;
use App\Models\MstNonshiftSchedules;
use App\Models\Departement;
use App\Models\NonshiftSchedule;
use Illuminate\Http\Request;
use App\Models\ShiftSchedule;
use App\Imports\FileImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
class WorkScheduleController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    
    public function indexShift() 
    {
        $nowYear = date('Y');
        $departements = Departement::where('shift','Y')->get();
        return view('admin.workSchedule.indexShift',compact('nowYear','departements'));
    }

    public function getTable(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $dept_id = $request->input('dept_id');

        $lastDay = $request->input('lastDay');
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);
        $days=[];
        $h=0;
        for($i=$start_time; $i<$end_time; $i+=86400)
        {
           $list = date('Y m d-D', $i);
           $days[$h]["tgl"] = date('Y-m-d',$i);
           $days[$h]["tgl2"] = date('j',$i);
           $days[$h]["days"] = substr($list, -3);
           $days[$h++];
        }
        $getDays = $days;
        // return $getDays;

        /*Cek Tgl Merah*/
        $x=0;
        $tgl=[];
        for ($y=1; $y <= $lastDay ; $y++) { 
            if($y<=9){
                $value = $year."-".$month."-0".$y;
            }else{
                $value = $year."-".$month."-".$y;
            }
            $cekTanggalMerah = cekTglMerah($value);
            // $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);
            if($cekTanggalMerah == true){
                $tgl[$x++] = $value;
                // $merah = "yes";
            }elseif (date("D",strtotime($value))==="Sun") {
                // $merah = "yes";
                $tgl[$x++] = $value;
            }else{
                
            }
        }
        $arrayTglMerah = $tgl;
        /*end*/
        $employees = Employee::where('dept_id',$dept_id)->where('shifting','Y')->where('status',1)->get();
        $schedules = Schedule::where('dept_id',$dept_id)->orderBy('code','asc')->get();
        /*CEK DATA*/
        $shiftSchedules = ShiftSchedule::whereBetween('date',[$year."-".$month."-01",$year."-".$month."-".$lastDay])
                        ->where('dept',$dept_id)->get();
        if(count($shiftSchedules)>0){
            return view('admin.workSchedule.input.shiftTableEdit',compact('month','year','lastDay','getDays','schedules','shiftSchedules','employees','arrayTglMerah'));
        }
        /*END*/
        return view('admin.workSchedule.input.shiftTable',compact('month','year','lastDay','getDays','schedules','employees','arrayTglMerah'));
    }

    public function storeShiftSchedule(Request $request){
        $values = $request->input('values');
        $month = $request->input('month');
        $year = $request->input('year');
        $lastDay = $request->input('lastDay');
        $dept_id = $request->input('dept_id');
        $shiftSchedules = ShiftSchedule::whereBetween('date',[$year."-".$month."-01",$year."-".$month."-".$lastDay])->where('dept',$dept_id)->get();
        if($shiftSchedules){
            ShiftSchedule::whereBetween('date',[$year."-".$month."-01",$year."-".$month."-".$lastDay])->where('dept',$dept_id)->delete();
        }
        foreach ($values as $value) {
            foreach ($value as $data) {
                $shiftSchedule = new ShiftSchedule;
                $shiftSchedule->nik = $data['empID'];
                $shiftSchedule->dept = $data['dept_id'];
                $shiftSchedule->date = $data['date'];
                $shiftSchedule->schedule_code = $data['scheduleId'];
                if(!empty($data['scheduleId'])){
                        $save = $shiftSchedule->save();
                }
            }
        }
        return  response()->json('success');
    }

    public function uploadFileShift(Request $request){
        $date = $request->input('year')."-".$request->input('month')."-01";
        $lastDay = date("t", strtotime($date));
        $dept_id = $request->input('dept_id');
        (new FileImport)->forEvent($request,$lastDay,$dept_id)->import($request->file('shiftSchedule'), 'local', \Maatwebsite\Excel\Excel::XLSX);
        flash()->success('Upload Jadwal Shift Berhasil');
        return redirect()->back();
    }

    /*RUBAH JADWAL*/
    public function indexRubahJadwal(){
        $departements = Departement::all();
        return view('admin.rubahJadwal.index',compact('departements'));
    }

    public function getTableRubahJadwal(Request $request){
        $dept_id = $request->input('dept_id');
        $employees = Employee::where('departement_id',$dept_id)->get();
        $schedules = Schedule::where('dept_id',$dept_id)->orderBy('code','asc')->get();
        return view('admin.rubahJadwal.input.indexTableRubahJadwal',compact('employees','schedules'));
    }

    public function postTableRubahJadwal(Request $request){
        $karyFrom = $request->input('karyFrom');
        $karyTo = $request->input('karyTo');
        $dateFrom = Carbon::parse($request->input('dateFrom'))->format('Y-m-d');
        $dateTo = Carbon::parse($request->input('dateTo'))->format('Y-m-d');
        $hourIdFrom = $request->input('hourIdFrom');
        $hourIdTo = $request->input('hourIdTo');
        $dept_id = $request->input('dept_id');
        /*Update Schedule From & To*/
        $shiftScheduleFrom = ShiftSchedule::where('date',$dateFrom)
                            ->where('employee_id',$karyFrom)->where('dept',$dept_id)

                            ->where('schedule_code',$hourIdFrom)->first();
        $shiftScheduleTo = ShiftSchedule::where('date',$dateTo)
                            ->where('employee_id',$karyTo)->where('dept',$dept_id)
                            ->where('schedule_code',$hourIdTo)->first();
        if(($shiftScheduleFrom)&&($shiftScheduleTo)){
            $shiftScheduleFrom->employee_id = $karyTo;
            $shiftScheduleFrom->update();
            $shiftScheduleTo->employee_id = $karyFrom;
            $shiftScheduleTo->update();
            $status = "success";
        }else{
            $status = "failed";
        }
        return response()->json($status);
        /*End*/

    }
    /*END RUBAH JADWAL*/

    /*NONSHIFTING*/
    public function indexNonShift(){
        $nowYear = date('Y');
        $departements = Departement::all();
        return view('admin.workSchedule.indexNonShift',compact('departements','nowYear'));
    }

    public function getnonShiftTable(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $dept_id = $request->input('dept_id');
        $lastDay = $request->input('lastDay');
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);
        $days=[];
        $h=0;
        for($i=$start_time; $i<$end_time; $i+=86400)
        {
           $list = date('Y m d-D', $i);
           $days[$h]["tgl"] = date('Y-m-d',$i);
           $days[$h]["tgl2"] = date('j',$i);
           $days[$h]["days"] = substr($list, -3);
           $days[$h++];
        }
        $getDays = $days;
        // return $getDays;
        /*Cek Tgl Merah*/
        $x=0;
        $tgl=[];
        for ($y=1; $y <= $lastDay ; $y++) { 
            if($y<=9){
                $value = $year."-".$month."-0".$y;
            }else{
                $value = $year."-".$month."-".$y;
            }
            $cekTanggalMerah = cekTglMerah($value);
            // $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);
            if($cekTanggalMerah == true){
                $tgl[$x++] = $value;
                // $merah = "yes";
            }elseif (date("D",strtotime($value))==="Sun") {
                // $merah = "yes";
                $tgl[$x++] = $value;
            }else{
                
            }
        }
        $arrayTglMerah = $tgl;
        /*End*/
        $employees = Employee::where('dept_id',$dept_id)->where('shifting','N')->where('status',1)->get();
        if(!in_array($dept_id, [14,13])){
            $schedules = MstNonshiftSchedules::where('dept_id',NULL)->orderBy('id','asc')->get();
        }else{
            $schedules = MstNonshiftSchedules::where('dept_id',$dept_id)->orderBy('id','asc')->get();
        }
        // return $schedules;
        $nonshift_schedules = NonshiftSchedule::whereBetween('date',[$year."-".$month."-01",$year."-".$month."-".$lastDay])
                        ->where('dept',$dept_id)->get();
        if(count($nonshift_schedules)>0){
            return view('admin.workSchedule.input.nonshiftTableEdit',compact('month','year','lastDay','getDays','schedules','nonshift_schedules','employees','arrayTglMerah'));
        }
        return view('admin.workSchedule.input.nonshiftTable',compact('month','year','lastDay','getDays','schedules','employees','arrayTglMerah'));
    }

    public function storeNonshiftSchedule(Request $request){
        $values = $request->input('values');
        $month = $request->input('month');
        $year = $request->input('year');
        $lastDay = $request->input('lastDay');
        $dept_id = $request->input('dept_id');
        $nonshift_schedules = NonshiftSchedule::whereBetween('date',[$year."-".$month."-01",$year."-".$month."-".$lastDay])
                        ->where('dept',$dept_id)->get();
        if(count($nonshift_schedules)>0){
            $nonshift_schedules = NonshiftSchedule::whereBetween('date',[$year."-".$month."-01",$year."-".$month."-".$lastDay])
                        ->where('dept',$dept_id)->delete();
        }
        foreach ($values as $value) {
            foreach ($value as $data) {
                $nonshift_schedule = new NonshiftSchedule;
                $nonshift_schedule->nik = $data['nik'];
                $nonshift_schedule->dept = $data['dept_id'];
                $nonshift_schedule->date = $data['date'];
                if($data['scheduleCode'] == 0){
                    $schedulenonshift = MstNonshiftSchedules::where('day','Sat')->whereNull('dept_id')->where('sabtu_masuk','Y')->first();
                    $nonshift_schedule->schedule_code = $schedulenonshift->id;
                    $nonshift_schedule->remark = 'Tukar Jadwal';
                }else{
                    $nonshift_schedule->schedule_code = $data['scheduleCode'];
                }
                if($data['scheduleCode'] != 'off'){
                    $save = $nonshift_schedule->save();
                }
            }
        }
        if(!in_array($dept_id, [14,13])){
            /*Rubah Jadwal Ke Sabtu Masuk*/
            $start_date = "01-".$month."-".$year;
            $getDays = getSatDays($start_date);
            $getDataNonShifts = NonshiftSchedule::where('dept',$dept_id)->whereIn('date',$getDays)->get();
            foreach ($getDataNonShifts as $getDataNonShift) {
                $jadwalkerja = NonshiftSchedule::where('date',$getDataNonShift->date)->where('nik',$getDataNonShift->nik)
                            ->whereNull('remark')->first();
                if(!empty($jadwalkerja)){
                    $b=0;
                    for ($i=1; $i<=5 ; $i++) { 
                        $min1date=date('Y-m-d', strtotime('-'.$i.' days', strtotime($getDataNonShift->date)));
                        $jadwalkerja = NonshiftSchedule::where('date',$min1date)->where('nik',$getDataNonShift->nik)
                                            ->first();
                        if(!empty($jadwalkerja)){
                            $mstnonshiftschedule = MstNonshiftSchedules::where('id',$jadwalkerja->schedule_code)->first();
                            $changeTo = MstNonshiftSchedules::where('day',$mstnonshiftschedule->day)->where('sabtu_masuk','Y')->first();
                            $jadwalkerja->schedule_code = $changeTo->id;
                            $jadwalkerja->update();
                        }
                    }
                }
            }
            /*End*/
        }

        return "success";
    }
    /*ENDNONSHIFTING*/

}
