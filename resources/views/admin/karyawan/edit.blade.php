@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> VIew Karyawan </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="box dark">
            <header>
                <h5>Master Karyawan</h5>
                <div class="toolbar btneditKar">
                    <ul class="nav">
                        <li><button class="btn btn-warning btn-md" onclick="editKaryawan()">Edit Karyawan</button></li>
                        <li><a href="{{url('/')}}/backend/karyawan" ><i class="icon-step-backward"></i> Back</a></li>
                    </ul>
                </div>
            </header>
            <div id="div-1" class="accordion-body collapse in body editKar not-active" >
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/')}}/backend/karyawan/update/{{$karyawan->id}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">NIK<span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-3">
                        <input type="text" name="nik" value="{{$karyawan->nik}}" placeholder="Input NIK karyawan" class="form-control" required="true" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Nama <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-8">
                        <input type="text" name="nama" value="{{$karyawan->nama}}" placeholder="Input Nama karyawan" class="form-control" required="true" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Email</label>
                    <div class="col-lg-8">
                        <input type="email" name="email" value="{{$karyawan->email}}" placeholder="Input Email karyawan" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Tanggal Lahir <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-3">
                        <div class="input-group input-append date">
                            <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" class="form-control datepicker" value="{{\Carbon\Carbon::parse($karyawan->tgl_lahir)->format('d-m-Y')}}" autocomplete="off" placeholder="Pilih Tanggal" name="tgl_lahir">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Department & Unit</label>
                    <div class="col-lg-3">
                        <select data-placeholder="Choose a Country" name="dept_id" class="form-control chzn-select" tabindex="2">
                            @foreach($departements as $departement)
                            <option value="{{$departement->id}}" @if($departement->id == $karyawan->dept_id) selected="true" @endif> {{$departement->department}} - {{$departement->unit}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Level</label>
                    <div class="col-lg-3">
                        <select data-placeholder="Choose a Country" name="level" class="form-control chzn-select" tabindex="2">
                            @foreach($levels as $level)
                            <option value="{{$level->name}}" @if($level->name == $karyawan->level) selected="true" @endif>{{$level->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Jabatan</label>
                    <div class="col-lg-3">
                        <select data-placeholder="Choose a Country" name="jabatan" class="form-control chzn-select" tabindex="2">
                            @foreach($jabatans as $jabatan) 
                            <option value="{{$jabatan->name}}" @if($jabatan->name == $karyawan->jabatan) selected="true" @endif> {{$jabatan->name}}</option>
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
                        <!-- <select data-placeholder="Choose a Country" name="remark" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- Pilih Jabatan --</option>
                            @foreach($jabatans as $jabatan) 
                            <option value="{{$jabatan->name}}" @if($jabatan->name == $karyawan->remark) selected="true" @endif> {{$jabatan->name}}</option>
                            @endforeach
                        </select> -->
                        <input type="text" class="form-control" name="remark" value="{{$karyawan->remark}}">
                    </div>
                    <i>* Jika jabatan dirubah untuk kebutuhan UM</i>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Tipe Karyawan</label>
                    <div class="col-lg-3">
                        <select name="shifting" class="form-control">
                            <option value="Y" @if($karyawan->shifting == 'Y') selected="true" @endif>Shift</option>
                            <option value="N" @if($karyawan->shifting == 'N') selected="true" @endif>Non Shift</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="ut" class="form-control">
                            <option value="ut" @if($karyawan->ut == 'ut') selected="true" @endif>UT</option>
                            <option value="Lumpsum" @if($karyawan->ut == 'Lumpsum') selected="true" @endif>Lumpsum</option>
                            <option value="N/A" @if($karyawan->ut == 'N/A') selected="true" @endif>N/A</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="um" class="form-control">
                            <option value="um" @if($karyawan->um == 'um') selected="true" @endif>UM</option>
                            <option value="UM tanpa perlu finger" @if($karyawan->um == 'UM tanpa perlu finger') selected="true" @endif>UM tanpa perlu finger</option>
                            <option value="Kupon" @if($karyawan->um == 'Kupon') selected="true" @endif>Kupon</option>
                            <option value="N/A" @if($karyawan->um == 'N/A') selected="true" @endif>N/A</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Direct Supervisor</label>
                    <div class="col-lg-4">
                        <select data-placeholder="Choose a Country" name="direct_supervisor" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- Pilih Atasan --</option>
                            <option  value="**" @if($karyawan->direct_supervisor == '**') selected="true" @endif>**</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->nama}}" @if($employee->nama == $karyawan->direct_supervisor) selected="true" @endif> {{$employee->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Next Supervisor</label>
                    <div class="col-lg-4">
                        <select data-placeholder="Choose a Country" name="next_higher_supervisor" class="form-control chzn-select" tabindex="2">
                            <option disabled="true" selected="true">-- Pilih Atasan --</option>
                            <option  value="**" @if($karyawan->direct_supervisor == '**') selected="true" @endif>**</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->nama}}" @if($employee->nama == $karyawan->next_higher_supervisor) selected="true" @endif> {{$employee->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text1" class="control-label col-md-2">Tanggal Join <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-3">
                        <div class="input-group input-append date">
                            @if($karyawan->status == 1)
                            <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" class="form-control datepicker" autocomplete="off" value="{{\Carbon\Carbon::parse($karyawan->tgl_join)->format('d-m-Y')}}" placeholder="Pilih Tanggal" name="tgl_join">
                            @else
                            <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" class="form-control datepicker" autocomplete="off" required="true" placeholder="Pilih Tanggal" name="tgl_join">
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="flex-center">
                  <button type="submit" class="col-lg-4 btn btn-success btn-md btn-flat">Update</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
