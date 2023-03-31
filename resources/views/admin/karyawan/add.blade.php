@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Input Data Karyawan </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="box dark">
            <header class="flex-center">
                <h5>Input Data Karyawan</h5>
            </header>
            <div id="div-1" class="accordion-body collapse in body">
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/')}}/backend/karyawan/store">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">NIK <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-3">
                        <input type="text" name="nik" placeholder="Input NIK karyawan" class="form-control" required="true" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Nama <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-8">
                        <input type="text" name="nama" placeholder="Input Nama karyawan" class="form-control" required="true" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Email</label>
                    <div class="col-lg-8">
                        <input type="email" name="email" placeholder="Input Email karyawan" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Tanggal Lahir <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-3">
                        <div class="input-group input-append date">
                            <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" class="form-control datepicker" autocomplete="off" placeholder="Pilih Tanggal" name="tgl_lahir">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Department & Unit</label>
                    <div class="col-lg-3">
                        <select data-placeholder="Choose a Country" name="dept_id" class="form-control chzn-select" tabindex="2">
                            @foreach($departements as $departement)
                            <option value="{{$departement->id}}"> {{$departement->department}} - {{$departement->unit}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Level</label>
                    <div class="col-lg-3">
                        <select data-placeholder="Choose a Country" name="level" class="form-control chzn-select" tabindex="2">
                            @foreach($levels as $level)
                            <option value="{{$level->name}}">{{$level->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Jabatan</label>
                    <div class="col-lg-3">
                        <select data-placeholder="Choose a Country" name="jabatan" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- PILIH JABATAN --</option>
                            @foreach($jabatans as $jabatan)
                            <option value="{{$jabatan->name}}"> {{$jabatan->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 flex-center"><b>OR</b></div>
                    <div class="col-md-3">
                        <input type="text" name="newjabatan" placeholder="Jabatan Baru">
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Remark</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="remark">
                    </div>
                    <i>* Jika jabatan dirubah untuk kebutuhan UM</i>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Tipe Karyawan</label>
                    <div class="col-lg-3">
                        <select name="shifting" class="form-control">
                            <option value="Y">Shift</option>
                            <option value="N">Non Shift</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="ut" class="form-control">
                            <option value="ut">UT</option>
                            <option value="Lumpsum">Lumpsum</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="um" class="form-control">
                            <option value="um">UM</option>
                            <option value="UM tanpa perlu finger">UM tanpa perlu finger</option>
                            <option value="Kupon">Kupon</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Direct Supervisor</label>
                    <div class="col-lg-4">
                        <select data-placeholder="Choose a Country" name="direct_supervisor" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- Pilih Atasan --</option>
                            <option  value="**">**</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->nama}}"> {{$employee->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Next Supervisor</label>
                    <div class="col-lg-4">
                        <select data-placeholder="Choose a Country" name="next_higher_supervisor" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- Pilih Atasan --</option>
                            <option  value="**">**</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->nama}}"> {{$employee->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Tanggal Join <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-3">
                        <div class="input-group input-append date">
                            <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" class="form-control datepicker" autocomplete="off" placeholder="Pilih Tanggal" name="tgl_join">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="flex-center">
                  <button type="submit" class="col-lg-4 btn btn-success btn-md btn-flat">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
