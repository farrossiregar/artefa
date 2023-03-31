<?php

namespace App\Imports;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Departement;
use App\Models\Schedule;
use App\Models\ShiftSchedule;
use App\Models\NonshiftSchedule;
use App\Models\MstNonshiftSchedules;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class AbsensiImport implements ToCollection, WithHeadingRow
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

        $cekAbsensi = Absensi::where('bulan',$this->data->month)->where('tahun',$this->data->year)->get();
        if($cekAbsensi){
            Absensi::where('bulan',$this->data->month)->where('tahun',$this->data->year)->delete();
        }
        foreach ($rows as $key=>$row) 
        {
            $employee = Employee::where('nik',$row['id'])->first();
            if(!empty($employee)){
                if($employee->shifting == 'Y'){
                    $shiftSchedule = ShiftSchedule::where('dept',$employee->dept_id)->where('nik',$row['id'])
                                        ->where('date',transformDate($row['tgl']))->first();
                    $schedule = Schedule::where('dept_id',$shiftSchedule->dept)
                                        ->where('code',$shiftSchedule->schedule_code)->first();
                }else{
                    $nonshiftSchedule = NonshiftSchedule::where('nik',$row['id'])->where('dept',$employee->dept_id)
                                            ->where('date',transformDate($row['tgl']))->first();
                    $schedule = MstNonshiftSchedules::where('id',$nonshiftSchedule->schedule_code)->first();
                }
                
                $time_schedule_awal = Carbon::parse($schedule->time_schedule_awal)->format('H:i');
                $time_schedule_akhir = Carbon::parse($schedule->time_schedule_akhir)->format('H:i');

                if (!empty($row['wjm'])) {
                    $explode = explode("-", $row['wjm']);
                    if(!empty($explode[1])){
                        $wjm = substr($explode[0], 0,2).":".substr($explode[0], 2,2); 
                        $wjk = substr($explode[1], 0,2).":".substr($explode[1], 2,2); 
                        $checkAbsensi = Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])->first();
                        if(!empty($checkAbsensi)){ 
                            //Sudah Ada Data
                            if($checkAbsensi->wjm < $wjm){
                                //mlate
                                $time = new DateTime($time_schedule_awal);
                                $timeStop = new DateTime($wjm);
                                if ($timeStop > $time) {
                                    $diff = $timeStop->diff($time);
                                    $mlate = $diff->format('%H:%I'); // hours minutes
                                    $mlate    = explode(':', $mlate);
                                    $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                }else{
                                    $mlate = 0;
                                }
                                if (($mlate > 180) &&  (!in_array($checkAbsensi->keterangan, ['Ijin','Ijin 0.5'])) && (!in_array($row['ketabs'], ['Ijin','Ijin 0.5']))) {
                                    //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                    $ketabs = 'Cuti 0.5';
                                    Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                        ->update(['keterangan'=>$ketabs]);
                                }
                                Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                        ->update(['wjm'=>$wjm,'mlate'=>$mlate]);
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
                            }else{
                                $mlate = 0;
                            }
                            if (($mlate > 180) && (!in_array($row['ketabs'], ['Ijin','Ijin 0.5']))) {
                                //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                $ketabs = 'Cuti 0.5';
                            }else{
                                $ketabs = $row['ketabs'];
                            }
                            //prly
                            $timeAkhir = new DateTime($time_schedule_akhir);
                            $timeStopAkhir = new DateTime($wjk);
                            if ($timeStopAkhir < $timeAkhir) {
                                $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                $prly    = explode(':', $prly);
                                $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                            }else{
                                $prly = 0;
                            }
                            //mleft
                            $wkhr = getWKHR($time_schedule_awal,$time_schedule_akhir);
                            $mleft=$wkhr-$mlate;
                            /*SAVE*/
                            $absensi = new Absensi;
                            $absensi->date = transformDate($row['tgl']);
                            $absensi->nik = $row['id'];
                            $absensi->dept_id = $employee->dept_id;
                            $absensi->wjm = $wjm;
                            $absensi->wjk = $wjk;
                            $absensi->mlate = $mlate;
                            $absensi->mleft = $mleft;
                            $absensi->prly = $prly;
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
                    else{
                        $jam = substr($explode[0], 0,2).":".substr($explode[0], 2,2);
                        $checkAbsensi = Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])->first();
                        if(!empty($checkAbsensi)){
                            if($jam < $checkAbsensi->wjm){
                                //mlate
                                $time = new DateTime($time_schedule_awal);
                                $timeStop = new DateTime($jam);
                                if ($timeStop > $time) {
                                    $diff = $timeStop->diff($time);
                                    $mlate = $diff->format('%H:%I'); // hours minutes
                                    $mlate    = explode(':', $mlate);
                                    $mlate = ($mlate[0] * 60.0 + $mlate[1] * 1.0);
                                }else{
                                    $mlate = 0;
                                }
                                if (($mlate > 180) &&  (!in_array($checkAbsensi->keterangan, ['Ijin','Ijin 0.5'])) && (!in_array($row['ketabs'], ['Ijin','Ijin 0.5']))) {
                                    //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                    $ketabs = 'Cuti 0.5';
                                    Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                        ->update(['keterangan'=>$ketabs]);
                                }
                                $wkhr = getWKHR($time_schedule_awal,$time_schedule_akhir);
                                $mleft=$wkhr-$mlate;
                                Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                        ->update(['wjm'=>$jam,'mlate'=>$mlate,'mleft'=>$mleft]);
                            }else{
                                //prly
                                $timeAkhir = new DateTime($time_schedule_akhir);
                                $timeStopAkhir = new DateTime($wjk);
                                if ($timeStopAkhir < $timeAkhir) {
                                    $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                    $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                    $prly    = explode(':', $prly);
                                    $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                }else{
                                    $prly = 0;
                                }
                                Absensi::where('date',transformDate($row['tgl']))->where('nik',$row['id'])
                                        ->update(['wjk'=>$jam,'prly'=>$prly]);
                            }
                        }else{
                            $jam = new DateTime($jam);
                            //Get Range Jam Masuk
                            $time_schedule_awals = new DateTime($time_schedule_awal);
                            $rangeJamMasuk = $jam->diff($time_schedule_awals);
                            $rangeJamMasuk = $rangeJamMasuk->format('%H:%I');
                            //Get Range Jam Keluar
                            $time_schedule_akhirs = new DateTime($time_schedule_akhir);
                            $rangeJamKeluar = $jam->diff($time_schedule_akhirs);
                            $rangeJamKeluar = $rangeJamKeluar->format('%H:%I');
                            if(in_array($row['ketabs'], ['Ijin'])){
                                
                            }else{
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
                                }else{
                                    $mlate = 0;
                                }
                                if (($mlate > 180) && (!in_array($row['ketabs'], ['Ijin','Ijin 0.5']))) {
                                    //Jika Telat Lebih Dari 3 Jam Dianggap Cuti 0.5
                                    $ketabs = 'Cuti 0.5';
                                }else{
                                    $ketabs = $row['ketabs'];
                                }
                                //prly
                                $timeAkhir = new DateTime($time_schedule_akhir);
                                $timeStopAkhir = new DateTime($wjk);
                                if ($timeStopAkhir < $timeAkhir) {
                                    $diffAkhir = $timeStopAkhir->diff($timeAkhir);
                                    $prly = $diffAkhir->format('%H:%I'); // hours minutes
                                    $prly    = explode(':', $prly);
                                    $prly = ($prly[0] * 60.0 + $prly[1] * 1.0);
                                }else{
                                    $prly = 0;
                                }
                                //mleft
                                $wkhr = getWKHR($time_schedule_awal,$time_schedule_akhir);
                                $mleft=$wkhr-$mlate;

                                /*SAVE*/
                                $absensi = new Absensi;
                                $absensi->date = transformDate($row['tgl']);
                                $absensi->nik = $row['id'];
                                $absensi->dept_id = $employee->dept_id;
                                $absensi->wjm = $wjm;
                                $absensi->wjk = $wjk;
                                $absensi->mlate = $mlate;
                                $absensi->mleft = $mleft;
                                $absensi->prly = $prly;
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
                    }
                    
                }else{
                    if(in_array($row['ketabs'], ['Sakit','sakit'])){
                        $wjm = $row['wjm'];
                        $wjk = $row['wjm'];
                        $mlate = 0;
                        $prly = 0;
                        $wkhr = 0;
                        $mleft=0;
                        $getDate = transformDate($row['tgl']);
                        $getDays = getSatDays($getDate);
                        if(in_array($getDate, $getDays)){
                            $ketabs = 'Sakit 0.5';
                        }else{
                            $ketabs = $row['ketabs'];
                        }
                        /*SAVE*/
                        $absensi = new Absensi;
                        $absensi->date = transformDate($row['tgl']);
                        $absensi->nik = $row['id'];
                        $absensi->dept_id = $employee->dept_id;
                        $absensi->wjm = $wjm;
                        $absensi->wjk = $wjk;
                        $absensi->mlate = $mlate;
                        $absensi->mleft = $mleft;
                        $absensi->prly = $prly;
                        $absensi->wkhr = $wkhr;
                        $absensi->keterangan = $ketabs;
                        $absensi->bulan = $this->data->month;
                        $absensi->tahun = $this->data->year;
                        if (!empty($row['id'])) {
                            $absensi->save();
                        }
                        /*SAVE*/
                    }elseif(in_array($row['ketabs'], ['Dinas Diluar','dinas diluar', 'Dinas diluar'])){ //DIANGGAP MASUK
                        $wjm = $time_schedule_awal; 
                        $wjk = $time_schedule_akhir; 
                        $mlate = 0;
                        $prly = 0;
                        $wkhr = getWKHR($time_schedule_awal,$time_schedule_akhir);
                        $mleft=$wkhr-$mlate;
                        $ketabs = $row['ketabs'];
                        /*SAVE*/
                        $absensi = new Absensi;
                        $absensi->date = transformDate($row['tgl']);
                        $absensi->nik = $row['id'];
                        $absensi->dept_id = $employee->dept_id;
                        $absensi->wjm = $wjm;
                        $absensi->wjk = $wjk;
                        $absensi->mlate = $mlate;
                        $absensi->mleft = $mleft;
                        $absensi->prly = $prly;
                        $absensi->wkhr = $wkhr;
                        $absensi->keterangan = $ketabs;
                        $absensi->bulan = $this->data->month;
                        $absensi->tahun = $this->data->year;
                        if (!empty($row['id'])) {
                            $absensi->save();
                        }
                        /*SAVE*/
                    }else{
                        $wjm = $row['wjm'];
                        $wjk = $row['wjm'];
                        $mlate = 0;
                        $prly = 0;
                        $wkhr = getWKHR($time_schedule_awal,$time_schedule_akhir);
                        $mleft=$wkhr-$mlate;
                        $ketabs = $row['ketabs'];
                        /*SAVE*/
                        $absensi = new Absensi;
                        $absensi->date = transformDate($row['tgl']);
                        $absensi->nik = $row['id'];
                        $absensi->dept_id = $employee->dept_id;
                        $absensi->wjm = $wjm;
                        $absensi->wjk = $wjk;
                        $absensi->mlate = $mlate;
                        $absensi->mleft = $mleft;
                        $absensi->prly = $prly;
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
            }
        }
        
    }


    public function headingRow(): int
    {
        return 1;
    }
}