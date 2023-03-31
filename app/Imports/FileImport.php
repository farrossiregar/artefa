<?php

namespace App\Imports;

use DB;
use App\Models\User;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\MstJabatan;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Models\ShiftSchedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Spatie\Permission\Models\Permission;

class FileImport implements ToCollection, WithHeadingRow
{
    use Importable;
    public function forEvent($data,$lastDay,$dept_id)
    {
        $this->data = $data;
        $this->lastDay = $lastDay;
        $this->dept_id = $dept_id;

        return $this;
    }
    public function collection(Collection $rows)
    {
        $shiftSchedules = ShiftSchedule::whereBetween('date',[$this->data->year."-".$this->data->month."-01",$this->data->year."-".$this->data->month."-".$this->lastDay])->where('dept',$this->dept_id)->get();
        if($shiftSchedules){
            ShiftSchedule::whereBetween('date',[$this->data->year."-".$this->data->month."-01",$this->data->year."-".$this->data->month."-".$this->lastDay])->where('dept',$this->dept_id)->delete();
        }
        foreach ($rows as $key=>$row) 
        {
            for ($i=1; $i <= $this->lastDay; $i++) { 
                if($i<=9){
                    $date = $this->data->year."-".$this->data->month."-0".$i;
                }else{
                    $date = $this->data->year."-".$this->data->month."-".$i;
                }
                $shiftSchedule = new ShiftSchedule;
                $shiftSchedule->nik = $row['nik'];
                $shiftSchedule->dept = $this->dept_id;
                $shiftSchedule->date = $date;
                $shiftSchedule->schedule_code = $row[$i];
                if(!empty($row[$i])){
                    $shiftSchedule->save();
                }
            }
        }
        
    }

    /*USER*/
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $key=>$row) 
    //     {
    //         $emp_id = Employee::where('nik',$row['username'])->first();
    //         $user = new User;
    //         $user->emp_id = $emp_id->id;
    //         $user->name = $row['name'];
    //         $user->username = $row['username'];
    //         $user->password = Hash::make($row['password']);
    //         $user->save();
    //         DB::table('model_has_roles')->insert([
    //             'role_id'=>$row['role'],
    //             'model_id'=>$user->id,
    //             'model_type'=>'App\Models\User'
    //         ]);
    //     }
    // }
    /*END*/

    /*DEPARTMENT*/
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $key=>$row) 
    //     {
    //         Departement::create([
    //             'department' => $row['department'],
    //             'unit' => $row['unit'],
    //             'shift' => $row['shift'],
    //         ]);
    //     }
    // }
    /*END*/

    /*EMPLOYEE*/
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $key=>$row) 
    //     {
    //         $dept = Departement::where('department',$row['department'])->where('unit',$row['unit'])->first();
    //         if($row['shift'] == 'Non Shift'){
    //             $shifting='N';
    //         }else{
    //             $shifting='Y';
    //         }
    //         if($row['status'] == 'Aktif'){
    //             $status = 1;
    //         }else{
    //             $status = 2;
    //         }
    //         Employee::create([
    //             'dept_id' => $dept['id'],
    //             'nama' => $row['nama'],
    //             'nik' => $row['nik'],
    //             'is_user' => $row['no'],
    //             'email' => $row['email'],
    //             'tgl_lahir' => transformDate($row['lahir']),
    //             'level' => $row['level'],
    //             'jabatan' => $row['jabatan'],
    //             'direct_supervisor' => $row['direct_supervisor'],
    //             'next_higher_supervisor' => $row['next_higher_supervisor'],
    //             'shifting' => $shifting,
    //             'ut' => $row['ut'],
    //             'um' => $row['um'],
    //             'tgl_join' => transformDate($row['join']),
    //             'tgl_resign' => transformDate($row['resign']),
    //             'status' => $status,
    //         ]);
    //     }
    // }
    /*END*/

    /*SCHEDULE*/
    // public function collection(Collection $rows){
    //     foreach ($rows as $key => $row) {
    //         Schedule::create([
    //             'code' => $row['code'],
    //             'dept_id' => $row['dept'],
    //             'time_schedule_awal' => transformTime($row['in']),
    //             'time_schedule_akhir' => transformTime($row['out']),                
    //         ]);
    //     }
    // }
    /*END*/

    /*JABATAN*/
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $key=>$row) 
    //     {
    //         if(!empty($row['jabatan'])){
    //             MstJabatan::create([
    //                 'name' => $row['jabatan']
    //             ]);
    //         }
    //     }
    // }
    /*ENDJABATAN*/

    public function headingRow(): int
    {
        return 2;
    }
}