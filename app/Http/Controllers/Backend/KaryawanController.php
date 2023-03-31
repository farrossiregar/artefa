<?php

namespace App\Http\Controllers\Backend;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Departement;
use App\Models\MstLevel;
use App\Models\MstJabatan;
use App\Models\TanggalMerah;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Imports\AbsensiImport;
use App\Imports\ImportAbsen;
use App\Models\Employee;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    public function index() {
        // $update = cuti('230',1,'asd','2018-11-13','2018-11-13',1,'N');
        // dd($update);
        $departements = Departement::all();
        return view('admin.karyawan.index',compact('departements'));
    }

    public function getDataKaryawan(Request $request){
        $dept_id = $request->input('dept_id');
        if($dept_id == 'all'){
            $departements = Departement::all();
            return view('admin.karyawan.input.gridsemuakaryawan',compact('departements'));
        }else{
            $employees = Employee::where('dept_id',$dept_id)->get();
            $departement = Departement::where('id',$dept_id)->first();
            return view('admin.karyawan.input.grid',compact('employees','departement'));
        }
    }

    public function add(){
        $departements = Departement::all();
        $levels = MstLevel::all();
        $jabatans = MstJabatan::all();
        $employees = Employee::orderBy('id','asc')->get();
        return view('admin.karyawan.add',compact('departements','levels','jabatans','employees'));
    }

    public function store(Request $request){
        $tgl_lahir = Carbon::parse($request->input('tgl_lahir'))->format('Y-m-d');
        $tgl_join = Carbon::parse($request->input('tgl_join'))->format('Y-m-d');
        $getLastuserid = Employee::orderBy('userid','desc')->pluck('userid')->first();
        if(is_null($request->newjabatan)){
            $jabatan = $request->input('jabatan');
        }else{
            $mstjabatan = new MstJabatan;
            $mstjabatan->name = ucwords($request->newjabatan);
            $mstjabatan->save();
            $jabatan = ucwords($request->newjabatan);
        }
        $employee = new Employee;
        $employee->dept_id = $request->input('dept_id');
        $employee->nama = $request->input('nama');
        $employee->nik = $request->input('nik');
        $employee->userid = $getLastuserid+1;
        $employee->email = $request->input('email');
        $employee->tgl_lahir = $tgl_lahir;
        $employee->level = $request->input('level');
        $employee->jabatan = $jabatan;
        $employee->direct_supervisor = $request->input('direct_supervisor');
        $employee->next_higher_supervisor = $request->input('next_higher_supervisor');
        $employee->shifting = $request->input('shifting');
        $employee->ut = $request->input('ut');
        $employee->um = $request->input('um');
        $employee->tgl_join = $tgl_join;
        $employee->tgl_resign = '1970-01-01';
        $employee->status = 1;//AKTIF
        $employee->remark = $request->input('remark');
        $employee->save();
        flash()->success('Data Karyawan Berhasil Disimpan');
        return redirect('/backend/karyawan');   
    }

    public function edit($id){
        $departements = Departement::all();
        $levels = MstLevel::all();
        $jabatans = MstJabatan::all();
        $employees = Employee::orderBy('id','asc')->get();
        $karyawan = Employee::find($id);
        return view('admin.karyawan.edit',compact('departements','levels','jabatans','employees','karyawan'));
    }

    public function update($id,Request $request){
        $tgl_lahir = Carbon::parse($request->input('tgl_lahir'))->format('Y-m-d');
        $tgl_join = Carbon::parse($request->input('tgl_join'))->format('Y-m-d');
        $employee = Employee::find($id);
        if(is_null($request->newjabatan)){
            $jabatan = $request->input('jabatan');
        }else{
            $mstjabatan = new MstJabatan;
            $mstjabatan->name = ucwords($request->newjabatan);
            $mstjabatan->save();
            $jabatan = ucwords($request->newjabatan);
        }
        $employee->dept_id = $request->input('dept_id');
        $employee->nama = $request->input('nama');
        $employee->nik = $request->input('nik');
        $employee->email = $request->input('email');
        $employee->tgl_lahir = $tgl_lahir;
        $employee->level = $request->input('level');
        $employee->jabatan = $jabatan;
        $employee->direct_supervisor = $request->input('direct_supervisor');
        $employee->next_higher_supervisor = $request->input('next_higher_supervisor');
        $employee->shifting = $request->input('shifting');
        $employee->ut = $request->input('ut');
        $employee->um = $request->input('um');
        $employee->remark = $request->input('remark');
        $employee->tgl_join = $tgl_join;
        if($employee->status == 2){
            $employee->tgl_resign = NULL;
            $employee->status = 1;//AKTIF KEMBALI
        }
        $employee->update();
        flash()->success('Data Karyawan Berhasil Di Update');
        return redirect()->back();   
    }

    public function nonaktif($id,Request $request){
        $tgl_resign = Carbon::parse($request->input('tgl_resign'))->format('Y-m-d');
        $employee = Employee::find($id);
        $employee->tgl_resign = $tgl_resign;
        $employee->status = 2;//NONAKTIF
        $employee->update();
        return $tgl_resign;
        // flash()->success('Karyawan Berhasil Di NonAktifkan');
        // return redirect()->back();   
    }

    public function search(Request $request) {
        $content = $request->input('content');
        $search = Employee::where('dept_id',$request->input('dept_id'))->where(function ($query) use($content) {
                        $query->where('nama', 'like', '%' .$content. '%')
                                ->orWhere('nik', 'like', '%' .$content. '%')
                                ->orWhere('level', 'like', '%' .$content. '%')
                                ->orWhere('jabatan', 'like', '%' .$content. '%');
                    })
                    ->select('id')->get();
        $employees = Employee::whereIn('id',$search)->get();
        $departement = Departement::where('id',$request->input('dept_id'))->first();
        return view('admin.karyawan.input.grid',compact('employees','departement'));
    }

    public function export(Request $request){
        $dept_id = $request->input('dept_id');
        $now = Carbon::now()->format('d F Y');
        $cols = 14;
        if($dept_id == 'all'){
            $data = Departement::all();
        }else{
            $data = Employee::where('dept_id',$dept_id)->get();
        }
        return view('admin.karyawan.input.export',compact('dept_id','now','data','cols'));
    }

}
