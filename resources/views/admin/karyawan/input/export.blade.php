<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Report Karyawan - ".\Carbon\Carbon::now()->format('d-F-Y').".xls");
?>
  <div class="col-md-12" style="width: 1032px; overflow:auto;">
  <div style="max-height: 300px; overflow-y: scroll;">
  <table class="table table-striped table-bordered table-hover" width="100%">
    <tbody>
      <tr>
        @if($dept_id == 'all')
        <th colspan="{{$cols}}"><div align="center"><h3>Report Semua Karyawan</h3></div></th>
        @else
        <?php
        $dept=\App\Models\Departement::where('id',$dept_id)->first();
        ($dept->department == $dept->unit)?$unitdept = $dept->unit:$unitdept = $dept->department.' - '.$unitdept = $dept->unit;
        ?>
        <th colspan="{{$cols}}"><div align="center"><h3>Report Karyawan Dept. {{$unitdept}}</h3></div></th>
        @endif
      </tr>
      <tr>
        <th colspan="{{$cols}}"><div align="center">Dibuat pada : {{$now}}</div></th>
      </tr>
    </tbody>
  </table>
  <br>
  <table class="table table-bordered" border="1">
      <thead>
          <tr bgcolor="#6cddbf">
              <th style="vertical-align: middle;"><div align="center">No</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 70px">NIK</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 150px">Nama</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 150px">User Id</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 150px">Email</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Level</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 120px">Jabatan</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Shift/NonShift</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Uang Transport</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Uang Makan</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Tgl Join</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Tgl Resign</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Status</div></th>
              <th style="vertical-align: middle;"><div align="center" style="width: 100px">Remark</div></th>
          </tr>
      </thead>
      <tbody>
      @if($dept_id == 'all')
        @foreach($data as $departement)
        <tr>
          <?php
          ($departement->department == $departement->unit)?$unitdept = $departement->unit:$unitdept = $departement->department.' - '.$unitdept = $departement->unit;
          ?>
              <td colspan="14" bgcolor="#c5ed4e"><b>{{$unitdept}}</b></td>
        </tr>
        <?php
          $employees = \App\Models\Employee::where('dept_id',$departement->id)->get();
          $z=0;
        ?>
          @foreach($employees as $employee)
            <?php $z++; ?>
            <tr>
                <td><span style="display: table;margin: auto;">{{$z}}</span></td>
                <td><span>{{$employee->nik}}</span></td>
                <td><span>{{$employee->nama}}</span></td>
                <td><span><div align="center">{{$employee->userid}}</div></span></td>
                <td><span>{{$employee->email}}</span></td>
                <td><span>{{$employee->level}}</span></td>
                <td><span>{{$employee->jabatan}}</span></td>
                @if($employee->shifting == 'Y')
                    <td><span>Shift</span></td>
                @else
                    <td><span>Non Shift</span></td>
                @endif
                <td><span>{{$employee->ut}}</span></td>
                <td><span>{{$employee->um}}</span></td>
                <td><span>{{\Carbon\Carbon::parse($employee->tgl_join)->format('d/M/Y')}}</span></td>
                <?php 
                if($employee->status == 1){
                  $status = 'Aktif';
                }else{
                  $status = 'Nonaktif';
                }
                ?>
                @if($employee->tgl_resign != '1970-01-01')
                <td><span style="display: table;margin: auto;">{{\Carbon\Carbon::parse($employee->tgl_resign)->format('d/M/Y')}}</span></td>
                @else
                <td><span><div align="center">-</div></span></td>
                @endif
                <td><span style="display: table;margin: auto;">{{$status}}</span></td>
                <td><span style="display: table;margin: auto;">{{$employee->remark}}</span></td>
            </tr>
          @endforeach
        @endforeach
      @else
        <?php
          $z=0;
        ?>
        @foreach($data as $employee)
        <?php
          $z++;
        ?>
        <tr>
            <td><span style="display: table;margin: auto;">{{$z}}</span></td>
            <td><span>{{$employee->nik}}</span></td>
            <td><span>{{$employee->nama}}</span></td>
            <td><span><div align="center">{{$employee->userid}}</div></span></td>
            <td><span>{{$employee->email}}</span></td>
            <td><span>{{$employee->level}}</span></td>
            <td><span>{{$employee->jabatan}}</span></td>
            @if($employee->shifting == 'Y')
                <td><span>Shift</span></td>
            @else
                <td><span>Non Shift</span></td>
            @endif
            <td><span>{{$employee->ut}}</span></td>
            <td><span>{{$employee->um}}</span></td>
            <td><span>{{\Carbon\Carbon::parse($employee->tgl_join)->format('d/M/Y')}}</span></td>
            <?php 
            if($employee->status == 1){
              $status = 'Aktif';
            }else{
              $status = 'Nonaktif';
            }
            ?>
            @if($employee->tgl_resign != '1970-01-01')
            <td><span style="display: table;margin: auto;">{{\Carbon\Carbon::parse($employee->tgl_resign)->format('d/M/Y')}}</span></td>
            @else
            <td><span><div align="center">-</div></span></td>
            @endif
            <td><span style="display: table;margin: auto;">{{$status}}</span></td>
            <td><span style="display: table;margin: auto;">{{$employee->remark}}</span></td>
        </tr>
        @endforeach
      @endif
      </tbody>
  </table>
</div>
</div>