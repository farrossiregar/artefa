<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\MstBiaya;
use App\Models\TanggalMerah;
use App\Models\Departement;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    public function indexbiaya() {
    	$mstbiaya = MstBiaya::all();
    	return view('admin.setting.biaya.index',compact('mstbiaya'));
    }
    public function updatebiaya($id,Request $request) {
    	$amount = str_replace(".","",$request->input('amount'));
    	$mstbiaya = MstBiaya::find($id);
    	$mstbiaya->amount = $amount;
    	$mstbiaya->update();
    	flash()->success('Biaya Berhasil Di Update');
    	return redirect()->back();
    }

    public function indexHariLibur(){
        $tanggalMerah = TanggalMerah::orderBy('date','asc')->get();
        return view('admin.setting.libur.index',compact('tanggalMerah'));
    }

    public function addHariLibur(Request $request){
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $description = $request->input('description');
        $keterangan = $request->input('keterangan');
        $tanggalMerah = new TanggalMerah;
        $tanggalMerah->date = $date;
        $tanggalMerah->description = $description;
        $tanggalMerah->keterangan = $keterangan;
        $tanggalMerah->save();
        flash()->success('Tanggal Merah Berhasil Di Simpan');
        return redirect()->back();
    }

    public function editHariLibur($id,Request $request){
        $tanggalMerah = TanggalMerah::find($id);
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $description = $request->input('description');
        $keterangan = $request->input('keterangan');
        $tanggalMerah->date = $date;
        $tanggalMerah->description = $description;
        $tanggalMerah->keterangan = $keterangan;
        $tanggalMerah->update();
        flash()->success('Tanggal Merah Berhasil Di Update');
        return redirect()->back();
    }

    public function indexMstJadwal(){
        $dept_id = Schedule::latest('created_at')->pluck('dept_id');
        $departments = Departement::whereIn('id',$dept_id)->where('status',1)->get();
        return view('admin.setting.mst_jadwal.index',compact('departments'));
    }


    public function addMstJadwal(){
        $departments = Departement::where('shift','Y')->get();
        return view('admin.setting.mst_jadwal.add',compact('departments'));
    }

    public function storeMstJadwal(Request $request){
        $schedule = new Schedule;
        $schedule->code = $request->input('code');
        $schedule->dept_id = $request->input('dept_id');
        $schedule->time_schedule_awal = $request->input('time_awal');
        $schedule->time_schedule_akhir = $request->input('time_akhir');
        $schedule->save();
        flash()->success('Master Jadwal Shift Berhasil Disimpan');
        return redirect('/backend/mst/jadwal/shift');
    }

    public function editMstJadwal($id){
        $schedule = Schedule::find($id);
        return view('admin.setting.mst_jadwal.edit',compact('schedule'));
    }

    public function updateMstJadwal(Request $request,$id){
        $time_awal = $request->input('time_awal');
        $time_akhir = $request->input('time_akhir');
        $schedule = Schedule::find($id);
        $schedule->time_schedule_awal = $time_awal;
        $schedule->time_schedule_akhir = $time_akhir;
        $schedule->update();
        flash()->success('Master Jadwal Shift Berhasil Di Update');
        return redirect('/backend/mst/jadwal/shift');
    }

    public function indexMstDepartment(){
        $departments = Departement::where('status',1)->get();
        return view('admin.setting.mst_dept.index',compact('departments'));
    }

    public function updateMstDepartment(Request $request,$id){
        $department = $request->input('department');
        $unit = $request->input('unit');
        $shift = $request->input('shift');
        $status = $request->input('status');
        $dept = Departement::find($id);
        $dept->department = $department;
        $dept->unit = $unit;
        $dept->shift = $shift;
        $dept->status = $status;
        $dept->update();
        flash()->success('Master Department Berhasil Di Update');
        return redirect('/backend/mst/department');
    }

    public function storeMstDepartment(Request $request){
        $department = $request->input('department');
        $unit = $request->input('unit');
        $shift = $request->input('shift');
        $dept = new Departement;
        $dept->department = $department;
        $dept->unit = $unit;
        $dept->shift = $shift;
        $dept->status = 1;
        $dept->save();
        flash()->success('Master Department Berhasil Di Simpan');
        return redirect('/backend/mst/department');
    }

}
