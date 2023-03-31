@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Report Uang Transport & Uang Makan</h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading flex-center">
                Report UT & UM
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                	<div class="col-md-12" style="padding-bottom: 20px;">
                		<div class="row">
                            <div class="col-md-12">
                                <form action="#" class="form-horizontal" method="POST">
                                    <div class="form-group" id="periode">
                                        <label class="control-label col-md-2">Periode</label>
                                        <div class="col-md-4">
                                            <select name="periode" class="form-control col-md-6"  onchange="periodeReportAbsensi()">
                                                <option disabled="true" selected="true">--Pilih Periode--</option>
                                                <option value="1">Bulan</option>
                                                <option value="2">Akumulatif YTD</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 hide"  id="month">
                                            @php
                                                $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                                                              'October', 'November', 'December');
                                                $now = \Carbon\Carbon::now()->format('m');
                                            @endphp
                                            <select name="month" class="form-control">
                                                @foreach($months as $key => $value)
                                                    @php
                                                        if($key<=9){
                                                            $m = "0".$key;
                                                        }
                                                        else{
                                                            $m = $key;
                                                        }
                                                    @endphp
                                                    <option value="{{$m}}" @if($m==$now) selected="true" @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 hide"  id="year">
                                            @php
                                                $now = \Carbon\Carbon::now()->format('Y');
                                                $earliest_year = 2015;
                                            @endphp
                                            <select name="year" class="form-control">
                                                @foreach( range( $now, $earliest_year ) as $i )
                                                <option value="{{$i}}" @if($i == $now) selected="true" @endif>{{$i}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 hide"  id="daterange">
                                            <input type="text" class="form-control datetimepicker" placeholder="Pilih Tanggal" name="daterange">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Nama Karyawan</label>
                                        <div class="col-md-4">
                                            <select name="idKar" class="form-control col-md-6 chzn-select" tabindex="2">
                                                <option value="0" selected="true">-- Pilih Berdasarkan Nama Karyawan --</option>
                                                @foreach($employees as $employee)
                                                <option value="{{$employee->id}}">{{$employee->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2"></label>
                                        <div class="col-md-4">
                                            <button type="button" onclick="getDataReportUMUT()" class="btn btn-sm btn-success">Reload Data</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 table-responsive" id="reportUMUT">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection