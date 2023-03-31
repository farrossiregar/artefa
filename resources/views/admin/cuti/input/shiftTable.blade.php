<!-- <form> -->
  <?php
  $countHour = count($shiftHours);
  ?>
  <input type="hidden" id="countHour" value="{{$countHour}}">
  <input type="hidden" id="lastDay" value="{{$lastDay}}">
  <div class="col-md-12" style="width: 1032px; overflow:auto;">
    <table class="table table-striped table-bordered table-hover" width="1200">
         <thead>
            <tr>
                <th rowspan="2"><div align="center">No</div></th>
                <th rowspan="2" valign="center"><div align="center" style="width: 100px;">Waktu</div></th>
                @foreach($getDays as $getDay)
                <th>{{$getDay}}</th>
                @endforeach
            </tr>
            <tr>
              @for($i=1;$i<=$lastDay;$i++)
              <th>{{$i}}</th>
              @endfor
            </tr>
         </thead>
         <tbody>
          <?php
            $z=0;
          ?>
            @foreach($shiftHours as $key => $data)
          <?php
            $z++;
          ?>
            <tr>
              <td width="1%"><span style="display: table;margin: auto;">{{$z}}</span></td>
              <td  class="col-md-2"><span style="display: table;margin: auto;">{{$data->hour}}</span></td>
              @for($i=1;$i<=$lastDay;$i++)
              <td width="10%">
                  <select style="width: 42px" id="hour{{$data->id}}&day{{$i}}" name="{{$data->id}}&{{$i}}">
                    <option  disabled="true">--Pilih Karyawan--</option>
                    <option selected="true" value="{{$data->id}}&{{$i}}-BSDAP">BSDAP</option>
                  </select>
              </td>
              @endfor
            </tr>
            @endforeach
         </tbody>
    </table>
  </div>
  <div class="col-md-12" style="padding-top: 10px">
    <div class="row">
      <button class="btn btn-success" onclick="saveScheduleShift()"><i class="icon-ok"></i> Simpan</button>
      <button class="btn btn-danger"><i class="icon-remove"></i> Reset</button>
    </div>
  </div>
<!-- </form> -->