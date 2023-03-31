@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Master Jadwal Shifting </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="box dark">
            <header>
                <h5>List Master Jadwal Shifting</h5>
                <div class="toolbar">
                    <ul class="nav">
                        <li><a href="{{url('/')}}/backend/mst/jadwal/shift/add" class="btn btn-link btn-sm"><i class="icon-plus-sign"> Tambah Jadwal Shifting</i></li></a>
                    </ul>
                </div>
            </header>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th style="vertical-align: middle;"><div align="center">Code</div></th>
                                    <th style="vertical-align: middle;"><div align="center">Jam Masuk Awal</div></th>
                                    <th style="vertical-align: middle;"><div align="center" >Jam Masuk Akhir</div></th>
                                    <th style="vertical-align: middle;"><div align="center" >Action</div></th>
                                </tr>
                            </thead>
                            <?php $i=0; ?>
                            <tbody>
                            @foreach($departments as $departement)
                            <tr>
                              <?php
                                ($departement->department == $departement->unit)?$unitdept = $departement->unit:$unitdept = $departement->department.' - '.$unitdept = $departement->unit;
                              ?>
                                  <td colspan="5" bgcolor="#c5ed4e"><div align="center"><b>{{$unitdept}}</b></div></td>
                            </tr>
                            <?php
                              $schedules = \App\Models\Schedule::where('dept_id',$departement->id)->get();
                              $z=0;
                            ?>
                            @foreach($schedules as $schedule)
                            <?php $z++; ?>
                            <tr>
                              <td><span style="display: table;margin: auto;">{{$z}}</span></div></td>
                              <td><div align="center"><span>{{$schedule->code}}</span></div></td>
                              <td><div align="center"><span>{{\Carbon\Carbon::parse($schedule->time_schedule_awal)->format('H:i')}}</span></div></td>
                              <td><div align="center"><span>{{\Carbon\Carbon::parse($schedule->time_schedule_akhir)->format('H:i')}}</span></div></td>
                              <td><span style="display: table;margin: auto;"><a href="{{url('/')}}/backend/mst/jadwal/shift/edit/{{$schedule->id}}" class="btn btn-warning btn-sm"><i class="icon-edit"></i></a></span></td>
                            </tr>
                            @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection