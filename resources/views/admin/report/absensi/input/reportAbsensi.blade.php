<div class="panel panel-default">
    <div class="panel-heading flex-center">
        <b>Report Absensi Karyawan</b>
    </div>
    <form action="{{url('/')}}/backend/exportabsensi" method="POST">
      {{csrf_field()}}
      <input type="hidden" name="var1" value="{{$var1}}">
      <input type="hidden" name="var2" value="{{$var2}}">
      <input type="hidden" name="var3" value="{{$var3}}">
      <input type="hidden" name="dept_id" value="{{$dept_id}}">
      <input type="hidden" name="berdasarkan" value="{{$berdasarkan}}">
      <input type="hidden" name="tipe" value="{{$tipe}}">
      <input type="hidden" name="id_kar" value="{{$idKar}}">
        <div class="col-md-12" style="width: 1057px; overflow:auto;">
        <div style="max-height: 350px; overflow-y: scroll;">
        <table class="table table-striped table-bordered table-hover" width="1200">
            <thead>
                <tr>
                    <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">No</div></th>
                    @if($berdasarkan == 1 || $berdasarkan == 3)
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" >Nik</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
                    @else
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Department</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Unit</div></th>
                    @endif
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Jumlah Karyawan</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Jumlah Hari Kerja</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total Hari Kerja</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Cuti</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Sebagai Sakit Cuti</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total Cuti</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Sakit</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Telat</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Ijin</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total S+T+I</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Total KetidakHadiran</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Sisa Cuti Tahunan ({{$tahun}})</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Sisa Cuti Khusus ({{$tahun}})</div></th>
                    <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Sisa Cuti Besar ({{$tahun}})</div></th>
                    <th colspan="3" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Persentasi %</div></th>
                    <th colspan="3" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Persentasi %</div></th>
                </tr>
                <tr>
                    <th bgcolor="#6cddbf"><div align="center" style="width: 150px;">Tidak Hadir</div></th>
                    <th bgcolor="#6cddbf"><div align="center" style="width: 150px;">Tidak Hadir S+T+I</div></th>
                    <th bgcolor="#6cddbf"><div align="center" style="width: 150px;">Terlambat</div></th>
                    <th bgcolor="#6cddbf"><div align="center" style="width: 150px;">Kehadiran</div></th>
                    <th bgcolor="#6cddbf"><div align="center" style="width: 150px;">Kehadiran Selain Cuti</div></th>
                    <th bgcolor="#6cddbf"><div align="center" style="width: 150px;">Tepat Waktu</div></th>
                </tr>
           </thead>
           <tbody>
              <?php
                $z=0;
              ?>
              @if($berdasarkan == 3)
                <?php $employees = \App\Models\Employee::where('id',$idKar)->get(); ?>
                @foreach($employees as $key => $value)
                <?php
                  $z++;
                ?>
                    <tr>
                        <td>{{$z}}</td>
                        <?php
                        $cekAbsen = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])->get();
                        $sakit = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->whereNull('wjm')->whereNull('wjk')
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Sakit')->get();
                        //Get Date Sakit
                        $dateS=[];
                        $h=0;                                              
                        if(count($sakit) > 0){
                          for($i=0; $i<count($sakit); $i++)
                          {
                              $dateS[$h] = $sakit[$i]->date;
                              $dateS[$h++];
                          }
                          $dateSakit = $dateS;
                        }
                        $sakitsetengah = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->whereNull('wjm')->whereNull('wjk')
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Sakit 0.5')->get();
                        $telat = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->where('mlate','!=',0)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->whereNull('keterangan')->count();
                        $ijin = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Ijin')->count();    
                        $jumlahKar=\App\Models\Employee::where('nik',$value->nik)->count();
                        $totalharikerja=$jumlahKar*$jumlahharikerja;
                        $cuti = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->whereNull('wjm')->whereNull('wjk')
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Cuti')->count();
                        $cutiSetengah = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Cuti 0.5')->count();
                        $jumlahCuti = $cuti + ($cutiSetengah/2);
                        $cekCuti = \App\Models\Cuti::where('nik',$value->nik)
                                                    ->whereBetween('tgl_cuti_awal',[$dateFrom,$dateTo])
                                                    ->get();
                        $datahakcuti = \App\Models\Datahakcuti::where('tahun',$tahun)->where('nik',$value->nik)->first();
                        if(!empty($datahakcuti)){
                          $sisa_cuti_tahunan = $datahakcuti->sisa_cuti_tahunan;
                          $sisa_cuti_khusus = $datahakcuti->sisa_cuti_khusus;
                          $sisa_cuti_besar = $datahakcuti->sisa_cuti_besar;
                        }else{
                          $sisa_cuti_tahunan = '-';
                          $sisa_cuti_khusus = '-';
                          $sisa_cuti_besar = '-';
                        }
                        if(count($cekCuti) > 0){
                          $cs = [];
                          $c=0;
                          foreach ($cekCuti as $value) {
                              if(in_array($value->tgl_cuti_awal, $dateSakit)){
                                $cs[$c++] = $value->tgl_cuti_awal;
                              }
                          }
                          $sakitCuti = count($cs);
                        }else{
                          $sakitCuti = 0;
                        }
                        $totalsakit = (count($sakit) + (count($sakitsetengah)/2))-$sakitCuti;
                        $totalsti = $telat+$ijin+$totalsakit;                          
                        $totalcuti = $jumlahCuti + $sakitCuti;
                        if(count($cekAbsen)>0){
                          $totalketidakhadiran = $totalsti+$totalcuti;
                          $persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
                          $persentidakHadirsti = round(($totalsti / $totalharikerja) * 100,2);
                          $persentelat = round(($telat / $totalharikerja) * 100,2);
                          $persenhadir = round(100-$persentidakHadir,2);
                          $persentepatwaktu = round(100-$persentelat,2);
                        }else{
                          $totalketidakhadiran = "N/A";
                          $persentidakHadir = "N/A";
                          $persentidakHadirsti = "N/A";
                          $persentelat = "N/A";
                          $persenhadir = "N/A";
                          $persentepatwaktu = "N/A";
                        }
                        ?>
                        <td>{{$value->nik}}</td>
                        <td>{{$value->nama}}</td>
                        <td><div align="center">{{$jumlahKar}}</div></td>
                        <td><div align="center">{{$jumlahharikerja}}</div></td>
                        <td><div align="center">{{$totalharikerja}}</div></td>
                        <td><div align="center">{{$jumlahCuti}}</div></td>
                        <td><div align="center">{{$sakitCuti}}</div></td>
                        <td><div align="center">{{$totalcuti}}</div></td>
                        <td><div align="center">{{$totalsakit}}</div></td>
                        <td><div align="center">{{$telat}}</div></td>
                        <td><div align="center">{{$ijin}}</div></td>
                        <td><div align="center">{{$totalsti}}</div></td>
                        <td><div align="center">{{$totalketidakhadiran}}</div></td>
                        <td><div align="center">{{$sisa_cuti_tahunan}}</div></td>
                        <td><div align="center">{{$sisa_cuti_khusus}}</div></td>
                        <td><div align="center">{{$sisa_cuti_besar}}</div></td>
                        <td><div align="center">{{$persentidakHadir}}</div></td>
                        <td><div align="center">{{$persentidakHadirsti}}</div></td>
                        <td><div align="center">{{$persentelat}}</div></td>
                        <td><div align="center">{{$persenhadir}}</div></td>
                        <td><div align="center">{{$persenhadir}}</div></td>
                        <td><div align="center">{{$persentepatwaktu}}</div></td>
                    </tr>
                @endforeach
              @else
                @foreach($names as $key => $value)
                <?php
                  $z++;
                ?>
                    <tr>
                        <td>{{$z}}</td>
                        @if($berdasarkan == 1)
                        <?php
                        $cekAbsen = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])->get();
                        $sakit = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->whereNull('wjm')->whereNull('wjk')
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Sakit')->get();
                        //Get Date Sakit
                        $dateS=[];
                        $h=0;                                              
                        if(count($sakit) > 0){
                          for($i=0; $i<count($sakit); $i++)
                          {
                              $dateS[$h] = $sakit[$i]->date;
                              $dateS[$h++];
                          }
                          $dateSakit = $dateS;
                        }
                        $sakitsetengah = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->whereNull('wjm')->whereNull('wjk')
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Sakit 0.5')->get();
                        $telat = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->where('mlate','!=',0)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->whereNull('keterangan')->count();
                        $ijin = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Ijin')->count();    
                        $jumlahKar=\App\Models\Employee::where('nik',$value->nik)->count();
                        $totalharikerja=$jumlahKar*$jumlahharikerja;
                        $cuti = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)->whereNull('wjm')->whereNull('wjk')
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Cuti')->count();
                        $cutiSetengah = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->where('keterangan','Cuti 0.5')->count();
                        $jumlahCuti = $cuti + ($cutiSetengah/2);
                        $cekCuti = \App\Models\Cuti::where('nik',$value->nik)
                                                    ->whereBetween('tgl_cuti_awal',[$dateFrom,$dateTo])
                                                    ->get();
                        $datahakcuti = \App\Models\Datahakcuti::where('tahun',$tahun)->where('nik',$value->nik)->first();
                        if(!empty($datahakcuti)){
                          $sisa_cuti_tahunan = $datahakcuti->sisa_cuti_tahunan;
                          $sisa_cuti_khusus = $datahakcuti->sisa_cuti_khusus;
                          $sisa_cuti_besar = $datahakcuti->sisa_cuti_besar;
                        }else{
                          $sisa_cuti_tahunan = '-';
                          $sisa_cuti_khusus = '-';
                          $sisa_cuti_besar = '-';
                        }
                        if(count($cekCuti) > 0){
                          $cs = [];
                          $c=0;
                          foreach ($cekCuti as $value) {
                              if(in_array($value->tgl_cuti_awal, $dateSakit)){
                                $cs[$c++] = $value->tgl_cuti_awal;
                              }
                          }
                          $sakitCuti = count($cs);
                        }else{
                          $sakitCuti = 0;
                        }
                        $totalsakit = (count($sakit) + (count($sakitsetengah)/2))-$sakitCuti;
                        $totalsti = $telat+$ijin+$totalsakit;                          
                        $totalcuti = $jumlahCuti + $sakitCuti;
                        if(count($cekAbsen)>0){
                          $totalketidakhadiran = $totalsti+$totalcuti;
                          $persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
                          $persentidakHadirsti = round(($totalsti / $totalharikerja) * 100,2);
                          $persentelat = round(($telat / $totalharikerja) * 100,2);
                          $persenhadir = round(100-$persentidakHadir,2);
                          $persentepatwaktu = round(100-$persentelat,2);
                        }else{
                          $totalketidakhadiran = "N/A";
                          $persentidakHadir = "N/A";
                          $persentidakHadirsti = "N/A";
                          $persentelat = "N/A";
                          $persenhadir = "N/A";
                          $persentepatwaktu = "N/A";
                        }
                        ?>
                        <td>{{$value->nik}}</td>
                        <td>{{$value->nama}}</td>
                        <td><div align="center">{{$jumlahKar}}</div></td>
                        <td><div align="center">{{$jumlahharikerja}}</div></td>
                        <td><div align="center">{{$totalharikerja}}</div></td>
                        <td><div align="center">{{$jumlahCuti}}</div></td>
                        <td><div align="center">{{$sakitCuti}}</div></td>
                        <td><div align="center">{{$totalcuti}}</div></td>
                        <td><div align="center">{{$totalsakit}}</div></td>
                        <td><div align="center">{{$telat}}</div></td>
                        <td><div align="center">{{$ijin}}</div></td>
                        <td><div align="center">{{$totalsti}}</div></td>
                        <td><div align="center">{{$totalketidakhadiran}}</div></td>
                        <td><div align="center">{{$sisa_cuti_tahunan}}</div></td>
                        <td><div align="center">{{$sisa_cuti_khusus}}</div></td>
                        <td><div align="center">{{$sisa_cuti_besar}}</div></td>
                        <td><div align="center">{{$persentidakHadir}}</div></td>
                        <td><div align="center">{{$persentidakHadirsti}}</div></td>
                        <td><div align="center">{{$persentelat}}</div></td>
                        <td><div align="center">{{$persenhadir}}</div></td>
                        <td><div align="center">{{$persenhadir}}</div></td>
                        <td><div align="center">{{$persentepatwaktu}}</div></td>
                        @else
                        <?php
                          $cekAbsen = \App\Models\Absensi::where('dept_id',$value->id)
                                                        ->whereBetween('date',[$dateFrom,$dateTo])->get();
                          $jumlahKar = \App\Models\Employee::where('dept_id',$value->id)->get();
                          $totalharikerja=count($jumlahKar)*$jumlahharikerja;
                          $sakit = \App\Models\Absensi::where('dept_id',$value->id)->whereNull('wjm')->whereNull('wjk')
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->where('keterangan','Sakit')->get();
                          //Get Date Sakit
                          $dateS=[];
                          $h=0;                                              
                          if(count($sakit) > 0){
                            for($i=0; $i<count($sakit); $i++)
                            {
                                $dateS[$h] = $sakit[$i]->date;
                                $dateS[$h++];
                            }
                            $dateSakit = $dateS;
                          }
                          
                          $sakitsetengah = \App\Models\Absensi::where('dept_id',$value->id)->whereNull('wjm')->whereNull('wjk')
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->where('keterangan','Sakit 0.5')->get();
                          $telat = \App\Models\Absensi::where('dept_id',$value->id)->where('mlate','!=',0)
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->whereNull('keterangan')->count();
                          $ijin = \App\Models\Absensi::where('dept_id',$value->id)
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->where('keterangan','Ijin')->count();

                          $cuti = \App\Models\Absensi::where('dept_id',$value->id)->whereNull('wjm')->whereNull('wjk')
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->where('keterangan','Cuti')->count();
                          $cutiSetengah = \App\Models\Absensi::where('dept_id',$value->id)
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->where('keterangan','Cuti 0.5')->count();

                          $cekCuti = \App\Models\Cuti::where('kd_divisi',$value->id)
                                                      ->whereBetween('tgl_cuti_awal',[$dateFrom,$dateTo])
                                                      ->get();
                          $datahakcuti = \App\Models\Datahakcuti::where('tahun',$tahun)->where('nik',$value->nik)->first();
                          if(!empty($datahakcuti)){
                            $sisa_cuti_tahunan = $datahakcuti->sisa_cuti_tahunan;
                            $sisa_cuti_khusus = $datahakcuti->sisa_cuti_khusus;
                            $sisa_cuti_besar = $datahakcuti->sisa_cuti_besar;
                          }else{
                            $sisa_cuti_tahunan = '-';
                            $sisa_cuti_khusus = '-';
                            $sisa_cuti_besar = '-';
                          }
                          if(count($cekCuti) > 0){
                            $cs = [];
                            $c=0;
                            foreach ($cekCuti as $value) {
                                if(in_array($value->tgl_cuti_awal, $dateSakit)){
                                  $cs[$c++] = $value->tgl_cuti_awal;
                                }
                            }
                            $sakitCuti = count($cs);
                          }else{
                            $sakitCuti = 0;
                          }

                          $jumlahCuti = $cuti + ($cutiSetengah/2);

                          $totalsakit = (count($sakit) + (count($sakitsetengah)/2))-$sakitCuti;
                          $totalsti = $telat+$ijin+$totalsakit;
                          $totalcuti = $jumlahCuti + $sakitCuti;
                          if(count($cekAbsen)>0){
                            $totalketidakhadiran = $totalsti+$totalcuti;
                            $persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
                            $persentidakHadirsti = round(($totalsti / $totalharikerja) * 100,2);
                            $persentelat = round(($telat / $totalharikerja) * 100,2);
                            $persenhadir = round(100-$persentidakHadir,2);
                            $persentepatwaktu = round(100-$persentelat,2);  
                          }else{
                            $totalketidakhadiran = "N/A";
                            $persentidakHadir = "N/A";
                            $persentidakHadirsti = "N/A";
                            $persentelat = "N/A";
                            $persenhadir = "N/A";
                            $persentepatwaktu = "N/A";
                          }
                        ?>
                        <td>{{$value->department}}</td>
                        <td>{{$value->unit}}</td>
                        <td><div align="center">{{count($jumlahKar)}}</div></td>
                        <td><div align="center">{{$jumlahharikerja}}</div></td>
                        <td><div align="center">{{$totalharikerja}}</div></td>
                        <td><div align="center">{{$jumlahCuti}}</div></td>
                        <td><div align="center">{{$sakitCuti}}</div></td>
                        <td><div align="center">{{$totalcuti}}</div></td>
                        <td><div align="center">{{$totalsakit}}</div></td>
                        <td><div align="center">{{$telat}}</div></td>
                        <td><div align="center">{{$ijin}}</div></td>
                        <td><div align="center">{{$totalsti}}</div></td>
                        <td><div align="center">{{$totalketidakhadiran}}</div></td>
                        <td><div align="center">{{$sisa_cuti_tahunan}}</div></td>
                        <td><div align="center">{{$sisa_cuti_khusus}}</div></td>
                        <td><div align="center">{{$sisa_cuti_besar}}</div></td>
                        <td><div align="center">{{$persentidakHadir}}</div></td>
                        <td><div align="center">{{$persentidakHadirsti}}</div></td>
                        <td><div align="center">{{$persentelat}}</div></td>
                        <td><div align="center">{{$persenhadir}}</div></td>
                        <td><div align="center">{{$persenhadir}}</div></td>
                        <td><div align="center">{{$persentepatwaktu}}</div></td>
                        @endif
                    </tr>
                @endforeach
              @endif
           </tbody>
      </table>
      </div>
      </div>
      <div class="pull-right" style="margin-right: 13px;padding-top: 10px;">
        <button type="submit" class="btn btn-sm btn-primary">Export</button>
      </div>
    </form>
</div>