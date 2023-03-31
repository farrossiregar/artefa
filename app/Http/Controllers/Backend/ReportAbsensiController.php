<?php

namespace App\Http\Controllers\Backend;

use DB;
use Auth;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Departement;
use App\Models\TanggalMerah;
use App\Models\Schedule;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Imports\AbsensiImport;
use App\Imports\ImportAbsen;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ReportAbsensiController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    public function indexUpload() {
        // $code = Schedule::where('dept_id',10)->orderBy('code','asc')
        //                                 ->pluck('code')->first();
        //                                 dd($code);
        $nowYear = date('Y');
        $departements = Departement::all();
        return view('admin.report.absensi.index_upload',compact('nowYear','departements'));
    }

    public function uploadAbsensi(Request $request){
        (new ImportAbsen)->forEvent($request)->import($request->file('absensi'), 'local', \Maatwebsite\Excel\Excel::XLSX);
        flash()->success('Berhasil menyimpan data');
        return redirect()->back();
    }
	
    public function index() {
        $employees = DB::select("SELECT a.*
                              FROM employees a 
                              where  a.status = 1
                              ORDER BY a.nama ASC");
        $auth = User::find(Auth::id());
        $user = Employee::where('id',$auth->emp_id)->first();
    	return view('admin.report.absensi.index',compact('employees','user'));
    }

    public function getDepartment(){
        $departmens = Departement::all();
        return view('admin.report.absensi.input.department',compact('departmens'));
    }

    public function getDataReportAbsensi(Request $request)
    {
        $tipe = $request->input('tipe');
        $berdasarkan = $request->input('berdasarkan');
        $dept_id = $request->input('department');
        $periode = $request->input('periode');
        $idKar = $request->input('idKar');
        $var1 = $periode;
        if ($berdasarkan == 1) {
            $names = Employee::where('dept_id',$dept_id)->get();
        }else{
            $names = Departement::where('status',1)->get();
        }
        if($tipe == 1){
            if($periode ==1){
                $dateFrom = $request->input('year')."-".$request->input('month')."-01";
                $dateTo = date("Y-m-t", strtotime($dateFrom));
                $endperiod  = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
                $start = new DateTime($dateFrom);
                $end = new DateTime($dateTo);
                $totalhari = $start->diff($end)->days+1;
                $var2 = $request->input('month');
                $var3 = $request->input('year');
                $tahun = $request->input('year');
            }else{
                $dateFrom = DateTime::createFromFormat('d/m/Y', $request->input('dateFrom'))->format('Y-m-d');
                $datetime = DateTime::createFromFormat('d/m/Y', $request->input('dateTo'))->format('Y-m-d');
                $dateTo   = (new DateTime($datetime))->format('Y-m-d');
                $endperiod  = (new DateTime($datetime))->modify('+1 day')->format('Y-m-d');
                $start = new DateTime($dateFrom);
                $end = new DateTime((new DateTime($datetime))->format('Y-m-d'));
                $totalhari = $start->diff($end)->days+1;
                $var2 = $request->input('dateFrom');
                $var3 = $request->input('dateTo');
                $tahun = DateTime::createFromFormat('d/m/Y', $request->input('dateTo'))->format('Y');
            }
            $countTglMerah = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
            $start = new DateTime($dateFrom);
            $end = new DateTime($endperiod);
            $interval = DateInterval::createFromDateString('1 days');
            $period   = new DatePeriod($start, $interval, $end);
            $days=[];
            $h=0;
            foreach ($period as $dt) {
                $list = $dt->format("Y m d-D");
                $day = substr($list, -3);
                if($day == 'Sun'){
                 $days[$h] = $dt->format("Y-m-d");
                 $days[$h++];
                }
            }
            $getSunDays = count($days);
            $jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;

            return view('admin.report.absensi.input.reportAbsensi',compact(
                    'names','berdasarkan','dateFrom','dateTo','jumlahharikerja','var1','var2','var3','tipe','dept_id','idKar','tahun'
            ));
        }elseif($tipe == 2){
            $tahun = $request->input('tahun');
            $thisyear = Carbon::now()->format('Y');
            $now = Carbon::now()->format('m');
            $months = getMonths();
            $data=[];
            foreach ($months as $month) {
                if($thisyear!=$tahun){
                    $data[] = $month;
                }else{
                    if($month->id <= $now){
                        $data[] = $month;
                    }
                }
            }
            $months = $data;
            return view('admin.report.absensi.input.reportAbsensiAkumulatif',compact('names','berdasarkan','months','tahun','idKar','var1','tipe','dept_id'));
        }else{
            if($periode ==1){
                $dateFrom = $request->input('year')."-".$request->input('month')."-01";
                $dateTo = date("Y-m-t", strtotime($dateFrom));
            }else{
                $dateFrom = DateTime::createFromFormat('d/m/Y', $request->input('dateFrom'))->format('Y-m-d');
                $datetime = DateTime::createFromFormat('d/m/Y', $request->input('dateTo'))->format('Y-m-d');
                $dateTo   = (new DateTime($datetime))->format('Y-m-d');
            }

            return view('admin.report.absensi.input.reportDataAbsen',compact('names','berdasarkan','tipe','dept_id','dateFrom','dateTo','idKar'));
        }
    }

    public function exportabsensi(Request $request){
        $tipe = $request->input('tipe');
        $berdasarkan = $request->input('berdasarkan');
        $dept_id = $request->input('dept_id');
        $idKar = $request->input('id_kar');
        $periode = $request->input('var1');
        if ($berdasarkan == 1) {
            $names = Employee::where('dept_id',$dept_id)->get();
            $deptname=Departement::find($dept_id)->first();
            ($deptname->department == $deptname->unit)?$var4=$deptname->unit:$var4 = $deptname->department." - ".$deptname->unit;
        }else{
            $names = Departement::all();
            $var4 = 'Semua Unit';
        }
        if($tipe == 1){
            if($periode ==1){
                $dateFrom = $request->input('var3')."-".$request->input('var2')."-01";
                $dateTo = date("Y-m-t", strtotime($dateFrom));
                $endperiod  = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
                $start = new DateTime($dateFrom);
                $end = new DateTime($dateTo);
                $totalhari = $start->diff($end)->days+1;
                $tahun = $request->input('var3');
            }else{
                $dateFrom = DateTime::createFromFormat('d/m/Y', $request->input('var2'))->format('Y-m-d');
                $datetime = DateTime::createFromFormat('d/m/Y', $request->input('var3'))->format('Y-m-d');
                $dateTo   = (new DateTime($datetime))->format('Y-m-d');
                $endperiod  = (new DateTime($datetime))->modify('+1 day')->format('Y-m-d');
                $start = new DateTime($dateFrom);
                $end = new DateTime((new DateTime($datetime))->format('Y-m-d'));
                $totalhari = $start->diff($end)->days+1;
                $tahun = DateTime::createFromFormat('d/m/Y', $request->input('var3'))->format('Y');
            }
            $countTglMerah = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
            $start = new DateTime($dateFrom);
            $end = new DateTime($endperiod);
            $interval = DateInterval::createFromDateString('1 days');
            $period   = new DatePeriod($start, $interval, $end);
            $days=[];
            $h=0;
            foreach ($period as $dt) {
                $list = $dt->format("Y m d-D");
                $day = substr($list, -3);
                if($day == 'Sun'){
                 $days[$h] = $dt->format("Y-m-d");
                 $days[$h++];
                }
            }
            $getSunDays = count($days);
            $jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;

            return view('admin.report.absensi.input.exportAbsensi',compact(
                    'names','berdasarkan','dateFrom','dateTo','jumlahharikerja',
                    'var4','dateFrom','dateTo','idKar','tahun'
            ));
        }else{
            $tahun = $request->input('tahun');
            $thisyear = Carbon::now()->format('Y');
            $now = Carbon::now()->format('m');
            $months = getMonths();
            $data=[];
            foreach ($months as $month) {
                if($thisyear!=$tahun){
                    $data[] = $month;
                }else{
                    if($month->id <= $now){
                        $data[] = $month;
                    }
                }
            }
            $months = $data;
            $cols = count($months)+3;
            return view('admin.report.absensi.input.exportAbsensiAkumulatif',compact('names','berdasarkan','months','tahun','var4','cols','idKar'));
        }
    }
}
