@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Master Hari Libur </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="box dark">
            <header>
                <h5>List Master Hari Libur</h5>
                <div class="toolbar">
                    <ul class="nav">
                        <li><button class="btn btn-link btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm-active-harilibur"><i class="icon-plus-sign"> Tambah Hari Libur</i></li></button>
                    </ul>
                </div>
            </header>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th style="vertical-align: middle;"><div align="center">Tanggal</div></th>
                                    <th style="vertical-align: middle;"><div align="center">Description</div></th>
                                    <th style="vertical-align: middle;"><div align="center" >Keterangan</div></th>
                                    <th><div align="center" style="width: 50px">Action</div></th>
                                </tr>
                            </thead>
                            <?php $i=0; ?>
                            <tbody>
                            @foreach($tanggalMerah as $val)
                            <?php $i++ ?>
                                <tr>
                                    <td><span style="display: table;margin: auto;">{{$i}}</span></td>
                                    <td><div align="center"><span>{{\Carbon\Carbon::parse($val->date)->format('d-m-Y')}}</span></div></td>
                                    <td><div align="center"><span>{{$val->description}}</span></div></td>
                                    <?php ($val->keterangan == 'Y')?$keterangan="Potong Cuti":$keterangan="Tidak Potong Cuti";?>
                                    <td><span style="display: table;margin: auto;">{{$keterangan}}</span></td>
                                    <td><span style="display: table;margin: auto;"><button class="btn btn-warning btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm-active-{{$val->id}}"><i class="icon-edit"></i></button></span></td>
                                </tr>
                                <!-- MODAL -->
                                <div class="modal fade bd-example-modal-sm-active-{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">Ubah Tanggal Hari Libur</h3>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{url('/')}}/backend/harilibur/edit/{{$val->id}}" method="POST">
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label for="message-text" class="col-form-label">Tanggal Hari Libur <span style="color: red;font-size: 19px"><b>*</b></span></label>
                                            <div class="input-group input-append date">
                                                <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" name="date" class="form-control datepicker"  required="true" autocomplete="off" placeholder="Pilih Tanggal" value="{{\Carbon\Carbon::parse($val->date)->format('d-m-Y')}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="message-text" class="col-form-label">Description:</label>
                                            <textarea class="form-control" id="message-text" name="description">{{$val->description}}</textarea>
                                          </div>
                                          <div class="form-group">
                                            <label for="text1" class="control-label col-md-4">Keterangan <span style="color: red;font-size: 19px"><b>*</b></span></label>
                                            <select class="form-control" name="keterangan">
                                              <option value="Y" @if($val->keterangan == 'Y') selected="true" @endif>Potong Cuti</option>
                                              <option value="N" @if($val->keterangan == 'N') selected="true" @endif>Tidak Potong Cuti</option>
                                            </select>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <a href="#" class="btn btn-danger btn-flat" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-flat btn-primary" >Simpan</button>
                                      </div>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Modal -->
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
<!-- MODAL -->
<div class="modal fade bd-example-modal-sm-active-harilibur" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Ubah Tanggal Hari Libur</h3>
      </div>
      <div class="modal-body">
        <form action="{{url('/')}}/backend/harilibur/add" method="POST">
          {{csrf_field()}}
          <div class="form-group">
            <label for="message-text" class="col-form-label">Tanggal Hari Libur <span style="color: red;font-size: 19px"><b>*</b></span></label>
            <div class="input-group input-append date">
                <span class="input-group-addon add-on"><i class="icon-calendar"></i></span><input type="text" name="date" class="form-control datepicker"  required="true" autocomplete="off" placeholder="Pilih Tanggal" >
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description:</label>
            <textarea class="form-control" id="message-text" name="description"></textarea>
          </div>
          <div class="form-group">
            <label for="text1" class="control-label col-md-4">Keterangan <span style="color: red;font-size: 19px"><b>*</b></span></label>
            <select class="form-control" name="keterangan">
              <option value="Y">Potong Cuti</option>
              <option value="N">Tidak Potong Cuti</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-danger btn-flat" data-dismiss="modal">Close</a>
        <button type="submit" class="btn btn-flat btn-primary" >Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection