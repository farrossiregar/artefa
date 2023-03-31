@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Upload / Input Jadwal Shifting </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading flex-center">
                <label>Tukar Jadwal</label>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 35px;">
                            <div class="row">
                                <div class="col-md-2">
                                    <label style="padding-top: 5px;">Pilih Departemen</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="dept_id" onchange="getTukarJadwal()" class="form-control" required>
                                        <option value="" disabled="true" selected="true">-- Pilih Departement --</option>
                                        @foreach($departements as $departement)
                                        <option value="{{$departement->code}}">{{$departement->unit}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="indexTableRubahJadwal">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection