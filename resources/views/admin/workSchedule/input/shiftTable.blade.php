  <input type="hidden" id="employees" value="{{$employees}}">
  <input type="hidden" id="lastDay" value="{{$lastDay}}">
  <div class="col-md-12">
    <div class="zui-wrapper">
        <div class="zui-scroller">
            <table class="zui-table" border="1">
                <thead>
                    <tr>
                        <th class="zui-sticky-col" rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
                        @foreach($getDays as $getDay)
                        <th @if(in_array($getDay['tgl'], $arrayTglMerah)) bgcolor="#eda8a8" @else bgcolor="#6cddbf" @endif><div align="center" style="width: 45px;">{{$getDay['days']}} ({{$getDay['tgl2']}})</div></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $z=0;
                    ?>
                    @foreach($employees as $key => $employee)
                    <?php
                      $z++;
                    ?>
                      <tr>
                        <td  class="col-md-2 zui-sticky-col"><span>{{$employee->nama}}</span></td>
                        @for($i=1;$i<=$lastDay;$i++)
                        @php
                          if($i<=9){
                              $value = $year."-".$month."-0".$i;
                          }else{
                              $value = $year."-".$month."-".$i;
                          }
                        @endphp
                        <td width="10%" @if(in_array($value, $arrayTglMerah)) bgcolor="#eda8a8" @endif>
                            <select style="width: 42px" @if(in_array($value, $arrayTglMerah)) style="background: #eda8a8;" @endif id="{{$employee->id}}&{{$i}}" name="{{$employee->id}}&{{$i}}">
                              <option selected="true"><span style="display: table;margin: auto;">--Pilih Jam--</span></option>
                              @foreach($schedules as $schedule)
                              @php
                                $start = \Carbon\Carbon::parse($schedule->time_schedule_awal)->format('H:i');
                                $end = \Carbon\Carbon::parse($schedule->time_schedule_akhir)->format('H:i');
                              @endphp
                              <option value="{{$employee->nik}}&{{$i}}-{{$schedule->code}}">
                                <span style="display: table;margin: auto;">{{$schedule->code}} - ({{$start}} - {{$end}})</span>
                              </option>
                              @endforeach
                            </select>
                        </td>
                        @endfor
                      </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- <div style="max-height: 300px; overflow-y: scroll;">
    <table class="table  table-bordered " width="1200">
         <thead>
            <tr>
                <th rowspan="2" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center">No</div></th>
                <th rowspan="2" valign="center" bgcolor="#6cddbf" style="vertical-align: middle;"><div align="center" style="width: 150px;">Nama</div></th>
                @foreach($getDays as $getDay)
                <th @if(in_array($getDay['tgl'], $arrayTglMerah)) bgcolor="#eda8a8" @else bgcolor="#6cddbf" @endif><div align="center" style="width: 45px;">{{$getDay['days']}}</div></th>
                @endforeach
            </tr>
            <tr>
              @for($i=1;$i<=$lastDay;$i++)
              @php
                if($i<=9){
                    $value = $year."-".$month."-0".$i;
                }else{
                    $value = $year."-".$month."-".$i;
                }
              @endphp
              <th @if(in_array($value, $arrayTglMerah)) bgcolor="#eda8a8" @else bgcolor="#6cddbf" @endif><div align="center" style="width: 45px;">{{$i}}</div></th>
              @endfor
            </tr>
         </thead>
         <tbody>
          <?php
            $z=0;
          ?>
          @foreach($employees as $key => $employee)
          <?php
            $z++;
          ?>
            <tr>
              <td><span style="display: table;margin: auto;">{{$z}}</span></td>
              <td  class="col-md-2"><span>{{$employee->nama}}</span></td>
              @for($i=1;$i<=$lastDay;$i++)
              @php
                if($i<=9){
                    $value = $year."-".$month."-0".$i;
                }else{
                    $value = $year."-".$month."-".$i;
                }
              @endphp
              <td width="10%" @if(in_array($value, $arrayTglMerah)) bgcolor="#eda8a8" @endif>
                  <select style="width: 42px" @if(in_array($value, $arrayTglMerah)) style="background: #eda8a8;" @endif id="{{$employee->id}}&{{$i}}" name="{{$employee->id}}&{{$i}}">
                    <option selected="true" disabled="true"><span style="display: table;margin: auto;">--Pilih Jam--</span></option>
                    @foreach($schedules as $schedule)
                    @php
                      $start = \Carbon\Carbon::parse($schedule->time_schedule_awal)->format('H:i');
                      $end = \Carbon\Carbon::parse($schedule->time_schedule_akhir)->format('H:i');
                    @endphp
                    <option value="{{$employee->nik}}&{{$i}}-{{$schedule->code}}">
                      <span style="display: table;margin: auto;">{{$schedule->code}} - ({{$start}} - {{$end}})</span>
                    </option>
                    @endforeach
                  </select>
              </td>
              @endfor
            </tr>
          @endforeach
         </tbody>
    </table>
    </div> -->
  </div>
  <div class="col-md-12" style="padding-top: 10px">
    <div class="row">
      <button class="btn btn-success" onclick="saveScheduleShift({{$employees}})"><i class="icon-ok"></i> Simpan</button>
      <!-- <button class="btn btn-danger"><i class="icon-remove"></i> Reset</button> -->
    </div>
  </div>

