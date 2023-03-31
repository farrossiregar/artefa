<?php
namespace App\Helpers;
use App\Models\HPcuti;
use App\Models\Employee;

use Illuminate\Support\Facades\DB;

class Updatecuti {
    public static function updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil) {
        $data_user = Employee::where('userid', $userid);
        foreach($data_user as $datauser){
            $nik = $datauser->nik;
        }
        if($istype == '1' || $istype == '2' || $istype == '3' || $istype == '5'){

        }else{

        }
        if($nik != ''){
            $tahun = date('Y');
            $updatedatacuti = DB::select("UPDATE DATA_HAK_CUTI 
                                        SET SISA_CUTI_TAHUNAN = (SELECT (SISA_CUTI_TAHUNAN - 0.5) As SCT) 
                                        WHERE NIK ='$nik' 
                                        AND TAHUN ='$tahun' ");
            $msg = 'BERHASIL UPDATE!';
            return ($msg);
        }else{
            $msg = 'GAGAL UPDATE!';
            return ($msg);
        }

        if($userid != ''){
            $istype = '1';
        //  $cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
            $cek_hpcuti = HPcuti::where('isuser', $userid)->count();
            $jumlah = $cek_hpcuti;
            if($jumlah > 0){
            /*    $hp_cuti = HPcuti::where('istype', $istype)
                                ->where('isuser', $userid)->orderBy('cutiid', 'DESC')
                                ->get();    */
                $hp_cuti = HPcuti::where('isuser', $userid)
                                ->orderBy('cutiid', 'DESC')
                                ->get();
                foreach($hp_cuti as $hpcuti){
                    $sebelum = $hpcuti->sebelum;
                    $sesudah = $hpcuti->sesudah;
                    $audit = $hpcuti->audit;
                    $audit2 = $audit + 1;
                }
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
        
                $inserthpcuti->save();

                return redirect('');

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

                return redirect('');
            }
        }else{
            $msg = 'GAGAL UPDATE!';
            return ($msg);
        }
    }
}