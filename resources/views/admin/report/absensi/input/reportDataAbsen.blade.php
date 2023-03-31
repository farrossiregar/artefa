<div class="panel panel-default">
    <div class="panel-heading flex-center">
        <b>Report Absensi Karyawan</b>
    </div>
    <form action="{{url('/')}}/backend/exportabsensi" method="POST">
      {{csrf_field()}}
        <div class="col-md-12" style="width: 1057px; overflow:auto;">
        <div style="max-height: 350px; overflow-y: scroll;">
        <table class="table table-bordered table-hover" width="1200">
            <thead>
                <tr>
                    <th bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">No</div></th>
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" >Tanggal</div></th>
                    @if($berdasarkan == 1 || $berdasarkan == 3)
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" >NIK</div></th>
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
                    @else
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Department</div></th>
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Unit</div></th>
                    @endif
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Jam Masuk</div></th>
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Jam Keluar</div></th>
                    <th valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">Keterangan</div></th>
                </tr>
           </thead>
           <tbody>
              @if($berdasarkan == 3)
                <?php $employees = \App\Models\Employee::where('id',$idKar)->get(); ?>
                @foreach($employees as $key => $value)
                <?php
                  $z=0;
                  $cekAbsen = \App\Models\Absensi::where('nik',$value->nik)
                                                      ->where('dept_id',$value->dept_id)
                                                      ->whereBetween('date',[$dateFrom,$dateTo])
                                                      ->orderBy('nik', 'asc')->get();
                ?>
                  @foreach($cekAbsen as $data)
                  <?php $z++; ?>
                    <tr>
                        <td>{{$z}}</td>
                        <td>{{\Carbon\Carbon::parse($data->date)->format('d-m-Y')}}</td>
                        <td>{{$value->nik}}</td>
                        <td>{{$value->nama}}</td>
                        <td>{{$data->wjm}}</td>
                        <td>{{$data->wjk}}</td>
                        @if(!empty($data->keterangan))
                        <td>{{$data->keterangan}}</td>
                        @else
                        <?php
                        if($data->mlate != 0){
                          $keterangan = 'Terlambat '.$data->mlate.' Menit';
                        }else{
                          $keterangan = '';
                        }
                        ?>
                        <td>{{$keterangan}}</td>
                        @endif
                    </tr>
                  @endforeach
                @endforeach
              @else
                @foreach($names as $key => $value)
                  @if($berdasarkan == 1)
                    <?php
                      $z=0;
                      $cekAbsen = \App\Models\Absensi::where('nik',$value->nik)
                                                    ->where('dept_id',$value->dept_id)
                                                    ->whereBetween('date',[$dateFrom,$dateTo])
                                                    ->orderBy('nik', 'asc')->get();
                    ?>
                    @foreach($cekAbsen as $data)
                    <?php $z++; ?>
                      <tr>
                          <td>{{$z}}</td>
                          <td>{{\Carbon\Carbon::parse($data->date)->format('d-m-Y')}}</td>
                          <td>{{$value->nik}}</td>
                          <td>{{$value->nama}}</td>
                          <td>{{$data->wjm}}</td>
                          <td>{{$data->wjk}}</td>
                          @if(!empty($data->keterangan))
                          <td>{{$data->keterangan}}</td>
                          @else
                          <?php
                          if($data->mlate != 0){
                            $keterangan = 'Terlambat '.$data->mlate.' Menit';
                          }else{
                            $keterangan = '';
                          }
                          ?>
                          <td>{{$keterangan}}</td>
                          @endif
                      </tr>
                    @endforeach
                  @else
                    <tr>
                        <?php
                        ($value->department == $value->unit)?$unitdept = $value->unit:$unitdept = $value->department.' - '.$unitdept = $value->unit;
                        ?>
                        <td colspan="11" bgcolor="#c5ed4e"><b>{{$unitdept}}</b></td>
                    </tr>
                    <tr>
                      <?php
                        $employees = \App\Models\Employee::where('dept_id',$value->id)
                                                    ->where('status',1)->get();
                      ?>
                      @foreach($employees as $data)
                        <?php 
                          $z=0;
                          $cekAbsen = \App\Models\Absensi::where('nik',$data->nik)
                                                        ->where('dept_id',$data->dept_id)
                                                        ->whereBetween('date',[$dateFrom,$dateTo])
                                                        ->orderBy('nik', 'asc')->get();
                        ?>
                        @foreach($cekAbsen as $val)
                          <?php $z++; ?>
                            <tr>
                                <td>{{$z}}</td>
                                <td>{{\Carbon\Carbon::parse($val->date)->format('d-m-Y')}}</td>
                                <td>{{$data->nik}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$val->wjm}}</td>
                                <td>{{$val->wjk}}</td>
                                @if(!empty($val->keterangan))
                                <td>{{$val->keterangan}}</td>
                                @else
                                <?php
                                if($val->mlate != 0){
                                  $keterangan = 'Terlambat '.$val->mlate.' Menit';
                                }else{
                                  $keterangan = '';
                                }
                                ?>
                                <td>{{$keterangan}}</td>
                                @endif
                            </tr>
                        @endforeach
                      @endforeach
                    </tr>
                  @endif
                @endforeach
              @endif
           </tbody>
      </table>
      </div>
      </div>
      <div class="pull-right" style="margin-right: 13px;padding-top: 10px;">
        <!-- <button type="submit" class="btn btn-sm btn-primary">Export</button> -->
      </div>
    </form>
</div>