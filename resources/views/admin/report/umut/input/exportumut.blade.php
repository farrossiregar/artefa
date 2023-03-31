<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Report UMUT Bulan  - ".\Carbon\Carbon::now()->format('d-F-Y').".xls");
?>
  <div class="col-md-12" style="width: 1060px; overflow:auto;">
  <div style="max-height: 350px; overflow-y: scroll;">
  <br>
  <table class="table table-striped table-bordered table-hover" width="100%">
    <tbody>
      <tr>
        @if($id_kar != 0)
        <?php $karyawan = \App\Models\Employee::where('id',$idKar)->first(); ?>
        <th colspan="10"><div align="center"><h3>Report UT / UM {{$karyawan->nama}}</h3></div></th>
        @else
        <th colspan="10"><div align="center"><h3>Report UT / UM Semua Department</h3></div></th>
        @endif
      </tr>
      <tr>
        <th colspan="10"><div align="center">Periode : {{\Carbon\Carbon::parse($dateFrom)->format('d-F-Y')}} - {{\Carbon\Carbon::parse($dateTo)->format('d-F-Y')}}</div></th>
      </tr>
    </tbody>
  </table>
  <br>
  <table class="table table-bordered" width="1200" border="1">
      <thead>
          <tr>
              <th bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">No</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 80px;">NIK</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total UT</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 80px;">UT</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">Sub Total UT</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total UM</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 80px;">UM</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">Sub Total UM</div></th>
              <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">Jumlah</div></th>
          </tr>
     </thead>
     <tbody>
        @if($id_kar != 0)
          <tr>
            <?php
              $employees = \DB::select("SELECT a.*
                                FROM employees a 
                                where a.id = $id_kar");
              $z=0;
              $totalut = 0;
              $totalum = 0;
              $jumlahkeseluruhan = 0;
            ?>
              @foreach($employees as $i => $employee)
                
                  <?php
                    $z++;
                    $lemburs = \DB::table('absensi')->where('nik',$employee->nik)->whereBetween('date',[$dateFrom,$dateTo])
                                        // ->where(function($query){
                                        //         $query->where('mrly','>',180)
                                        //               ->orWhere('plate','>',180);
                                        //     })
                                        ->get();
                    $datelembur=[];
                    $p=0;
                    foreach ($lemburs as $lembur) {
                      $cekformlembur = \App\Models\Lembur::where('nik',$employee->nik)
                                                                ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')->where('lama_lembur','>=','3:00')
                                                                ->where('app2','Y')->first();
                      $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                      if((!in_array($lembur->date, $getSunDays)) || (count($tglMerah)<0)){ //JIKA HARI LIBUR NAS, MINGGU, dan JADWAL LIBUR KAR TDK DAPAT UM
                        if(!empty($cekformlembur)){
                          $datelembur[$p]=$lembur->date;
                          $datelembur[$p++];
                          \Log::debug('lembur date '.$lembur->date);
                        }
                      }
                      // if($employee->level == 'Non Staff'){
                      //   $cekformlembur = \App\Models\Lembur::where('nik',$employee->nik)
                      //                                             ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')->where('lama_lembur','>=','3:00')
                      //                                             ->where('app2','Y')->first();
                      //   $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                      //   if((!in_array($lembur->date, $getSunDays)) || (count($tglMerah)<0)){ //JIKA HARI LIBUR NAS, MINGGU, dan JADWAL LIBUR KAR TDK DAPAT UM
                      //     if(!empty($cekformlembur)){
                      //       $datelembur[$p]=$lembur->date;
                      //       $datelembur[$p++];
                      //       \Log::debug('lembur date '.$lembur->date);
                      //     }
                      //   }
                      // }else{
                      //   // if((!in_array($lembur->date, $getSatDays)) || (in_array($lembur->date, $getSunDays)) || (in_array($lembur->date, $tglMerah))){ //bukan hari sabtu, atau tgl merah, atau liburr tetap dihitung um
                      //   /*NOTES*/
                      //   $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                      //   if((!in_array($lembur->date, $getSatDays)) || (in_array($lembur->date, $getSunDays)) || (count($tglMerah)>0)){
                      //     $cekformlembur = \App\Models\Lembur::where('nik',$employee->nik)
                      //               ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')
                      //               ->where('app2','Y')->first();
                      //     if(!empty($cekformlembur)){
                      //       $datelembur[$p]=$lembur->date;
                      //       $datelembur[$p++];
                      //     }
                      //   }
                      // }
                    }
                    if(count($datelembur)>0){
                      $datalembur = count($datelembur);
                    }else{
                      $datalembur = 0;
                    }
                    \Log::debug('jumlah lembur '.$datalembur);

                    $absensis = \App\Models\Absensi::where('nik',$employee->nik)->whereBetween('date',[$dateFrom,$dateTo])
                                        ->whereNotNull('wjm')->whereNotNull('wjm')->get(); //BELUM ADA KONDISI KETERANGAN
                    $dateabsen=[];
                    $h=0;
                    if(count($absensis) > 0){
                      foreach ($absensis as $key => $absensi) {
                        if($employee->level == 'Non Staff'){
                          $dateabsen[$h]=$absensi->date;
                          $dateabsen[$h++];
                        }else{
                          $tglMerah = \App\Models\TanggalMerah::where('date',$absensi->date)->get();
                          if((!in_array($absensi->date, $getSatDays)) || (in_array($absensi->date, $getSunDays)) || (count($tglMerah)>0)){
                            $dateabsen[$h]=$absensi->date;
                            $dateabsen[$h++];
                          }
                        }
                      }
                      $absensium = count($dateabsen)+$datalembur;
                    }else{
                      $absensium = 0;
                    }
                    /*UT*/
                    if((!in_array($employee->ut, ['Lumpsum','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&($employee->jabatan == 'Sales Consultant')){ //Get uang transport sales consultant
                      $ut = \App\Models\MstBiaya::where('type','UT')->where('code','A')->first();
                      $ut = $ut->amount;
                    }elseif((!in_array($employee->ut, ['Lumpsum','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&($employee->jabatan == 'Sales Counter')){
                      $ut = \App\Models\MstBiaya::where('type','UT')->where('code','B')->first();
                      $ut = $ut->amount;
                    }elseif((!in_array($employee->ut, ['Lumpsum','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&(!in_array($employee->jabatan,['Sales Counter','Sales Consultant']))){
                      $ut = \App\Models\MstBiaya::where('type','UT')->where('code','C')->first();
                      $ut = $ut->amount;
                    }else{
                      $ut = 0;
                    }
                    /*END UT*/
                    /*UM*/
                    if((!in_array($employee->um, ['Kupon','N/A']))&&(in_array($employee->jabatan, ['General Manager','Sales & Marketing Manager','Sales Consultant','Sales Supervisor','Sales Counter']))){
                      $um = \App\Models\MstBiaya::where('type','UM')->where('code','A')->first();
                      $um = $um->amount;
                    }elseif((!in_array($employee->um, ['Kupon','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&(!in_array($employee->jabatan, ['General Manager','Sales & Marketing Manager','Sales Consultant','Sales Supervisor','Sales Counter']))){
                      $um = \App\Models\MstBiaya::where('type','UM')->where('code','B')->first();
                      $um = $um->amount;
                    }
                    else{
                      $um=0;
                    }
                    /*END UM*/
                    $subtotalut=count($absensis)*$ut;
                    $subtotalum=$absensium*$um;
                    $totalut = $totalut + $subtotalut;
                    $totalum = $totalum + $subtotalum;
                    $jumlah = $subtotalut+$subtotalum;
                    $jumlahkeseluruhan = $jumlahkeseluruhan + $jumlah;
                    
                  ?>
                  <tr>
                    <td>{{$z}}</td>
                    <td><div align="center"><b>{{$employee->nik}}</b></div></td>
                    <td>{{$employee->nama}}</td>
                    <td><div align="center"><b>{{count($absensis)}}</b></div></td>
                    <td><div align="center"><b>{{$ut}}</b></div></td>
                    <td><div align="center"><b>{{$subtotalut}}</b></div></td>
                    <td><div align="center"><b>{{$absensium}}</b></div></td>
                    <td><div align="center"><b>{{$um}}</b></div></td>
                    <td><div align="center"><b>{{$subtotalum}}</b></div></td>
                    <td><div align="center"><b>{{$jumlah}}</b></div></td>
                  </tr>
              @endforeach
            </tr>
            <tr>
              <td colspan="3"><div align="center"><b>Total</b></div></td>
              <td><div align="center"><b>-</b></div></td>
              <td><div align="center"><b>-</b></div></td>
              <td><div align="center"><b>{{$totalut}}</b></div></td>
              <td><div align="center"><b>-</b></div></td>
              <td><div align="center"><b>-</b></div></td>
              <td><div align="center"><b>{{$totalum}}</b></div></td>
              <td><div align="center"><b>{{$jumlahkeseluruhan}}</b></div></td>
            </tr>
        @else
          @foreach($departments as $key => $value)
              <tr>
              <?php
              ($value->department == $value->unit)?$unitdept = $value->unit:$unitdept = $value->department.' - '.$unitdept = $value->unit;
              ?>
                  <td colspan="10" bgcolor="#c5ed4e"><b>{{$unitdept}}</b></td>
              </tr>
              <tr>
                <?php
                  $employees = \DB::select("SELECT a.*
                                      FROM employees a 
                                      where (a.ut NOT IN ('Lumpsum','N/A') or a.um NOT IN ('Kupon','N/A')) 
                                        and a.dept_id = $value->id
                                        and a.status = 1
                                        and a.id NOT IN (select a.id from employees a 
                                                  where (a.tgl_join between '".$min3bulan."' and '".$dateTo."') 
                                                  and a.dept_id IN (17,18,19))");
                  $z=0;
                  $totalut = 0;
                  $totalum = 0;
                  $jumlahkeseluruhan = 0;
                ?>
                @foreach($employees as $i => $employee)
                  
                    <?php
                      $z++;
                      $lemburs = \DB::table('absensi')->where('nik',$employee->nik)->whereBetween('date',[$dateFrom,$dateTo])
                                          // ->where(function($query){
                                          //         $query->where('mrly','>',180)
                                          //               ->orWhere('plate','>',180);
                                          //     })
                                          ->get();
                      $datelembur=[];
                      $p=0;
                      foreach ($lemburs as $lembur) {
                        $cekformlembur = \App\Models\Lembur::where('nik',$employee->nik)
                                  ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')->where('lama_lembur','>=','3:00')
                                  ->where('app2','Y')->first();
                        $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                        if((!in_array($lembur->date, $getSunDays)) || (count($tglMerah)<0)){ //JIKA HARI LIBUR NAS, MINGGU, dan JADWAL LIBUR KAR TDK DAPAT UM
                          if(!empty($cekformlembur)){
                            $datelembur[$p]=$lembur->date;
                            $datelembur[$p++];
                          }
                        }
                        // if($employee->level == 'Non Staff'){
                        //   $cekformlembur = \App\Models\Lembur::where('nik',$employee->nik)
                        //             ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')->where('lama_lembur','>=','3:00')
                        //             ->where('app2','Y')->first();
                        //   $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                        //   if((!in_array($lembur->date, $getSunDays)) || (count($tglMerah)<0)){ //JIKA HARI LIBUR NAS, MINGGU, dan JADWAL LIBUR KAR TDK DAPAT UM
                        //     if(!empty($cekformlembur)){
                        //       $datelembur[$p]=$lembur->date;
                        //       $datelembur[$p++];
                        //     }
                        //   }
                        // }else{
                        //   // if((!in_array($lembur->date, $getSatDays)) || (in_array($lembur->date, $getSunDays)) || (in_array($lembur->date, $tglMerah))){ //bukan hari sabtu, atau tgl merah, atau liburr tetap dihitung um
                        //   $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                        //   if((!in_array($lembur->date, $getSatDays)) || (in_array($lembur->date, $getSunDays)) || (count($tglMerah)>0)){
                        //     $cekformlembur = \App\Models\Lembur::where('nik',$employee->nik)
                        //               ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')
                        //               ->where('app2','Y')->first();
                        //     if(!empty($cekformlembur)){
                        //       $datelembur[$p]=$lembur->date;
                        //       $datelembur[$p++];
                        //     }
                        //   }
                        // }
                      }
                      if(count($datelembur)>0){
                        $datalembur = count($datelembur);
                      }else{
                        $datalembur = 0;
                      }

                      $absensis = \App\Models\Absensi::where('nik',$employee->nik)->whereBetween('date',[$dateFrom,$dateTo])
                                          ->whereNotNull('wjm')->whereNotNull('wjm')->get(); //BELUM ADA KONDISI KETERANGAN
                      $dateabsen=[];
                      $h=0;
                      if(count($absensis)>0){
                        foreach ($absensis as $key => $absensi) {
                          if($employee->level == 'Non Staff'){
                            $dateabsen[$h]=$absensi->date;
                            $dateabsen[$h++];
                          }else{
                            // if((!in_array($absensi->date, $getSatDays)) || (in_array($absensi->date, $getSunDays)) || (in_array($absensi->date, $tglMerah))){ //bukan hari sabtu, atau tgl merah, atau liburr tetap dihitung um
                            $tglMerah = \App\Models\TanggalMerah::where('date',$absensi->date)->get();
                            if((!in_array($absensi->date, $getSatDays)) || (in_array($absensi->date, $getSunDays)) || (count($tglMerah)>0)){
                              $dateabsen[$h]=$absensi->date;
                              $dateabsen[$h++];
                            }
                          }
                        }
                        $absensium = count($dateabsen)+$datalembur;
                      }else{
                        $absensium = 0;
                      }
                      /*UT*/
                      if((!in_array($employee->ut, ['Lumpsum','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&($employee->jabatan == 'Sales Consultant')){ //Get uang transport sales consultant
                        $ut = \App\Models\MstBiaya::where('type','UT')->where('code','A')->first();
                        $ut = $ut->amount;
                      }elseif((!in_array($employee->ut, ['Lumpsum','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&($employee->jabatan == 'Sales Counter')){
                        $ut = \App\Models\MstBiaya::where('type','UT')->where('code','B')->first();
                        $ut = $ut->amount;
                      }elseif((!in_array($employee->ut, ['Lumpsum','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&(!in_array($employee->jabatan,['Sales Counter','Sales Consultant']))){
                        $ut = \App\Models\MstBiaya::where('type','UT')->where('code','C')->first();
                        $ut = $ut->amount;
                      }else{
                        $ut = 0;
                      }
                      /*END UT*/
                      /*UM*/
                      if((!in_array($employee->um, ['Kupon','N/A']))&&(in_array($employee->jabatan, ['General Manager','Sales & Marketing Manager','Sales Consultant','Sales Supervisor','Sales Counter']))){
                        $um = \App\Models\MstBiaya::where('type','UM')->where('code','A')->first();
                        $um = $um->amount;
                      }elseif((!in_array($employee->um, ['Kupon','N/A']))&&(in_array($employee->level, ['Staff','Non Staff']))&&(!in_array($employee->jabatan, ['General Manager','Sales & Marketing Manager','Sales Consultant','Sales Supervisor','Sales Counter']))){
                        $um = \App\Models\MstBiaya::where('type','UM')->where('code','B')->first();
                        $um = $um->amount;
                      }
                      else{
                        $um=0;
                      }
                      /*END UM*/
                      $subtotalut=count($absensis)*$ut;
                      $subtotalum=$absensium*$um;
                      $totalut = $totalut + $subtotalut;
                      $totalum = $totalum + $subtotalum;
                      $jumlah = $subtotalut+$subtotalum;
                      $jumlahkeseluruhan = $jumlahkeseluruhan + $jumlah;
                      
                    ?>
                    <tr>
                      <td>{{$z}}</td>
                      <td><div align="center"><b>{{$employee->nik}}</b></div></td>
                      <td>{{$employee->nama}}</td>
                      <td><div align="center"><b>{{count($absensis)}}</b></div></td>
                      <td><div align="center"><b>{{$ut}}</b></div></td>
                      <td><div align="center"><b>{{$subtotalut}}</b></div></td>
                      <td><div align="center"><b>{{$absensium}}</b></div></td>
                      <td><div align="center"><b>{{$um}}</b></div></td>
                      <td><div align="center"><b>{{$subtotalum}}</b></div></td>
                      <td><div align="center"><b>{{$jumlah}}</b></div></td>
                    </tr>
                @endforeach
              </tr>
              <tr>
                <td colspan="3"><div align="center"><b>Total</b></div></td>
                <td><div align="center"><b>-</b></div></td>
                <td><div align="center"><b>-</b></div></td>
                <td><div align="center"><b>{{$totalut}}</b></div></td>
                <td><div align="center"><b>-</b></div></td>
                <td><div align="center"><b>-</b></div></td>
                <td><div align="center"><b>{{$totalum}}</b></div></td>
                <td><div align="center"><b>{{$jumlahkeseluruhan}}</b></div></td>
              </tr>
          @endforeach
        @endif
     </tbody>
</table>
</div>
</div>