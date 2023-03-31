<?php

namespace App\Http\Controllers\Backend;

use DB;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Departement;
use App\Models\TanggalMerah;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Imports\AbsensiImport;
use App\Imports\ImportAbsen;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ReportUmutController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    public function index() {
        $employees = DB::select("SELECT a.*
                              FROM employees a 
                              where (a.ut NOT IN ('Lumpsum','N/A') or a.um NOT IN ('Kupon','N/A'))
                                and a.status = 1");
    	return view('admin.report.umut.index',compact('employees'));
    }

    public function getDataReportUmut(Request $request){
        $departments = Departement::all();
        $periode = $request->input('periode');
        $id_kar = $request->input('idKar');
        $var1 = $periode;
        if($periode ==1){
            $dateFrom = $request->input('year')."-".$request->input('month')."-01";
            $dateTo = date("Y-m-t", strtotime($dateFrom));
            $endperiod  = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
            $var2 = $request->input('month');
            $var3 = $request->input('year');
        }else{
            $dateFrom = DateTime::createFromFormat('d/m/Y', $request->input('dateFrom'))->format('Y-m-d');
            $datetime = DateTime::createFromFormat('d/m/Y', $request->input('dateTo'))->format('Y-m-d');
            $dateTo   = (new DateTime($datetime))->format('Y-m-d');
            $endperiod  = (new DateTime($datetime))->modify('+1 day')->format('Y-m-d');
            $var2 = $request->input('dateFrom');
            $var3 = $request->input('dateTo');
        }
        $start = new DateTime($dateFrom);
        $end = new DateTime($endperiod);
        $interval = DateInterval::createFromDateString('1 days');
        $period   = new DatePeriod($start, $interval, $end);
        $days=[];
        $h=0;
        foreach ($period as $dt) {
            $list = $dt->format("Y m d-D");
            $day = substr($list, -3);
            if($day == 'Sat'){
             $days[$h] = $dt->format("Y-m-d");
             $days[$h++];
            }
        }
        $getSatDays = $days;
        $sunday=[];
        $j=0;
        foreach ($period as $dt) {
            $list = $dt->format("Y m d-D");
            $day = substr($list, -3);
            if($day == 'Sun'){
             $sunday[$j] = $dt->format("Y-m-d");
             $sunday[$j++];
            }
        }
        $getSunDays = $sunday;
        $tglMerah = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->get()->pluck('date');
        // return $tglMerah;
        if(count($tglMerah)>0){
            $tglMerah = $tglMerah;
        }else{
            $tglMerah = ['0','0'];
        }
        $min3bulan = date('Y-m-d', strtotime('-3 months', strtotime($dateFrom)));
        // $salesidmin3bulan = Employee::whereIn('dept_id',[17,18,19])->whereBetween('tgl_join',[$min3bulan,$dateTo])->pluck('id');
        return view('admin.report.umut.input.reportumut',compact(
                        'departments','dateTo','dateFrom','getSatDays','getSunDays','min3bulan','var1','var2','var3','id_kar'
                    ));
    }

    public function exportumut(Request $request){
        $idkar = $request->input('idkar');
        $departments = Departement::all();
        $periode = $request->input('var1');
        $id_kar = $request->input('id_kar');
        if($periode ==1){
            $dateFrom = $request->input('var3')."-".$request->input('var2')."-01";
            $dateTo = date("Y-m-t", strtotime($dateFrom));
            $endperiod  = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
        }else{
            $dateFrom = DateTime::createFromFormat('d/m/Y', $request->input('var2'))->format('Y-m-d');
            $datetime = DateTime::createFromFormat('d/m/Y', $request->input('var3'))->format('Y-m-d');
            $dateTo   = (new DateTime($datetime))->format('Y-m-d');
            $endperiod  = (new DateTime($datetime))->modify('+1 day')->format('Y-m-d');
        }
        $start = new DateTime($dateFrom);
        $end = new DateTime($endperiod);
        $interval = DateInterval::createFromDateString('1 days');
        $period   = new DatePeriod($start, $interval, $end);
        $days=[];
        $h=0;
        foreach ($period as $dt) {
            $list = $dt->format("Y m d-D");
            $day = substr($list, -3);
            if($day == 'Sat'){
             $days[$h] = $dt->format("Y-m-d");
             $days[$h++];
            }
        }
        $getSatDays = $days;
        $sunday=[];
        $j=0;
        foreach ($period as $dt) {
            $list = $dt->format("Y m d-D");
            $day = substr($list, -3);
            if($day == 'Sun'){
             $sunday[$j] = $dt->format("Y-m-d");
             $sunday[$j++];
            }
        }
        $getSunDays = $sunday;
        $tglMerah = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->get()->pluck('date');
        // return $tglMerah;
        if(count($tglMerah)>0){
            $tglMerah = $tglMerah;
        }else{
            $tglMerah = ['0','0'];
        }
        $min3bulan = date('Y-m-d', strtotime('-3 months', strtotime($dateFrom)));
        $idkar = [];
        $karid = $request->umut;
        foreach ($karid as $data) {
            $idkar[] = $data;
        }
        return view('admin.report.umut.input.exportumut',compact(
                        'departments','dateTo','dateFrom','getSatDays','getSunDays','min3bulan','idkar','id_kar'
                    ));
    }

    // public function exportumut(Request $request){
    //     return $request->var2;
    //     return view('admin.report.umut.input.exportumut');
    // }

}
