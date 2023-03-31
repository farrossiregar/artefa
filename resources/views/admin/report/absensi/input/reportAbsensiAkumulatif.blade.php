<div class="panel panel-default">
    <div class="panel-heading flex-center">
        <b>Report Absensi Akumulatif Karyawan</b>
    </div>
    <form action="{{url('/')}}/backend/exportabsensi" method="POST">
      {{csrf_field()}}
      <input type="hidden" name="var1" value="{{$var1}}">
      <input type="hidden" name="dept_id" value="{{$dept_id}}">
      <input type="hidden" name="berdasarkan" value="{{$berdasarkan}}">
      <input type="hidden" name="tipe" value="{{$tipe}}">
      <input type="hidden" name="tahun" value="{{$tahun}}">
      <input type="hidden" name="id_kar" value="{{$idKar}}">
        <div class="col-md-12" style="width: 1057px; overflow:auto;">
        <div style="max-height: 300px; overflow-y: scroll;">
        <table class="table table-striped table-bordered table-hover " width="1200">
            <thead>
                <tr>
                    <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">No</div></th>
                    @if($berdasarkan == 1 || $berdasarkan == 3)
                    <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 100px;">NIK</div></th>
                    <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
                    @else
                    <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Department</div></th>
                    <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Unit</div></th>
                    @endif
                    <th colspan="{{count($months)}}" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Persentasi %</div></th>
                </tr>
                <tr>
                  @foreach($months as $month)
                  <th bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">{{$month->M}}</div></th>
                  @endforeach
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
                      <td>{{$value->nik}}</td>
                      <td>{{$value->nama}}</td>
                      @foreach($months as $month)
                      <?php
                      $dateFrom = $tahun.'-'.$month->id.'-01';
                      $dateTo = date("Y-m-t", strtotime($dateFrom));
                      $checkAbsensi = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])->get();
                      if(count($checkAbsensi) > 0){
                        $endperiod = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
                        $start = new DateTime($dateFrom);
                        $endperiod = new DateTime($endperiod);
                        $interval = DateInterval::createFromDateString('1 days');
                        $period   = new DatePeriod($start, $interval, $endperiod);
                        $days=[];
                        $h=0;
                        foreach ($period as $dt) {
                            $list = $dt->format("Y m d-D");
                            $day = substr($list, -3);
                            if($day == 'Sun'){
                               $days[$h] = $dt->format("Y-m-d");
                               $days[$h++];
                            }
                        }
                        $getSunDays = count($days);

                        $end = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
                        $totalhari = $start->diff($end)->days+1;

                        $countTglMerah = \App\Models\TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
                        $jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
                        $jumlahKar=\App\Models\Employee::where('nik',$value->nik)->count();
                        $totalharikerja=$jumlahKar*$jumlahharikerja;

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
                        $totalketidakhadiran = $totalsti+$totalcuti;
                        $persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
                        $persenhadir = round(100-$persentidakHadir,2);
                      }else{
                        $persenhadir = 'N/A';
                      }
                      ?>
                      <td><div align="center">{{$persenhadir}}</div></td>
                      @endforeach
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
                      <td>{{$value->nik}}</td>
                      <td>{{$value->nama}}</td>
                      @foreach($months as $month)
                      <?php
                      $dateFrom = $tahun.'-'.$month->id.'-01';
                      $dateTo = date("Y-m-t", strtotime($dateFrom));
                      $checkAbsensi = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])->get();
                      if(count($checkAbsensi) > 0){
                        $endperiod = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
                        $start = new DateTime($dateFrom);
                        $endperiod = new DateTime($endperiod);
                        $interval = DateInterval::createFromDateString('1 days');
                        $period   = new DatePeriod($start, $interval, $endperiod);
                        $days=[];
                        $h=0;
                        foreach ($period as $dt) {
                            $list = $dt->format("Y m d-D");
                            $day = substr($list, -3);
                            if($day == 'Sun'){
                               $days[$h] = $dt->format("Y-m-d");
                               $days[$h++];
                            }
                        }
                        $getSunDays = count($days);

                        $end = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
                        $totalhari = $start->diff($end)->days+1;

                        $countTglMerah = \App\Models\TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
                        $jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
                        $jumlahKar=\App\Models\Employee::where('nik',$value->nik)->count();
                        $totalharikerja=$jumlahKar*$jumlahharikerja;

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
                        $totalketidakhadiran = $totalsti+$totalcuti;
                        $persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
                        $persenhadir = round(100-$persentidakHadir,2);
                      }else{
                        $persenhadir = 'N/A';
                      }
                      ?>
                      <td><div align="center">{{$persenhadir}}</div></td>
                      @endforeach
                      @else
                      <td>{{$value->department}}</td>
                      <td>{{$value->unit}}</td>
                      @foreach($months as $month)
                      <?php
                      $dateFrom = $tahun.'-'.$month->id.'-01';
                      $dateTo = date("Y-m-t", strtotime($dateFrom));
                      $checkAbsensi = \App\Models\Absensi::where('dept_id',$value->id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])->get();
                      if(count($checkAbsensi) > 0){
                        $endperiod = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
                        $start = new DateTime($dateFrom);
                        $endperiod = new DateTime($endperiod);
                        $interval = DateInterval::createFromDateString('1 days');
                        $period   = new DatePeriod($start, $interval, $endperiod);
                        $days=[];
                        $h=0;
                        foreach ($period as $dt) {
                            $list = $dt->format("Y m d-D");
                            $day = substr($list, -3);
                            if($day == 'Sun'){
                               $days[$h] = $dt->format("Y-m-d");
                               $days[$h++];
                            }
                        }
                        $getSunDays = count($days);

                        $end = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
                        $totalhari = $start->diff($end)->days+1;
                        $jumlahKar = \App\Models\Employee::where('dept_id',$value->id)->get();
                        $countTglMerah = \App\Models\TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
                        $jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
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
                        $totalketidakhadiran = $totalsti+$totalcuti;
                        $totalharikerja=count($jumlahKar)*$jumlahharikerja;
                        $persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
                        $persenhadir = round(100-$persentidakHadir,2);
                      }else{
                        $persenhadir='N/A';
                      }
                      ?>
                      <td><div align="center">{{$persenhadir}}</div></td>
                      @endforeach
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