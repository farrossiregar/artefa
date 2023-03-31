@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Report Absensi </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading flex-center">
                Report Absensi
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                	<div class="col-md-12" style="padding-bottom: 20px;">
                		<div class="row">
                            <div class="col-md-12">
                                @role('Super Admin')
                                <form action="#" class="form-horizontal" id="inline-validate">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Tipe Report</label>
                                        <div class="col-md-8">
                                            <select name="tipe" class="form-control col-md-6" onchange="tipeReportAbsen()">
                                                <option disabled="true" selected="true">--Pilih Tipe Report--</option>
                                                <option value="1">Detail Perbulan</option>
                                                <option value="2">Komparasi Antar Bulan</option>
                                                <option value="3">Data Absensi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Berdasarkan</label>
                                        <div class="col-md-4">
                                            <select name="berdasarkan" class="form-control col-md-6" onchange="deptReportAbsensi()">
                                                <option disabled="true" selected="true">--Pilih Unit--</option>
                                                <option value="1">Unit</option>
                                                <option value="2">Semua Unit</option>
                                                <option value="3">Per Nama Karyawan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="department">
                                        </div>
                                        <div class="col-md-4 hide" id="karyawan">
                                            <select name="idKar" class="form-control col-md-6">
                                                <option value="0" selected="true">-- Pilih Berdasarkan Nama Karyawan --</option>
                                                @foreach($employees as $employee)
                                                <option value="{{$employee->id}}">{{$employee->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group hide" id="periode">
                                        <label class="control-label col-md-2">Periode</label>
                                        <div class="col-md-4">
                                            <select name="periode" class="form-control col-md-6" onchange="periodeReportAbsensi()">
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
                                                <option value="{{$i}}" @if($i == $now) selected="true" @endif >{{$i}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 hide"  id="daterange">
                                            <input type="text" class="form-control datetimepicker" placeholder="Pilih Tanggal" name="daterange">
                                        </div>
                                    </div>
                                    <div class="form-group hide" id="tahun">
                                        <label class="control-label col-md-2">Tahun</label>
                                        <div class="col-md-4">
                                            @php
                                                $now = \Carbon\Carbon::now()->format('Y');
                                                $earliest_year = 2015;
                                            @endphp
                                            <select name="tahun" class="form-control">
                                                @foreach( range( $now, $earliest_year ) as $i )
                                                <option value="{{$i}}" @if($i == $now) selected="true" @endif>{{$i}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2"></label>
                                        <div class="col-md-4">
                                            <button type="button" onclick="getDataReportAbsensi()" class="btn btn-sm btn-success">Reload Data</button>
                                        </div>
                                    </div>
                                </form>
                                @endrole
                                @hasanyrole('Employee|Manager|Supervisor|Staff|Management')
                                <form action="#" class="form-horizontal" id="inline-validate">
                                    <div class="form-group">
                                        <!-- HIDE -->
                                        <select name="idKar" class="form-control col-md-6 hide">
                                            <option value="{{$user->id}}" selected="true">{{$user->nama}}</option>
                                        </select>
                                        <select name="periode" class="form-control col-md-6 hide">
                                            <option value="1" selected="true">Bulan</option>
                                        </select>
                                        <select name="berdasarkan" class="form-control col-md-6 hide">
                                            <option value="3" selected="true">Per Nama Karyawan</option>
                                        </select>
                                        <select name="tipe" class="form-control col-md-6 hide">
                                            <option value="3" selected="true">Data Absensi</option>
                                        </select>
                                        <!-- END HIDE -->
                                        <label class="control-label col-md-2">Periode</label>
                                        <div class="col-md-2">
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
                                        <div class="col-md-2">
                                            @php
                                                $now = \Carbon\Carbon::now()->format('Y');
                                                $earliest_year = 2015;
                                            @endphp
                                            <select name="year" class="form-control">
                                                @foreach( range( $now, $earliest_year ) as $i )
                                                <option value="{{$i}}" @if($i == $now) selected="true" @endif >{{$i}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2"></label>
                                        <div class="col-md-4">
                                            <button type="button" onclick="getDataReportAbsensi()" class="btn btn-sm btn-success">Reload Data</button>
                                        </div>
                                    </div>
                                </form>
                                @endrole
                            </div>
                        </div>
                	</div>
                    <div class="col-md-12 table-responsive" id="reportAbsensi">
                    	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection