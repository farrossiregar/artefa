@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> VIew Jadwal Shift </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="box dark">
            <header>
                <h5>Master Jadwal Shift</h5>
                <div class="toolbar btneditKar">
                    <ul class="nav">
                        <li><a href="{{url('/')}}/backend/mst/jadwal/shift" ><i class="icon-step-backward"></i> Back</a></li>
                    </ul>
                </div>
            </header>
            <div id="div-1" class="accordion-body collapse in body">
                <form action="{{url('/')}}/backend/mst/jadwal/shift/update/{{$schedule->id}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="message-text" class="col-form-label">Kode Jadwal<span style="color: red;font-size: 19px"><b>*</b></span></label>
                          <input type="text" name="code" class="form-control" required="true" disabled="true" autocomplete="off"value="{{$schedule->code}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Department<span style="color: red;font-size: 19px"><b>*</b></span></label>
                        <?php
                          ($schedule->department->department == $schedule->department->unit)?$unitdept = $schedule->department->unit:$unitdept = $schedule->department->department.' - '.$unitdept = $schedule->department->unit;
                        ?>
                        <input type="text" name="code" class="form-control" required="true" disabled="true" autocomplete="off"value="{{$unitdept}}">
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="message-text" class="col-form-label">Jam Masuk Awal<span style="color: red;font-size: 19px"><b>*</b></span></label>
                          <div class="input-group bootstrap-timepicker">
                              <input class="timepicker form-control" type="text" name="time_awal" autocomplete="off" value="{{\Carbon\Carbon::parse($schedule->time_schedule_awal)->format('H:i')}}"/>
                              <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="message-text" class="col-form-label">Jam Masuk Akhir<span style="color: red;font-size: 19px"><b>*</b></span></label>
                          <div class="input-group bootstrap-timepicker">
                              <input class="timepicker form-control" type="text" name="time_akhir" autocomplete="off" value="{{\Carbon\Carbon::parse($schedule->time_schedule_akhir)->format('H:i')}}">
                              <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-flat btn-primary btn-block">Simpan</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
