<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Mail\LemburVerifikasi;
use Illuminate\Support\Facades\Mail;

Auth::routes();
Route::get('/','Backend\DashboardController@index')->middleware('auth');

// HELPER UPDATE CUTI
Route::get('/helper-updatecuti', function () {
//  return Updatecuti::updatecuti($userid, $istype, $keterangan, $tgl_lembur_awal, $tgl_lembur_akhir, $jumlah_diambil);
    Updatecuti::updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
});


Route::get('/backend/profile','Backend\DashboardController@checkAuth');
Route::get('/backend/sendMail','Backend\DashboardController@sendMail');
Route::post('/backend/userprofile/{id}','Backend\DashboardController@userprofile');

Route::get('/backend/jadwal/shift','Backend\WorkScheduleController@indexShift');
Route::get('/backend/get/shift/table','Backend\WorkScheduleController@getTable');
Route::post('/backend/store/shift/schedule','Backend\WorkScheduleController@storeShiftSchedule');
Route::get('/backend/rubah/jadwal','Backend\WorkScheduleController@indexRubahJadwal');
Route::get('/backend/get/table/rubah/jadwal','Backend\WorkScheduleController@getTableRubahJadwal');
Route::post('/backend/post/table/rubah/jadwal','Backend\WorkScheduleController@postTableRubahJadwal');
Route::post('/backend/uploadFileShift','Backend\WorkScheduleController@uploadFileShift');

//NONSHIFT
Route::get('/backend/jadwal/nonshift','Backend\WorkScheduleController@indexNonShift');
Route::get('/backend/get/nonShift/table','Backend\WorkScheduleController@getnonShiftTable');
Route::post('/backend/store/nonshift/schedule','Backend\WorkScheduleController@storeNonshiftSchedule');


//CHART
Route::get('/chart','Backend\DashboardController@getChart');

//MODAL DATA KARYAWAN
Route::get('/backend/cuti/pengajuan_cuti','Backend\CutiController@getKaryawan');

//CUTI
Route::get('/backend/cuti/pengajuan_cuti','Backend\CutiController@indexCuti');
Route::post('/backend/store/cuti/pengajuan_cuti','Backend\CutiController@storeCuti');
Route::get('/backend/cuti/approve_cuti/{id}','Backend\CutiController@getapproveCuti');
Route::post('/backend/store/cuti/approve_cuti','Backend\CutiController@approveCuti');
Route::post('/backend/post/cuti/user','Backend\CutiController@getUser');
Route::post('/backend/post/cuti/filterkaryawan','Backend\CutiController@filterkaryawan');
Route::post('/backend/cuti/cuti_besar','Backend\CutiController@cekCutiBesar');
Route::post('/backend/cuti/lamacutikaryawan','Backend\CutiController@lamacuti');
Route::get('/backend/cuti/data_cuti','Backend\CutiController@dataCuti');
Route::post('/backend/cuti/data_cuti_table','Backend\CutiController@getdataCuti');
Route::get('/backend/cuti/edit_cuti/{id}','Backend\CutiController@geteditCuti');
Route::post('/backend/store/cuti/edit_cuti','Backend\CutiController@editCuti');
Route::post('/backend/store/cuti/edit_cuti2','Backend\CutiController@editCuti2');


//LEMBUR
Route::get('/backend/lembur/pengajuan_lembur','Backend\LemburController@indexLembur');
Route::get('/backend/lembur/approve_lembur/{id}','Backend\LemburController@getapproveLembur');
Route::post('/backend/store/lembur/approve_lembur','Backend\LemburController@approveLembur');
Route::post('/backend/store/lembur/pengajuan_lembur','Backend\LemburController@storeLembur');
Route::get('/backend/rekap/rekap_lembur','Backend\ReportLemburController@indexReportLembur');
Route::post('/backend/rekap/rekap_lembur/get_table','Backend\ReportLemburController@getTable');
Route::post('/backend/rekap/rekap_lembur/export','Backend\ReportLemburController@getExport');
Route::get('/backend/lembur/data_lembur','Backend\LemburController@dataLembur');
Route::post('/backend/lembur/data_lembur_table','Backend\LemburController@getdataLembur');
Route::get('/backend/lembur/edit_lembur/{id}','Backend\LemburController@geteditlembur');
Route::post('/backend/store/lembur/edit_lembur','Backend\LemburController@editlembur');
Route::post('/backend/lembur/cektgllembur','Backend\LemburController@cektgllembur');

//IJIN
Route::get('/backend/ijin/pengajuan_ijin','Backend\IjinController@indexIjin');
Route::post('/backend/store/ijin/pengajuan_ijin','Backend\IjinController@storeIjin');
Route::get('/backend/ijin/approve_ijin/{id}','Backend\IjinController@getapproveIjin');
Route::post('/backend/store/ijin/approve_ijin','Backend\IjinController@approveIjin');
Route::get('/backend/ijin/data_ijin','Backend\IjinController@dataIjin');
Route::post('/backend/ijin/data_ijin_table','Backend\IjinController@getdataIjin');
Route::get('/backend/ijin/edit_ijin/{id}','Backend\IjinController@geteditijin');
Route::post('/backend/store/ijin/edit_ijin','Backend\IjinController@editijin');


//REPORT CUTI
Route::get('/backend/report/report_cuti','Backend\ReportCutiController@indexReportCuti');
Route::post('/backend/report/report_cuti/get_table','Backend\ReportCutiController@getTable');
Route::post('/backend/report/report_cuti/export','Backend\ReportCutiController@getExport');

//REPORT IJIN
Route::get('/backend/report/report_ijin','Backend\ReportIjinController@indexReportIjin');
Route::post('/backend/report/report_ijin/get_table','Backend\ReportijinController@getTable');
Route::post('/backend/report/report_ijin/export','Backend\ReportIjinController@getExport');

//REPORT ABSENSI
Route::get('/backend/report/report_absensi','Backend\ReportAbsensiController@index');
Route::get('/backend/report/upload_absensi','Backend\ReportAbsensiController@indexUpload');
Route::post('/backend/uploadAbsensi','Backend\ReportAbsensiController@uploadAbsensi');
Route::get('/backend/getDepartment','Backend\ReportAbsensiController@getDepartment');
Route::post('/backend/getDataReportAbsensi','Backend\ReportAbsensiController@getDataReportAbsensi');
Route::post('/backend/exportabsensi','Backend\ReportAbsensiController@exportabsensi');

//REPORT UMUT
Route::get('/backend/report/report_umut','Backend\ReportUmutController@index');
Route::post('/backend/getDataReportUmut','Backend\ReportUmutController@getDataReportUmut');
Route::post('/backend/exportumut','Backend\ReportUmutController@exportumut');

/*SETTING*/
Route::get('/backend/karyawan','Backend\KaryawanController@index');
Route::get('/backend/karyawan/add','Backend\KaryawanController@add');
Route::get('/backend/karyawan/edit/{id}','Backend\KaryawanController@edit');
Route::post('/backend/data/karyawan','Backend\KaryawanController@getDataKaryawan');
Route::post('/backend/karyawan/store','Backend\KaryawanController@store');
Route::post('/backend/karyawan/update/{id}','Backend\KaryawanController@update');
Route::post('/backend/karyawan/nonaktif/{id}','Backend\KaryawanController@nonaktif');
Route::post('/backend/karyawan/search','Backend\KaryawanController@search');
Route::post('/backend/master/karyawan/export','Backend\KaryawanController@export');

Route::get('/backend/biaya','Backend\SettingController@indexbiaya');
Route::post('/backend/biaya/edit/{id}','Backend\SettingController@updatebiaya');

Route::get('/backend/harilibur','Backend\SettingController@indexHariLibur');
Route::post('/backend/harilibur/add','Backend\SettingController@addHariLibur');
Route::post('/backend/harilibur/edit/{id}','Backend\SettingController@editHariLibur');

Route::get('/backend/mst/jadwal/shift','Backend\SettingController@indexMstJadwal');
Route::get('/backend/mst/jadwal/shift/add','Backend\SettingController@addMstJadwal');
Route::get('/backend/mst/jadwal/shift/edit/{id}','Backend\SettingController@editMstJadwal');
Route::post('/backend/mst/jadwal/shift/update/{id}','Backend\SettingController@updateMstJadwal');
Route::post('/backend/mst/jadwal/shift/store','Backend\SettingController@storeMstJadwal');

Route::get('/backend/mst/department','Backend\SettingController@indexMstDepartment');
Route::post('/backend/mst/department/edit/{id}','Backend\SettingController@updateMstDepartment');
Route::post('/backend/mst/department/store','Backend\SettingController@storeMstDepartment');
/*END REPORT KARYAWAN*/




