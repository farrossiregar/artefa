<div class="panel panel-default">
    <div class="panel-heading flex-center">
        <b>Report Uang Transport / Uang Makan</b>
    </div>
    <form action="{{url('/')}}/backend/exportumut" method="POST">
    <div class="panel-body" style="width: 1057px; overflow:auto;">
      <div style="max-height: 350px; overflow-y: scroll;">
          {{csrf_field()}}
          <input type="hidden" name="var1" value="{{$var1}}">
          <input type="hidden" name="var2" value="{{$var2}}">
          <input type="hidden" name="var3" value="{{$var3}}">
          <input type="hidden" name="id_kar" value="{{$id_kar}}">
            <table class="table table-bordered fixed_head" width="1200">
                <thead>
                    <tr>
                        <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">No</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 80px;">NIK</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total UT</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 80px;">UT</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">Sub Total UT</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total UM</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 80px;">UM</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">Sub Total UM</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">Jumlah</div></th>
                        <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 40px;">UMUT
                        </th>
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
                                        //               $query->where('mrly','>=',180)
                                        //                     ->orWhere('plate','>=',180);
                                        //           })
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
                              //             ->whereBetween('tgl_lembur_awal',[$lembur->date." 00:00",$lembur->date." 23:59"])->where('jenis_lembur','K')->where('lama_lembur','>=','3:00')
                              //             ->where('app2','Y')->first();
                              //   $tglMerah = \App\Models\TanggalMerah::where('date',$lembur->date)->get();
                              //   if((!in_array($lembur->date, $getSunDays)) || (count($tglMerah)<0)){ //JIKA HARI LIBUR NAS, MINGGU, dan JADWAL LIBUR KAR TDK DAPAT UM
                              //     if(!empty($cekformlembur)){
                              //       $datelembur[$p]=$lembur->date;
                              //       $datelembur[$p++];
                              //       \Log::debug('lembur date '.$lembur->date);
                              //     }
                              //   }
                              // }else{
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
                              $absensium = 0;//Tidak Ada Absen
                            }
                            \Log::debug('data absen '.$absensium);
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
                            <td>{{$employee->nik}}</td>
                            <td>{{$employee->nama}}</td>
                            <td><div align="center"><b>{{count($absensis)}}</b></div></td>
                            <td><div align="center"><b>{{number_format($ut, 0)}}</b></div></td>
                            <td><div align="center"><b>{{number_format($subtotalut, 0)}}</b></div></td>
                            <td><div align="center"><b>{{$absensium}}</b></div></td>
                            <td><div align="center"><b>{{number_format($um, 0)}}</b></div></td>
                            <td><div align="center"><b>{{number_format($subtotalum,0)}}</b></div></td>
                            <td><div align="center"><b>{{number_format($jumlah,0)}}</b></div></td>
                            <td>
                              <div align="center">
                                  <label>
                                      <input type="checkbox" name="umut[]" class="checkbox" value="{{$employee->id}}"  checked="true" />
                                  </label>
                              </div>
                            </td>
                          </tr>
                      @endforeach
                    </tr>
                    <tr>
                      <td colspan="3"><div align="center"><b>Total</b></div></td>
                      <td><div align="center"><b>-</b></div></td>
                      <td><div align="center"><b>-</b></div></td>
                      <td><div align="center"><b>{{number_format($totalut,0)}}</b></div></td>
                      <td><div align="center"><b>-</b></div></td>
                      <td><div align="center"><b>-</b></div></td>
                      <td><div align="center"><b>{{number_format($totalum,0)}}</b></div></td>
                      <td><div align="center"><b>{{number_format($jumlahkeseluruhan,0)}}</b></div></td>
                      <td><div align="center"><b></b></div></td>
                    </tr>
                  @else
                    @foreach($departments as $key => $value)
                        <tr>
                        <?php
                        ($value->department == $value->unit)?$unitdept = $value->unit:$unitdept = $value->department.' - '.$unitdept = $value->unit;
                        ?>
                            <td colspan="11" bgcolor="#c5ed4e"><b>{{$unitdept}}</b></td>
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
                                                    //         $query->where('mrly','>=',180)
                                                    //               ->orWhere('plate','>=',180);
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
                                if(count($absensis) > 0){
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
                                  $absensium = 0;//Tidak Ada Absen
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
                                <td>{{$employee->nik}}</td>
                                <td>{{$employee->nama}}</td>
                                <td><div align="center"><b>{{count($absensis)}}</b></div></td>
                                <td><div align="center"><b>{{number_format($ut, 0)}}</b></div></td>
                                <td><div align="center"><b>{{number_format($subtotalut, 0)}}</b></div></td>
                                <td><div align="center"><b>{{$absensium}}</b></div></td>
                                <td><div align="center"><b>{{number_format($um, 0)}}</b></div></td>
                                <td><div align="center"><b>{{number_format($subtotalum,0)}}</b></div></td>
                                <td><div align="center"><b>{{number_format($jumlah,0)}}</b></div></td>
                                <td>
                                  <div align="center">
                                      <label>
                                          <input type="checkbox" name="umut[]" class="checkbox" value="{{$employee->id}}"  checked="true" />
                                      </label>
                                  </div>
                                </td>
                              </tr>
                          @endforeach
                        </tr>
                        <tr>
                          <td colspan="3"><div align="center"><b>Total</b></div></td>
                          <td><div align="center"><b>-</b></div></td>
                          <td><div align="center"><b>-</b></div></td>
                          <td><div align="center"><b>{{number_format($totalut,0)}}</b></div></td>
                          <td><div align="center"><b>-</b></div></td>
                          <td><div align="center"><b>-</b></div></td>
                          <td><div align="center"><b>{{number_format($totalum,0)}}</b></div></td>
                          <td><div align="center"><b>{{number_format($jumlahkeseluruhan,0)}}</b></div></td>
                          <td><div align="center"><b></b></div></td>
                        </tr>
                    @endforeach
                  @endif
               </tbody>
          </table>
      </div>
    </div>
    <div class="pull-right" style="margin-right: 13px;padding-top: 20px;">
      <button type="submit" class="btn btn-sm btn-primary">Export</button>
    </div>
    </form>
</div>
