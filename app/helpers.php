<?php

use Carbon\Carbon;
use App\Models\TanggalMerah;
use App\Models\HPcuti;
use App\Models\Cuti;
use App\Models\HPcutibesar;
use App\Models\Employee;
use App\Models\Datahakcuti;
use Illuminate\Support\Facades\DB;
use Auth as Auth;


function limitWord($str, $limit) {
  $word = \Illuminate\Support\Str::words($str, $limit, '...');
  return $word;
}

function cekTglMerah($date){
    $cek = TanggalMerah::where('date',$date)->get();
    if(count($cek)>0){
        $data = true;
    }
    else{
        $data = false;
    }
    return $data;
}

function getDays($start_date){
    $start_time = strtotime($start_date);

    $end_time = strtotime("+1 month", $start_time);
    $days=[];
    $h=0;
    for($i=$start_time; $i<$end_time; $i+=86400)
    {
       $list = date('Y m d-D', $i);
       $days[$h]["tgl"] = date('Y-m-d',$i);
       $days[$h]["days"] = substr($list, -3);
       $days[$h++];
    }
    $getDays = $days;
    return $getDays;
}

function getSatDays($start_date){
    $start_time = strtotime($start_date);
    $end_time = strtotime("+1 month", $start_time);
    $days=[];
    $h=0;
    for($i=$start_time; $i<$end_time; $i+=86400)
    {
       $list = date('Y m d-D', $i);
       $day = substr($list, -3);
       if($day == 'Sat'){
        $days[$h] = date('Y-m-d',$i);
        $days[$h++];
       }
    }
    $getSatDays = $days;
    return $getSatDays;
}

function transformDate($value)
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return Carbon::parse($value)->format('Y-m-d');
    }
}

function transformTime($value)
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return Carbon::parse($value)->format('H:i');
    }
}

function getWKHR($tgl,$time_schedule_awal,$time_schedule_akhir){
    $jamMasuk = new DateTime($time_schedule_awal);
    $jamPulang = new DateTime($time_schedule_akhir);
    $range = $jamPulang->diff($jamMasuk);
    $range=date_create($range->format('%H:%I'));
    if(!in_array($tgl, getSatDays($tgl))){
       date_sub($range,date_interval_create_from_date_string("1 hour")); 
    }
    $wkhr = date_format($range,"H:i");
    $wkhr = explode(':', $wkhr);
    $wkhr = ($wkhr[0] * 60.0 + $wkhr[1] * 1.0);
    return $wkhr;
}

function getMonths(){
    $months[] = (object) array('id' => '01', 'M' => 'Jan');
    $months[] = (object) array('id' => '02', 'M' => 'Feb');
    $months[] = (object) array('id' => '03', 'M' => 'Mar');
    $months[] = (object) array('id' => '04', 'M' => 'Apr');
    $months[] = (object) array('id' => '05', 'M' => 'Mei');
    $months[] = (object) array('id' => '06', 'M' => 'Jun');
    $months[] = (object) array('id' => '07', 'M' => 'Jul');
    $months[] = (object) array('id' => '08', 'M' => 'Agu');
    $months[] = (object) array('id' => '09', 'M' => 'Sep');
    $months[] = (object) array('id' => '10', 'M' => 'Okt');
    $months[] = (object) array('id' => '11', 'M' => 'Nov');
    $months[] = (object) array('id' => '12', 'M' => 'Des');
    return $months;
}

function intervalDate($dateFrom,$dateTo){
    $start = new DateTime($dateFrom);
    $end = new DateTime($dateTo);
    $end = $end->modify('+1 day');
    $interval = DateInterval::createFromDateString('1 days');
    $period   = new DatePeriod($start, $interval, $end);
    $days=[];
    $h=0;
    foreach ($period as $dt) {
        $days[$h] = $dt->format("Y-m-d");
        $days[$h++];
    }
    return $days;
}

function cuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil, $finger=''){
    $karyawan = Employee::where('userid',$userid)->first();
    $month = Carbon::parse($mulai)->format('m');
    $year = Carbon::parse($mulai)->format('Y');
    $cek_cutay = DB::select("SELECT * from tbl_pengajuan_cuti where nik = '".$karyawan->nik."' and app2='Y'
                            and ((MONTH(tgl_cuti_awal)='".$month."' and YEAR(tgl_cuti_awal)='".$year."') 
                                or (MONTH(tgl_cuti_akhir)='".$month."' and YEAR(tgl_cuti_akhir)='".$year."'))");
    if($cek_cutay){
        $intdate=array();
        foreach ($cek_cutay as $key => $value) {
            foreach (intervalDate($value->tgl_cuti_awal,$value->tgl_cuti_akhir) as $date) {
                $intdate[] = $date;
            }
        }
        if(!in_array($mulai, $intdate)){ //Belum Ada Cuti
            return true;
            $cuti = new Cuti;
            $cuti->nama_karyawan = $karyawan->nama_karyawan;
            $cuti->nik = $karyawan->nik;
            $cuti->kd_divisi = $karyawan->dept_id;
            $cuti->jabatan = $karyawan->dept_id;
            $cuti->alamat = NULL;
            $cuti->tgl_pengajuan_cuti = date('Y-m-d H:i:s');
            $cuti->tgl_cuti_awal = $mulai;
            $cuti->tgl_cuti_akhir = $akhir;
            $cuti->jumlah_hari = $jumlah_diambil;
            $cuti->jenis_cuti = 'C1';
            $cuti->jenis_cuti_detail = 'Cuti Tahunan';
            $cuti->penjelasan_cuti = 'Potong Dari Absensi';
            $cuti->petugas_pengganti = NULL;
            $cuti->app1 = 'Y';
            $cuti->app2 = 'Y';
            $cuti->app3 = 'Y';
            $cuti->save();
            updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
        }else{
            if($finger == 'N'){
                $getcuti = collect(DB::select("SELECT * from tbl_pengajuan_cuti where nik = '".$karyawan->nik."' and app2='Y'
                            and (tgl_cuti_awal='".$mulai."' or tgl_cuti_akhir='".$mulai."')"))->first();

                // return $getcuti;
                if($getcuti->jumlah_hari == 0.5){
                    if($karyawan->shifting == 'Y'){ //Karyawan Shift Langsung Update sisa cuti + 0.5 karena tidak masuk full
                        $cutay = Cuti::where('id',$getcuti->id)->first();
                        $cutay->jumlah_hari = $jumlah_diambil;
                        $cutay->update();
                        //NOTES CONFIRM TABLE DATA HAK CUTI
                    }else{
                        $start_date = Carbon::parse($mulai)->format('Y-m')."-01";
                        $getSatDays = getSatDays($start_date);
                        if(!in_array($mulai, $getSatDays)){ //BUKAN HARI SABTU HARUS NYA CUTI 1 bukan 0.5
                            $cutay = Cuti::where('id',$getcuti->id)->first();
                            $cutay->jumlah_hari = $jumlah_diambil;
                            $cutay->update();
                            //NOTES CONFIRM TABLE DATA HAK CUTI
                        }
                    }
                }
            }
        }
    }else{
        // return 'file';
        $cuti = new Cuti;
        $cuti->nama_karyawan = $karyawan->nama_karyawan;
        $cuti->nik = $karyawan->nik;
        $cuti->kd_divisi = $karyawan->dept_id;
        $cuti->jabatan = $karyawan->dept_id;
        $cuti->alamat = NULL;
        $cuti->tgl_pengajuan_cuti = date('Y-m-d H:i:s');
        $cuti->tgl_cuti_awal = $mulai;
        $cuti->tgl_cuti_akhir = $akhir;
        $cuti->jumlah_hari = $jumlah_diambil;
        $cuti->jenis_cuti = 'C1';
        $cuti->jenis_cuti_detail = 'Cuti Tahunan';
        $cuti->penjelasan_cuti = 'Potong Dari Absensi';
        $cuti->petugas_pengganti = NULL;
        $cuti->app1 = 'Y';
        $cuti->app2 = 'Y';
        $cuti->app3 = 'Y';
        $cuti->save();
        updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
    }
}

function statusapprove($app1, $app2, $app3){
    if($app1 == ''){
        $status = 'Belum diproses';
    }else{
        if($app1 == 'Y'){
            if($app2 == ''){
                $status = 'Disetujui App1';
            }else{
                if($app2 == 'Y'){
                    if($app3 == ''){
                        $status = 'Disetujui App2';
                    }else{
                        if($app3 == 'Y'){
                            $status = 'Disetujui App3';
                        }else{
                            $status = 'Tidak disetujui App3';
                        }
                    }
                }else{
                    $status = 'Tidak disetujui App2';
                }
            }
        }else{
            $status = 'Tidak disetujui App1';
        }
    }

    return $status;
}


function cutiexisting($nik){
    $tahun_ini = date('Y');
    $datakaryawan = DB::select("SELECT a.*, b.*, c.*,
                                (select sum(jumlah) 
                                    from hpcuti 
                                    where istype in ('1', '2', '3', '5') 
                                    and isuser = b.isuser 
                                    and YEAR(mulai) = '".$tahun_ini."'
                                group by isuser) as cutitahunan,
                                (select sum(JumlahB) 
                                    from hpcutibesar 
                                    where isUserB = a.userid 
                                    and YEAR(mulaiB) = '".$tahun_ini."'
                                group by isUserB) as cutibesar, 
                                (select sum(jumlah) 
                                    from hpcuti 
                                    where istype = '5' 
                                    and isuser = b.isuser 
                                group by isuser) as cutikhusus

                                FROM employees a 
                                LEFT JOIN hpcuti b 
                                ON b.isuser = a.userid 
                                LEFT JOIN hpcutibesar c 
                                ON c.isuserB = a.userid 
                                WHERE a.nik = '".$nik."'
                                ORDER BY b.audit DESC
                                LIMIT 1
                                ");	
    return $datakaryawan;
}

function tombolapprove($level, $direct_supervisor, $next_higher_supervisor, $app1, $app2, $app3){
    $user = Auth::user();
    if($user->hasRole('Supervisor')){
        if($level == 'Supervisor'){
            $tombol = 'nonaktif';
        }else{
            if($app1 == ''){
                $tombol = 'aktif';
            }else{
                $tombol = 'nonaktif';
            }
        }
    }else if($user->hasRole('Manager')){
        if($level == 'Manager'){
            if($app1 == ''){
                $tombol = 'aktif';
            }else{
                $tombol = 'nonaktif';
            }
        }else{
            if($direct_supervisor == $next_higher_supervisor){
                if($app1 == ''){
                    $tombol = 'aktif';
                }else{
                    $tombol = 'nonaktif';
                }
            }else{
                if($app1 == 'Y'){
                    if($app2 == ''){
                        $tombol = 'aktif';
                    }else{
                        $tombol = 'nonaktif';
                    }
                }else{
                    $tombol = 'nonaktif';
                }
            }
        }
    }else if($user->hasRole('Super Admin')){
        if($app2 == ''){
            $tombol = 'aktif';
        }else{
            $tombol = 'nonaktif';
        }
    }else if($user->hasRole('Staff') || $user->hasRole('Non Staff')){
        $tombol = 'nonaktif';
    }else{
        $tombol = 'nonaktif';
    }

    return $tombol;
}


function editjumlahcuti($userid, $istype, $tglcutiawal1, $tglcutiakhir1, $jumlah1, $tglcutiawal2, $tglcutiakhir2, $jumlah2){
    $tahun_ini = date('Y');
    if($istype != '4'){
        $getdata = Employee::where('userid', $userid)->get();
        foreach($getdata as $data){
            $nik = $data->nik;
        }
        
        $datahpcuti = HPcuti::where('isUser', $userid)
                            ->where('istype', $istype)
                            ->where('mulai', $tglcutiawal1)
                            ->where('akhir', $tglcutiakhir1)->get();
        foreach($datahpcuti as $data){
            $sebelum = $data->sebelum;
            $sesudah = $data->sesudah;
            $keterangan = $data->keterangan;
            $sesudah = $data->sesudah;
            $sebelum = $data->sebelum;
            $audit = $data->audit;
        }

        $getlastdata = DB::select('select * from hpcuti where isUser = "'.$userid.'" order by audit desc limit 1');
        foreach($getlastdata as $data){
            $auditlast = $data->audit;
        }

        if($jumlah2 > $jumlah1){
            $jumlahhariedit = $jumlah2 - $jumlah1;
            $inserthpcuti = new HPcuti;
            $inserthpcuti->isuser = $userid;
            $inserthpcuti->mulai = $tglcutiawal2;
            $inserthpcuti->akhir = $tglcutiakhir2;
            $inserthpcuti->istype = $istype;
            $inserthpcuti->jumlah = $jumlahhariedit;
            $inserthpcuti->keterangan = $keterangan;
            $inserthpcuti->sebelum = $sebelum;
            $inserthpcuti->sesudah = $sebelum - $jumlah2;
            $inserthpcuti->audit = $auditlast + 1;
            $inserthpcuti->save();
        }else{
        //    $updsesudah = ($sesudah + $jumlah1) - $jumlah2;
            $updsesudah = abs($sebelum) + $jumlah2;
            $update = DB::select('update hpcuti 
                                    set Jumlah = "'.$jumlah2.'",
                                    sesudah = "-'.$updsesudah.'",
                                    mulai = "'.$tglcutiawal2.' 00:00:00",
                                    akhir = "'.$tglcutiakhir2.' 00:00:00"
                                    where isUser = "'.$userid.'" 
                                    and istype = "'.$istype.'"
                                    and mulai = "'.$tglcutiawal1.'"
                                    and akhir = "'.$tglcutiakhir1.'"  ');
        
        }
        
    }else{
        $datahpcutibesar = HPcutibesar::where('isUser', $userid)
                            ->where('istype', $istype)
                            ->where('mulai', $tglcutiawal1)
                            ->where('akhir', $tglcutiakhir1)
                            ->where('Jumlah', $jumlah1)->get();
        foreach($datahpcutibesar as $data){
            $sebelum = $data->sebelumB;
            $sesudah = $data->sesudahB;
        }
        $updsesudahB = ($sesudah + $jumlah1) - $jumlah2;
        $update = DB::select('update hpcutibesar 
                                set JumlahB = "'.$jumlah2.'",
                                sesudahB = "'.$updsesudahB.'",
                                mulaiB = "'.$tglcutiawal2.' 00:00:00",
                                akhirB = "'.$tglcutiakhir2.' 00:00:00" 
                                where isUserB = "'.$userid.'" 
                                and istypeB = "'.$istype.'"
                                and mulaiB = "'.$tglcutiawal1.'"
                                and akhirB = "'.$tglcutiakhir1.'"
                                and JumlahB = "'.$jumlah1.'"
                                ');
    }
}

function editcutilain($userid, $istype, $penjelasancuti1, $penjelasan_cuti2){
    if($istype != '4'){
        $update = DB::select('update hpcuti 
                                set keterangan = "'.$penjelasan_cuti2.'"
                                where keterangan = "'.$penjelasancuti1.'"
                                and isUser = "'.$userid.'" ');
    }else{
        $update = DB::select('update hpcutibesar 
                                set keteranganB = "'.$penjelasan_cuti2.'"
                                where keteranganB = "'.$penjelasancuti1.'"
                                and isUser = "'.$userid.'"  
                                ');
    }
}

function updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil) {
    $tahun = Carbon::parse($mulai)->format('Y');
    $tahun_ini = date('Y');
    $tahun_lalu = $tahun_ini - 1;

    $data_user = DB::select("select * from employees where userid = '".$userid."' ");
    foreach($data_user as $datauser){
        $nik = $datauser->nik;
        $nama_karyawan = $datauser->nama;

    } 


    if($istype != '4'){
        if($istype != '17'){
            $cek_hpcuti = HPcuti::where('isuser', $userid)->count();
            $jumlah = $cek_hpcuti;
            if($jumlah > 0){
                $hp_cuti = DB::select('select * from hpcuti 
                                        where isuser = "'.$userid.'" 
                                        order by cutiid desc limit 1');
                foreach($hp_cuti as $hpcuti){
                    $sebelum = $hpcuti->sebelum;
                    $sesudah = $hpcuti->sesudah;
                    $audit = $hpcuti->audit;
                    $audit2 = $audit + 1;

                    $inserthpcuti = new HPcuti;
                    $inserthpcuti->isuser = $userid;
                    $inserthpcuti->mulai = $mulai;
                    $inserthpcuti->akhir = $akhir;
                    $inserthpcuti->istype = $istype;
                    $inserthpcuti->jumlah = $jumlah_diambil;
                    $inserthpcuti->keterangan = $keterangan;
                    $inserthpcuti->sebelum = $sesudah;
                    $inserthpcuti->sesudah = $sesudah - $jumlah_diambil;
                    $inserthpcuti->audit = $audit2;
                }
                    $inserthpcuti->save();
            }else{
                $inserthpcuti = new HPcuti;
                $inserthpcuti->isuser = $userid;
                $inserthpcuti->mulai = $mulai;
                $inserthpcuti->akhir = $akhir;
                $inserthpcuti->istype = $istype;
                $inserthpcuti->jumlah = $jumlah_diambil;
                $inserthpcuti->keterangan = $keterangan;
                $inserthpcuti->sebelum = 0;
                $inserthpcuti->sesudah = 0 - $jumlah_diambil;
                $inserthpcuti->audit = '1';
        
                $inserthpcuti->save();
            }
        }
    }else{
        $cek_hpcuti = HPcutibesar::where('isUserB', $userid)->count();
        $jumlah = $cek_hpcuti;
        if($jumlah > 0){
        /*    $hp_cuti = HPcutibesar::where('isUserB', $userid)
                            ->orderBy('cutiIDB', 'DESC')
                            ->first();  */
            $hp_cuti = DB::select("select * from hpcutibesar
                                 where isUserB = '".$userid."' 
                                 order by cutiIDB desc limit 1");
            foreach($hp_cuti as $hpcuti){
                $sebelum = $hpcuti->sebelumB;
                $sesudah = $hpcuti->sesudahB;
                $audit = $hpcuti->auditB;
                $audit2 = $auditB + 1;

                $inserthpcuti = new HPcutibesar;
                $inserthpcuti->isUserB = $userid;
                $inserthpcuti->mulaiB = $mulai;
                $inserthpcuti->akhirB = $akhir;
                $inserthpcuti->istypeB = $istype;
                $inserthpcuti->jumlahB = $jumlah_diambil;
                $inserthpcuti->keteranganB = $keterangan;
                $inserthpcuti->sebelumB = $sesudah;
                $inserthpcuti->sesudahB = $sesudah - $jumlah_diambil;
                $inserthpcuti->auditB = $audit2;
        
            }
                $inserthpcuti->save();
        }else{
            $inserthpcuti = new HPcutibesar;
            $inserthpcuti->isuserB = $userid;
            $inserthpcuti->mulaiB = $mulai;
            $inserthpcuti->akhirB = $akhir;
            $inserthpcuti->istypeB = $istype;
            $inserthpcuti->jumlahB = $jumlah_diambil;
            $inserthpcuti->keteranganB = $keterangan;
            $inserthpcuti->sebelumB = 0;
            $inserthpcuti->sesudahB = 0 - $jumlah_diambil;
            $inserthpcuti->auditB = '1';
    
            $inserthpcuti->save();
        } 
    }
}