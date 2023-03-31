<?php

namespace App\Imports;

use DateTime;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Ijin;
use App\Models\Lembur;
use App\Models\Employee;
use App\Models\Absensi;
use App\Models\Departement;
use App\Models\Schedule;
use App\Models\ShiftSchedule;
use App\Models\NonshiftSchedule;
use App\Models\MstNonshiftSchedules;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
// use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ImportAbsen implements ToCollection, WithHeadingRow
{
    use Importable;
    public function forEvent($data)
    {
        $this->data = $data;
        return $this;
    }
    public function collection(Collection $rows)
    {
        $a_date = $this->data->year."-".$this->data->month."-01";
        $lastDay = date("t", strtotime($a_date));
        $todate = $this->data->year."-".$this->data->month."-".$lastDay;
        // $cekAbsensi = Absensi::where('bulan',$this->data->month)->where('tahun',$this->data->year)->get();
        // if($cekAbsensi){
        //     Absensi::where('bulan',$this->data->month)->where('tahun',$this->data->year)->delete();
        // }
        /*INSERT ABSEN GENERAL MANAGER*/
        $gm = Employee::where('jabatan','General Manager')->first();
        $jadwalGMs = NonshiftSchedule::where('nik',$gm->nik)->whereBetween('date',[$a_date,$todate])->get();
            // \Log::debug('nik,fromdate,todate '$);
        if(count($jadwalGMs)>0){
            \Log::debug('ada jadwal');
            $cekabsenGM = Absensi::where('nik',$gm->nik)->where('bulan',$this->data->month)
                            ->where('tahun',$this->data->year)->get();
            if(count($cekabsenGM)>0){
                \Log::debug('delete ada jadwal');
                Absensi::where('nik',$gm->nik)->where('bulan',$this->data->month)
                    ->where('tahun',$this->data->year)->delete();
            }
            foreach ($jadwalGMs as $jadwalGM) {
                // \Log::debug('sccode '.$jadwalGM->schedule_code);
                $mstnonshift = MstNonshiftSchedules::where('id',$jadwalGM->schedule_code)->first();
                // $cekCuti = Cuti::where('tgl_cuti_awal',)
                $cekIjin = Ijin::where('nik',$gm->nik)->whereBetween('tgl_ijin_awal',[$jadwalGM->date." 00:00",$jadwalGM->date." 23:59"])->where('app2','Y')->first();
                $cekLembur = Lembur::where('nik',$gm->nik)->whereBetween('tgl_lembur_awal',[$jadwalGM->date." 00:00",$jadwalGM->date." 23:59"])->where('app2','Y')->first();
                if($cekIjin){
                    \Log::debug('Ada Ijin');
                    if($cekIjin->tindak_lanjut == 'EXTRA OFF'){
                    \Log::debug('Ijin Extra OFF');
                        $wjm = NULL;
                        $wjk = NULL;
                        $mrly = 0;
                        $mlate = 0;
                        $mleft = 0;
                        $prly = 0;
                        $plate = 0;
                        $wkhr = 0;
                        $ketabs = 'Extra Off';
                    }elseif($cekIjin->tindak_lanjut == 'POTONG CUTI'){
                    \Log::debug('Potong Cuti');
                        $wjm = NULL;
                        $wjk = NULL;
                        $mrly = 0;
                        $mlate = 0;
                        $mleft = 0;
                        $prly = 0;
                        $plate = 0;
                        $wkhr = 0;
                        $ketabs = 'Ijin';
                        updatecuti($gm->userid,1,'Cuti Dari Absensi',$jadwalGM->date,$jadwalGM->date,1);
                    }else{
                    \Log::debug('Else');
                        $wjm = NULL;
                        $wjk = NULL;
                        $mrly = 0;
                        $mlate = 0;
                        $mleft = 0;
                        $prly = 0;
                        $plate = 0;
                        $wkhr = 0;
                        $ketabs = 'Ijin';
                    }
                }elseif($cekLembur){
                    \Log::debug('Ada Lembur');
                    $time = explode(':', $cekLembur->lama_lembur);
                    $mins = ($time[0]*60) + ($time[1]);
                    $wjm = Carbon::parse($mstnonshift->time_schedule_awal)->format('H:i');
                    $wjk = Carbon::parse($mstnonshift->time_schedule_akhir)->format('H:i');
                    $wkhr = getWKHR($jadwalGM->date,$mstnonshift->time_schedule_awal,$mstnonshift->time_schedule_akhir);
                    $mrly = 0;
                    $mlate = 0;
                    $mleft = 0;
                    $prly = 0;
                    $plate = $mins;
                    $wkhr = $wkhr;
                    $ketabs = NULL;
                }else{
                    \Log::debug('Else Akhir');
                    $wjm = Carbon::parse($mstnonshift->time_schedule_awal)->format('H:i');
                    $wjk = Carbon::parse($mstnonshift->time_schedule_akhir)->format('H:i');
                    $wkhr = getWKHR($jadwalGM->date,$mstnonshift->time_schedule_awal,$mstnonshift->time_schedule_akhir);
                    $mrly = 0;
                    $mlate = 0;
                    $mleft = 0;
                    $prly = 0;
                    $plate = 0;
                    $wkhr = $wkhr;
                    $ketabs = NULL;
                }
                $absensi = new Absensi;
                $absensi->date = $jadwalGM->date;
                $absensi->nik = $gm->nik;
                $absensi->dept_id = $gm->dept_id;
                $absensi->wjm = $wjm;
                $absensi->wjk = $wjk;
                $absensi->mrly = $mrly;
                $absensi->mlate = $mlate;
                $absensi->mleft = $mleft;
                $absensi->prly = $prly;
                $absensi->plate = $plate;
                $absensi->wkhr = $wkhr;
                $absensi->keterangan = $ketabs;
                $absensi->bulan = $this->data->month;
                $absensi->tahun = $this->data->year;
                $absensi->save();
                /*SAVE*/
            }
        }
        /*END*/
        foreach ($rows as $key=>$row) 
        {
            $employee = Employee::where('nik',$row['id'])->first();
            /*0702*/
            $cekAbsensi = Absensi::where('bulan',$this->data->month)
                            ->where('tahun',$this->data->year)->where('nik',$row['id'])
                            ->where('date',transformDate($row['tgl']))->get();
            if($cekAbsensi){
                Absensi::where('bulan',$this->data->month)->where('tahun',$this->data->year)
                        ->where('nik',$row['id'])->where('date',transformDate($row['tgl']))->delete();
            }
            /*end*/
            if(!empty($employee)){
                if($employee->shifting == 'Y'){
                    $shiftSchedule = ShiftSchedule::where('dept',$employee->dept_id)->where('nik',$row['id'])
                                        ->where('date',transformDate($row['tgl']))->first();
                    if(empty($shiftSchedule)){
                        $code = Schedule::where('dept_id',$employee->dept_id)
                                        ->orderBy('code','asc')->pluck('code')->first();
                        $add = new ShiftSchedule;
                        $add->nik = $row['id'];
                        $add->dept = $employee->dept_id;
                        $add->date = transformDate($row['tgl']);
                        $add->schedule_code = $code;
                        $add->save();
                        $shiftSchedule = ShiftSchedule::where('dept',$employee->dept_id)->where('nik',$row['id'])
                                            ->where('date',transformDate($row['tgl']))->first();
                        $schedule = Schedule::where('dept_id',$shiftSchedule->dept)
                                        ->where('code',$shiftSchedule->schedule_code)->first();
                    }else{
                        $schedule = Schedule::where('dept_id',$shiftSchedule->dept)
                                        ->where('code',$shiftSchedule->schedule_code)->first();
                    }
                }else{
                    $nonshiftSchedule = NonshiftSchedule::where('nik',$row['id'])->where('dept',$employee->dept_id)
                                            ->where('date',transformDate($row['tgl']))->first();
                    if(empty($nonshiftSchedule)){
                        $code = MstNonshiftSchedules::whereNull('dept_id')->where('sabtu_masuk','Y')
                                        ->orderBy('code','desc')->pluck('id')->first();
                        $add = new NonshiftSchedule;
                        $add->nik = $row['id'];
                        $add->dept = $employee->dept_id;
                        $add->date = transformDate($row['tgl']);
                        $add->schedule_code = $code;
                        $add->save();
                        $nonshiftSchedule = NonshiftSchedule::where('nik',$row['id'])->where('dept',$employee->dept_id)
                                                ->where('date',transformDate($row['tgl']))->first();
                        $schedule = MstNonshiftSchedules::where('id',$nonshiftSchedule->schedule_code)->first();
                    }else{
                        $schedule = MstNonshiftSchedules::where('id',$nonshiftSchedule->schedule_code)->first();
                    }
                }
                
                $time_schedule_awal = Carbon::parse($schedule->time_schedule_awal)->format('H:i');
                $time_schedule_akhir = Carbon::parse($schedule->time_schedule_akhir)->format('H:i');

                if (!empty($row['wjm'])) {
                    $explode = explode("-", $row['wjm']);
                    if(!empty($explode[1])){
                        if(empty($row['ketabs'])){
                            $wjm = substr($explode[0], 0,2).":".substr($explode[0], 2,2); 
                            $wjk = substr($explode[1], 0,2).":".substr($explode[1], 2,2);
                            $checkAbsensi = Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])->first();
                            if(!empty($checkAbsensi)){
                                if($checkAbsensi->wjk > $wjk){
                                    //mlate
                                    $time = new DateTime($time_schedule_awal);
                                    $timeStop = new DateTime($wjm);
                                    if ($timeStop > $time) {
                                        $diff = $timeStop->diff($time);
                                        $mlate = $diff->format('%H:%I'); // hours minutes
                                        $mlate    = explode(':', $mlate);
                                        $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                        $mrly = 0;
                                    }else{
                                        $mlate = 0;
                                        $diff = $timeStop->diff($time);
                                        $mrly = $diff->format('%H:%I'); // hours minutes
                                        $mrly    = explode(':', $mrly);
                                        $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                                    }
                                    if ($mlate > 180) {
                                        //Jika Telat atau pulang cepat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                        $ketabs = 'Cuti 0.5';
                                        cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                                        Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                            ->update(['keterangan'=>$ketabs]);
                                    }
                                    $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                                    $mleft=$wkhr-$mlate;
                                    Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                            ->update(['mrly'=>$mrly,'wjm'=>$wjm,'mleft'=>$mleft]);
                                }else{

                                }
                            }else{
                                //mlate
                                $time = new DateTime($time_schedule_awal);
                                $timeStop = new DateTime($wjm);
                                if ($timeStop > $time) {
                                    $diff = $timeStop->diff($time);
                                    $mlate = $diff->format('%H:%I'); // hours minutes
                                    $mlate    = explode(':', $mlate);
                                    $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                    $mrly = 0;
                                }else{
                                    $mlate = 0;
                                    $diff = $timeStop->diff($time);
                                    $mrly = $diff->format('%H:%I'); // hours minutes
                                    $mrly    = explode(':', $mrly);
                                    $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                                }
                                //prly
                                $timeAkhir = new DateTime($time_schedule_akhir);
                                $timeStopAkhir = new DateTime($wjk);
                                if ($timeStopAkhir < $timeAkhir) {
                                    $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                    $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                    $prly    = explode(':', $prly);
                                    $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                    $plate = 0;
                                }else{
                                    $prly = 0;
                                    $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                    $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                    $plate    = explode(':', $plate);
                                    $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                                }
                                /*CEK TABLE ijin*/
                                $lembur = Lembur::where('nik',$row['id'])
                                            ->whereBetween('tgl_lembur_awal',[Carbon::parse(transformDate($row['tgl']))->format('Y-m-d')." 00:00",Carbon::parse(transformDate($row['tgl']))->format('Y-m-d')." 23:59"])
                                            ->where('app2','Y')->first();
                                if(!empty($lembur)){
                                    $mrly=0;
                                    $mlate=0;
                                    $mleft=0;
                                    $prly=0;
                                    $plate=0;
                                }
                                /*END CEK*/
                                if (($mlate > 180) || ($prly > 180)) {
                                    //Jika Telat atau pulang cepat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                    $ketabs = 'Cuti 0.5';
                                    cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                                }else{
                                    $ketabs = $row['ketabs'];
                                }
                                //mleft
                                $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                                $mleft=$wkhr-$mlate;
                                /*SAVE*/
                                $absensi = new Absensi;
                                $absensi->date = transformDate($row['tgl']);
                                $absensi->nik = $row['id'];
                                $absensi->dept_id = $employee->dept_id;
                                $absensi->wjm = $wjm;
                                $absensi->wjk = $wjk;
                                $absensi->mrly = $mrly;
                                $absensi->mlate = $mlate;
                                $absensi->mleft = $mleft;
                                $absensi->prly = $prly;
                                $absensi->plate = $plate;
                                $absensi->wkhr = $wkhr;
                                $absensi->keterangan = $ketabs;
                                $absensi->bulan = $this->data->month;
                                $absensi->tahun = $this->data->year;
                                if (!empty($row['id'])) {
                                    $absensi->save();
                                }
                                /*SAVE*/
                            }
                        }elseif($row['ketabs'] == 'Ijin'){
                            $wjm = substr($explode[0], 0,2).":".substr($explode[0], 2,2); 
                            $wjk = substr($explode[1], 0,2).":".substr($explode[1], 2,2);
                            $checkAbsensi = Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])->first();
                            if(empty($checkAbsensi)){ //Belum ada data
                                //mlate
                                $time = new DateTime($time_schedule_awal);
                                $timeStop = new DateTime($wjm);
                                if ($timeStop > $time) {
                                    $diff = $timeStop->diff($time);
                                    $mlate = $diff->format('%H:%I'); // hours minutes
                                    $mlate    = explode(':', $mlate);
                                    $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                    $mrly = 0;
                                }else{
                                    $mlate = 0;
                                    $diff = $timeStop->diff($time);
                                    $mrly = $diff->format('%H:%I'); // hours minutes
                                    $mrly    = explode(':', $mrly);
                                    $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                                }
                                //prly
                                $timeAkhir = new DateTime($time_schedule_akhir);
                                $timeStopAkhir = new DateTime($wjk);
                                if ($timeStopAkhir < $timeAkhir) {
                                    $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                    $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                    $prly    = explode(':', $prly);
                                    $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                    $plate=0;
                                }else{
                                    $prly = 0;
                                    $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                    $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                    $plate    = explode(':', $plate);
                                    $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                                }
                                if (($mlate > 180) || ($prly > 180)) {
                                    //Jika Telat atau pulang cepat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                    $ketabs = 'Cuti 0.5';
                                    cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                                }else{
                                    $ketabs = $row['ketabs'];
                                }
                                //mleft
                                $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                                $mleft=$wkhr-$mlate;
                                /*SAVE*/
                                $absensi = new Absensi;
                                $absensi->date = transformDate($row['tgl']);
                                $absensi->nik = $row['id'];
                                $absensi->dept_id = $employee->dept_id;
                                $absensi->wjm = $wjm;
                                $absensi->wjk = $wjk;
                                $absensi->mrly = $mrly;
                                $absensi->mlate = $mlate;
                                $absensi->mleft = $mleft;
                                $absensi->prly = $prly;
                                $absensi->plate = $plate;
                                $absensi->wkhr = $wkhr;
                                $absensi->keterangan = $ketabs;
                                $absensi->bulan = $this->data->month;
                                $absensi->tahun = $this->data->year;
                                if (!empty($row['id'])) {
                                    $absensi->save();
                                }
                                /*SAVE*/
                            }
                        }elseif($row['ketabs']=='Cuti 0.5'){
                            $wjm = substr($explode[0], 0,2).":".substr($explode[0], 2,2); 
                            $wjk = substr($explode[1], 0,2).":".substr($explode[1], 2,2);
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;

                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            if (($mlate > 180) || ($prly > 180)) {
                                //Jika Telat atau pulang cepat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                $ketabs = 'Cuti 0.5';
                                cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                            }else{
                                $ketabs = $row['ketabs'];
                                cuti($employee->userid,1,'Cuti',transformDate($row['tgl']),transformDate($row['tgl']),1); //update sisa cuti
                            }
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;
                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            /*SAVE*/
                        }elseif($row['ketabs']=='Extra Off 0.5'){
                            $wjm = substr($explode[0], 0,2).":".substr($explode[0], 2,2); 
                            $wjk = substr($explode[1], 0,2).":".substr($explode[1], 2,2);
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;
                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            $ketabs = $row['ketabs'];
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;
                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            /*SAVE*/
                        }
                    }else{ //explode[1] null
                        $jam = substr($explode[0], 0,2).":".substr($explode[0], 2,2);
                        if(empty($row['ketabs'])){
                            $checkAbsensi = Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])->first();
                            if(!empty($checkAbsensi)){
                                $jams = new DateTime($jam);
                                //Get Range Jam Masuk
                                $time_schedule_awals = new DateTime($time_schedule_awal);
                                $rangeJamMasuk = $jams->diff($time_schedule_awals);
                                $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                                //Get Range Jam Keluar
                                $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                                $rangeJamKeluar = $jams->diff($time_schedule_akhirs);
                                $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                                if($rangeJamMasuk > $rangeJamKeluar){ //dianggaap jam keluar
                                    //prly
                                    $timeAkhir = new DateTime($time_schedule_akhir);
                                    $timeStopAkhir = new DateTime($jam);
                                    if ($timeStopAkhir < $timeAkhir) {
                                        $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                        $prly = $diffAkhir->format('%H:%I');
                                        $prly    = explode(':', $prly);
                                        $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                        $plate=0;
                                    }else{
                                        $prly = 0;
                                        $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                        $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                        $plate    = explode(':', $plate);
                                        $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                                    }
                                    Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                            ->update(['wjk'=>$jam,'prly'=>$prly,'plate'=>$plate]);
                                }
                            }else{
                                if(empty($row['ketabs'])){ //TIDAK ADA JAM MASUK ATAU JAM KELUAR TETAPI TIDAK ADA KETERANGAN
                                    $jams = new DateTime($jam);
                                    //Get Range Jam Masuk
                                    $time_schedule_awals = new DateTime($time_schedule_awal);
                                    $rangeJamMasuk = $jams->diff($time_schedule_awals);
                                    $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                                    //Get Range Jam Keluar
                                    $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                                    $rangeJamKeluar = $jams->diff($time_schedule_akhirs);
                                    $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                                    if($rangeJamMasuk > $rangeJamKeluar){ //dianggaap jam keluar
                                        $wjk = $jam;
                                        $wjm = $time_schedule_awal;
                                    }else{
                                        $wjm = $jam;
                                        $wjk = $time_schedule_akhir;
                                    }
                                    //mlate
                                    $time = new DateTime($time_schedule_awal);
                                    $timeStop = new DateTime($wjm);
                                    if ($timeStop > $time) {
                                        $diff = $timeStop->diff($time);
                                        $mlate = $diff->format('%H:%I'); // hours minutes
                                        $mlate    = explode(':', $mlate);
                                        $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                        $mrly=0;
                                    }else{
                                        $mlate = 0;
                                        $diff = $timeStop->diff($time);
                                        $mrly = $diff->format('%H:%I'); // hours minutes
                                        $mrly    = explode(':', $mrly);
                                        $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                                    }
                                    
                                    //prly
                                    $timeAkhir = new DateTime($time_schedule_akhir);
                                    $timeStopAkhir = new DateTime($wjk);
                                    if ($timeStopAkhir < $timeAkhir) {
                                        $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                        $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                        $prly    = explode(':', $prly);
                                        $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                        $prly=0;
                                    }else{
                                        $prly = 0;
                                        $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                        $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                        $plate    = explode(':', $plate);
                                        $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                                    }
                                    if (($mlate > 180) || ($prly > 180)) {
                                        //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                        $ketabs = 'Cuti 0.5';
                                        cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                                    }else{
                                        $ketabs = $row['ketabs'];
                                    }
                                    //mleft
                                    $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                                    $mleft=$wkhr-$mlate;

                                    /*SAVE*/
                                    $absensi = new Absensi;
                                    $absensi->date = transformDate($row['tgl']);
                                    $absensi->nik = $row['id'];
                                    $absensi->dept_id = $employee->dept_id;
                                    $absensi->wjm = $wjm;
                                    $absensi->wjk = $wjk;
                                    $absensi->mrly = $mrly;
                                    $absensi->mlate = $mlate;
                                    $absensi->mleft = $mleft;
                                    $absensi->prly = $prly;
                                    $absensi->plate = $plate;
                                    $absensi->wkhr = $wkhr;
                                    $absensi->keterangan = $ketabs;
                                    $absensi->bulan = $this->data->month;
                                    $absensi->tahun = $this->data->year;
                                    if (!empty($row['id'])) {
                                        $absensi->save();
                                    }
                                    /*SAVE*/
                                }
                            }
                        }elseif($row['ketabs']=='Ijin'){
                            $jams = new DateTime($jam);
                            //Get Range Jam Masuk
                            $time_schedule_awals = new DateTime($time_schedule_awal);
                            $rangeJamMasuk = $jams->diff($time_schedule_awals);
                            $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                            //Get Range Jam Keluar
                            $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                            $rangeJamKeluar = $jams->diff($time_schedule_akhirs);
                            $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                            if($rangeJamMasuk > $rangeJamKeluar){ //dianggaap jam keluar
                                $wjk = $jam;
                                $wjm = date('H:i', strtotime('+3 hours', strtotime($time_schedule_awal)));
                            }else{
                                $wjm = $jam;
                                $wjk = date('H:i', strtotime('-3 hours', strtotime($time_schedule_akhir)));
                            }
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;
                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            if (($mlate > 180) || ($prly > 180)) {
                                //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                $ketabs = 'Cuti 0.5';
                                cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                            }else{
                                $ketabs = $row['ketabs'];
                            }
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;

                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            /*SAVE*/
                        }elseif($row['ketabs']=='Cuti 0.5'){
                            $jams = new DateTime($jam);
                            //Get Range Jam Masuk
                            $time_schedule_awals = new DateTime($time_schedule_awal);
                            $rangeJamMasuk = $jams->diff($time_schedule_awals);
                            $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                            //Get Range Jam Keluar
                            $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                            $rangeJamKeluar = $jams->diff($time_schedule_akhirs);
                            $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                            if($rangeJamMasuk > $rangeJamKeluar){ //dianggaap jam keluar
                                $wjk = $jam;
                                $time = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir)/2;
                                $hours = floor($time / 60);
                                $minutes = ($time % 60);
                                $minhour = sprintf('%01d hours', $hours, $minutes);
                                
                                $wjm = date_add(new DateTime($time_schedule_awal),date_interval_create_from_date_string('+'.$minhour))->format('H:i');
                            }else{
                                $wjm = $jam;
                                $time = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir)/2;
                                $hours = floor($time / 60);
                                $minutes = ($time % 60);
                                $minhour = sprintf('%01d hours', $hours, $minutes);
                                
                                $wjk = date_add(new DateTime($time_schedule_akhir),date_interval_create_from_date_string('-'.$minhour))->format('H:i');
                            }
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;
                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            if (($mlate > 180) || ($prly > 180)) {
                                //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                $ketabs = 'Cuti 0.5';
                                cuti($employee->userid,1,'Terlambat Lebih 3 Jam',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                            }else{
                                cuti($employee->userid,1,'Cuti',transformDate($row['tgl']),transformDate($row['tgl']),0.5); //update sisa cuti
                                $ketabs = $row['ketabs'];
                            }
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;

                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                        }elseif($row['ketabs']=='Extra Off 0.5'){
                            $jams = new DateTime($jam);
                            //Get Range Jam Masuk
                            $time_schedule_awals = new DateTime($time_schedule_awal);
                            $rangeJamMasuk = $jams->diff($time_schedule_awals);
                            $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                            //Get Range Jam Keluar
                            $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                            $rangeJamKeluar = $jams->diff($time_schedule_akhirs);
                            $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                            if($rangeJamMasuk > $rangeJamKeluar){ //dianggaap jam keluar
                                $wjk = $jam;
                                $wjm = $time_schedule_awal;
                            }else{
                                $wjm = $jam;
                                $wjk = $time_schedule_akhir;
                            }
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;
                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            $ketabs = $row['ketabs'];
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;

                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            /*SAVE*/
                        }elseif($row['ketabs']=='Dinas diluar'){
                            $jams = new DateTime($jam);
                            //Get Range Jam Masuk
                            $time_schedule_awals = new DateTime($time_schedule_awal);
                            $rangeJamMasuk = $jams->diff($time_schedule_awals);
                            $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                            //Get Range Jam Keluar
                            $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                            $rangeJamKeluar = $jams->diff($time_schedule_akhirs);
                            $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                            if($rangeJamMasuk > $rangeJamKeluar){ //dianggaap jam keluar
                                $wjk = $jam;
                                $wjm = $time_schedule_awal;
                            }else{
                                $wjm = $jam;
                                $wjk = $time_schedule_akhir;
                            }
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;
                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            $ketabs = $row['ketabs'];
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;

                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            /*SAVE*/
                        }
                    }
                }else{ //Tidak ada wjm
                    $checkAbsensi = Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])->first();
                    if(empty($checkAbsensi)){
                        if(($row['ketabs'] == 'Dinas diluar') || ($row['ketabs'] == 'Extra Off')){
                            $wjm = $time_schedule_awal;
                            $wjk = $time_schedule_akhir;
                            //mlate
                            $time = new DateTime($time_schedule_awal);
                            $timeStop = new DateTime($wjm);
                            if ($timeStop > $time) {
                                $diff = $timeStop->diff($time);
                                $mlate = $diff->format('%H:%I'); // hours minutes
                                $mlate    = explode(':', $mlate);
                                $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                $mrly=0;
                            }else{
                                $mlate = 0;
                                $diff = $timeStop->diff($time);
                                $mrly = $diff->format('%H:%I'); // hours minutes
                                $mrly    = explode(':', $mrly);
                                $mrly = ($mrly[0] * 60.0 + $mrly[1] * 1.0);
                            }
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                $plate=0;
                            }else{
                                $prly = 0;
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $plate = $diffAkhir->format('%H:%I'); // hours minutes
                                $plate    = explode(':', $plate);
                                $plate = ($plate[0] * 60.0 + $plate[1] * 1.0);
                            }
                            $ketabs = $row['ketabs'];
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;
                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            /*SAVE*/
                        }elseif(in_array($row['ketabs'], ['Sakit','sakit','Cuti','cuti','Alpa'])){
                            $wjm = $row['wjm'];
                            $wjk = $row['wjm'];
                            //mlate
                            $mrly = 0;
                            $mlate = 0;
                            $prly = 0;
                            $plate = 0;
                            if(in_array($row['ketabs'], ['Sakit','sakit'])){
                                $getDate = transformDate($row['tgl'])->format('Y-m-d');
                                $getDays = getSatDays($getDate);
                                if(in_array($getDate, $getDays)){
                                    $ketabs = 'Sakit 0.5';
                                }else{
                                    $ketabs = 'Sakit';
                                }
                            }elseif(in_array($row['ketabs'], ['Cuti','cuti','Alpa'])){
                                $ketabs = 'Cuti'; //Jika $row['ketabs'] == cuti
                                cuti($employee->userid,1,'Cuti',transformDate($row['tgl']),transformDate($row['tgl']),1);
                            }else{
                                $ketabs= $row['ketabs'];
                            }
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;
                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                        }elseif($row['ketabs'] == 'Cuti 0.5'){
                            $getDate = transformDate($row['tgl'])->format('Y-m-d');
                            $getDays = getSatDays($getDate);
                            if(in_array($getDate, $getDays)){ //Cuti Hari Sabtu
                                $wjm = $row['wjm'];
                                $wjk = $row['wjm'];
                                //mlate
                                $mrly = 0;
                                $mlate = 0;
                                $prly = 0;
                                $plate = 0;
                                $ketabs = $row['ketabs'];
                                //mleft
                                $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                                $mleft=$wkhr-$mlate;
                                /*SAVE*/
                                $absensi = new Absensi;
                                $absensi->date = transformDate($row['tgl']);
                                $absensi->nik = $row['id'];
                                $absensi->dept_id = $employee->dept_id;
                                $absensi->wjm = $wjm;
                                $absensi->wjk = $wjk;
                                $absensi->mrly = $mrly;
                                $absensi->mlate = $mlate;
                                $absensi->mleft = $mleft;
                                $absensi->prly = $prly;
                                $absensi->plate = $plate;
                                $absensi->wkhr = $wkhr;
                                $absensi->keterangan = $ketabs;
                                $absensi->bulan = $this->data->month;
                                $absensi->tahun = $this->data->year;
                                if (!empty($row['id'])) {
                                    $absensi->save();
                                }
                                cuti($employee->userid,1,'Cuti',transformDate($row['tgl']),transformDate($row['tgl']),0.5);
                            }else{ //DIANGGAP CUTI SEHARI
                                $wjm = $row['wjm'];
                                $wjk = $row['wjm'];
                                //mlate
                                $mrly = 0;
                                $mlate = 0;
                                $prly = 0;
                                $plate = 0;
                                $ketabs = 'Cuti';
                                //mleft
                                $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                                $mleft=$wkhr-$mlate;
                                /*SAVE*/
                                $absensi = new Absensi;
                                $absensi->date = transformDate($row['tgl']);
                                $absensi->nik = $row['id'];
                                $absensi->dept_id = $employee->dept_id;
                                $absensi->wjm = $wjm;
                                $absensi->wjk = $wjk;
                                $absensi->mrly = $mrly;
                                $absensi->mlate = $mlate;
                                $absensi->mleft = $mleft;
                                $absensi->prly = $prly;
                                $absensi->plate = $plate;
                                $absensi->wkhr = $wkhr;
                                $absensi->keterangan = $ketabs;
                                $absensi->bulan = $this->data->month;
                                $absensi->tahun = $this->data->year;
                                if (!empty($row['id'])) {
                                    $absensi->save();
                                }
                                cuti($employee->userid,1,'Cuti',transformDate($row['tgl']),transformDate($row['tgl']),1);
                            }
                        }elseif($row['ketabs'] == 'Cuti PP'){ //CUTI PP
                            $wjm = $row['wjm'];
                            $wjk = $row['wjm'];
                            //mlate
                            $mrly = 0;
                            $mlate = 0;
                            $prly = 0;
                            $plate = 0;
                            $ketabs = $row['ketabs'];
                            //mleft
                            $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;
                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mrly = $mrly;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
                            $absensi->plate = $plate;
                            $absensi->wkhr = $wkhr;
                            $absensi->keterangan = $ketabs;
                            $absensi->bulan = $this->data->month;
                            $absensi->tahun = $this->data->year;
                            if (!empty($row['id'])) {
                                $absensi->save();
                            }
                            cuti($employee->userid,5,'Cuti PP',transformDate($row['tgl']),transformDate($row['tgl']),1); //update sisa cuti
                        }
                    }else{
                        $wjm = $row['wjm'];
                        $wjk = $row['wjm'];
                        //mlate
                        $mrly = 0;
                        $mlate = 0;
                        $prly = 0;
                        $plate = 0;
                        $ketabs = 'Cuti';
                        //mleft
                        $wkhr = getWKHR(transformDate($row['tgl'])->format('Y-m-d'),$time_schedule_awal,$time_schedule_akhir);
                        $mleft=$wkhr-$mlate;
                        /*SAVE*/
                        $absensi = new Absensi;
                        $absensi->date = transformDate($row['tgl']);
                        $absensi->nik = $row['id'];
                        $absensi->dept_id = $employee->dept_id;
                        $absensi->wjm = $wjm;
                        $absensi->wjk = $wjk;
                        $absensi->mrly = $mrly;
                        $absensi->mlate = $mlate;
                        $absensi->mleft = $mleft;
                        $absensi->prly = $prly;
                        $absensi->plate = $plate;
                        $absensi->wkhr = $wkhr;
                        $absensi->keterangan = $ketabs;
                        $absensi->bulan = $this->data->month;
                        $absensi->tahun = $this->data->year;
                        if (!empty($row['id'])) {
                            $absensi->save();
                        }
                        cuti($employee->userid,1,'Cuti',transformDate($row['tgl']),transformDate($row['tgl']),1,'N');
                    }
                    
                }
            }
        }
        
    }


    public function headingRow(): int
    {
        return 1;
    }
}