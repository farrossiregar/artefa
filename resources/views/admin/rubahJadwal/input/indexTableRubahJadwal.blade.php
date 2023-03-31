<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Karyawan (Tukar)</label>
            <select class="form-control" name="karyFrom">
                <option value="" disabled="true" selected="true">-- Pilih Karyawan --</option>
                @foreach($employees as $employee)
                <option value="{{$employee->id}}">{{$employee->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Karyawan (Dengan)</label>
            <select class="form-control" name="karyTo">
                <option value="" disabled="true" selected="true">-- Pilih Karyawan --</option>
                @foreach($employees as $employee)
                <option value="{{$employee->id}}">{{$employee->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" class="form-control datepicker" placeholder="Pilih Tanggal" id="dateFrom" name="dateFrom">
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" class="form-control datepicker" placeholder="Pilih Tanggal" id="dateTo" name="dateTo">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Jam Shift</label>
                <select class="form-control" name="hourIdFrom">
                    <option selected="true" disabled="true"><span style="display: table;margin: auto;">--Pilih Jam--</span></option>
                    @foreach($schedules as $schedule)
                    @php
                      $start = \Carbon\Carbon::parse($schedule->time_schedule_awal)->format('H:i');
                      $end = \Carbon\Carbon::parse($schedule->time_schedule_akhir)->format('H:i');
                    @endphp
                    <option value="{{$schedule->id}}">
                      <span style="display: table;margin: auto;">{{$schedule->code}} - ({{$start}} - {{$end}})</span>
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jam Shift</label>
                <select class="form-control" name="hourIdTo">
                  <option selected="true" disabled="true"><span style="display: table;margin: auto;">--Pilih Jam--</span></option>
                  @foreach($schedules as $schedule)
                  @php
                    $start = \Carbon\Carbon::parse($schedule->time_schedule_awal)->format('H:i');
                    $end = \Carbon\Carbon::parse($schedule->time_schedule_akhir)->format('H:i');
                  @endphp
                  <option value="{{$schedule->id}}">
                    <span style="display: table;margin: auto;">{{$schedule->code}} - ({{$start}} - {{$end}})</span>
                  </option>
                  @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" style="padding-top: 10px">
  <div class="row">
    <button class="btn btn-success" onclick="rubahJadwal()"><i class="icon-ok"></i> Simpan</button>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd-MM-yyyy',
            orientation: "bottom"
        });
    });
</script>