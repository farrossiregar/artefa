<?php

if($approve == 'Y'){
    if($jenis_cuti != 'C4'){
        $update_hak_cuti = DB::select("UPDATE data_hak_cuti 
                                SET ".$pengurangan_cuti."
                                WHERE nik = '".$nik."' 
                                AND tahun = '".$tahun_ini."'");
    }else{
        $data_cuti_karyawan = DB::select("SELECT * FROM DATA_HAK_CUTI 
                                            WHERE NIK = '".$nik."' 
                                            AND TAHUN = '".$tahun_ini."' ");
        foreach($data_cuti_karyawan as $datacutikaryawan){
            $sisa_cuti_tahunan = $datacutikaryawan->sisa_cuti_tahunan;
            $sisa_cuti_besar = $datacutikaryawan->sisa_cuti_besar;
        }
        if($sisa_cuti_tahunan > 0){
            $habisin_cuti_tahunan = $sisa_cuti_tahunan - $jumlah_cuti_diambil;
            $sisa_cuti_besar_setelah_pengurangan = $sisa_cuti_besar - abs($habisin_cuti_tahunan);
            if($habisin_cuti_tahunan < 0){
                $update_hak_cuti = DB::select("UPDATE data_hak_cuti 
                            SET sisa_cuti_tahunan = '0', 
                            sisa_cuti_besar = '".$sisa_cuti_besar_setelah_pengurangan."'
                            WHERE nik = '".$nik."' 
                            AND tahun = '".$tahun_ini."'");
            }else{
                $update_hak_cuti = DB::select("UPDATE data_hak_cuti 
                            SET sisa_cuti_tahunan = '".$habisin_cuti_tahunan."'
                            WHERE nik = '".$nik."' 
                            AND tahun = '".$tahun_ini."'");
            }
            
        }
    }

    $istype = substr($jenis_cuti, 1, 1);
    $cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
    $jumlah = $cek_hpcuti;
    if($jumlah > 0){
        $hp_cuti = HPcuti::where('istype', $istype)
                        ->where('isuser', $userid)->orderBy('cutiid', 'DESC')
                        ->get();
        foreach($hp_cuti as $hpcuti){
            $sebelum = $hpcuti->sebelum;
            $sesudah = $hpcuti->sesudah;
            $audit = $hpcuti->audit;
            $audit2 = $audit + 1;
        }
        $inserthpcuti = new HPcuti;
        $inserthpcuti->isuser = $userid;
        $inserthpcuti->mulai = $tgl_cuti_awal;
        $inserthpcuti->akhir = $tgl_cuti_akhir;
        $inserthpcuti->istype = $istype;
        $inserthpcuti->jumlah = $jumlah_cuti_diambil;
        $inserthpcuti->keterangan = $penjelasan_cuti;
        $inserthpcuti->sebelum = $sesudah;
        $inserthpcuti->sesudah = $sebelum - $jumlah_cuti_diambil;
        $inserthpcuti->audit = $audit2;

        $inserthpcuti->save();
    }else{
        $inserthpcuti = new HPcuti;
        $inserthpcuti->isuser = $userid;
        $inserthpcuti->mulai = $tgl_cuti_awal;
        $inserthpcuti->akhir = $tgl_cuti_awal;
        $inserthpcuti->istype = $istype;
        $inserthpcuti->jumlah = $jumlah_cuti_diambil;
        $inserthpcuti->keterangan = $penjelasan_cuti;
        $inserthpcuti->sebelum = 0;
        $inserthpcuti->sesudah = 0 - $jumlah_cuti_diambil;
        $inserthpcuti->audit = '1';

        $inserthpcuti->save();
    }
    
}