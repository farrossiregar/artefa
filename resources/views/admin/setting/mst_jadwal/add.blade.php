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
                <form action="{{url('/')}}/backend/mst/jadwal/shift/store" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="message-text" class="col-form-label">Kode Jadwal<span style="color: red;font-size: 19px"><b>*</b></span></label>
                          <input type="text" name="code" class="form-control" required="true" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Department<span style="color: red;font-size: 19px"><b>*</b></span></label>
                        <select data-placeholder="Choose a Country" name="dept_id" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- PILIH DEPARTMENT --</option>
                            @foreach($departments as $departement)
                            <option value="{{$departement->id}}"> {{$departement->department}} - {{$departement->unit}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="message-text" class="col-form-label">Jam Masuk Awal<span style="color: red;font-size: 19px"><b>*</b></span></label>
                          <div class="input-group bootstrap-timepicker">
                              <input class="timepicker form-control" type="text" name="time_awal" autocomplete="off">
                              <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="message-text" class="col-form-label">Jam Masuk Akhir<span style="color: red;font-size: 19px"><b>*</b></span></label>
                          <div class="input-group bootstrap-timepicker">
                              <input class="timepicker form-control" type="text" name="time_akhir" autocomplete="off">
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
