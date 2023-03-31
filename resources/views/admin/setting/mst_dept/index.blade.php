@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Master Department </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="box dark">
          <header>
              <h5>List Master Department</h5>
              <div class="toolbar">
                  <ul class="nav">
                      <li><button class="btn btn-link btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm-active-dept"><i class="icon-plus-sign"> Tambah Department</i></li></button>
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
                                  <th style="vertical-align: middle;"><div align="center">Department</div></th>
                                  <th style="vertical-align: middle;"><div align="center">Unit</div></th>
                                  <th style="vertical-align: middle;"><div align="center" >Shift</div></th>
                                  <th style="vertical-align: middle;"><div align="center" >Status</div></th>
                                  <th><div align="center" style="width: 50px">Action</div></th>
                              </tr>
                          </thead>
                          <?php $i=0; ?>
                          <tbody>
                          @foreach($departments as $val)
                          <?php 
                            $i++;
                            if($val->status == 1){
                              $status = 'Aktif';
                            }else{
                              $status = 'Tidak Aktif';
                            }
                          ?>
                              <tr>
                                  <td><span style="display: table;margin: auto;">{{$i}}</span></td>
                                  <td><div align="center"><span>{{$val->department}}</span></div></td>
                                  <td><div align="center"><span>{{$val->unit}}</span></div></td>
                                  <td><div align="center"><span>{{$val->shift}}</span></div></td>
                                  <td><div align="center"><span>{{$status}}</span></div></td>
                                  <td><span style="display: table;margin: auto;"><button class="btn btn-warning btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm-active-{{$val->id}}"><i class="icon-edit"></i></button></span></td>
                              </tr>
                              <!-- MODAL -->
                                <div class="modal fade bd-example-modal-sm-active-{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">Ubah Department</h3>
                                      </div>
                                      <form action="{{url('/')}}/backend/mst/department/edit/{{$val->id}}" method="POST">
                                        {{csrf_field()}}
                                        <div class="modal-body">
                                            <div class="form-group">
                                              <label for="message-text" class="col-form-label">Department:</label>
                                              <input type="text" class="form-control" name="department" value="{{$val->department}}">
                                            </div>
                                            <div class="form-group">
                                              <label for="message-text" class="col-form-label">Unit:</label>
                                              <input type="text" class="form-control" name="unit" value="{{$val->unit}}">
                                            </div>
                                            <div class="form-group">
                                              <label for="text1" class="control-label">Shift <span style="color: red;font-size: 19px"><b>*</b></span></label>
                                              <select class="form-control" name="shift">
                                                <option value="Y" @if($val->shift == 'Y') selected="true" @endif>Y</option>
                                                <option value="N" @if($val->shift == 'N') selected="true" @endif>N</option>
                                              </select>
                                            </div>
                                            <div class="form-group">
                                              <label for="text1" class="control-label">Status <span style="color: red;font-size: 19px"><b>*</b></span></label>
                                              <select class="form-control" name="status">
                                                <option value="1" @if($val->status == '1') selected="true" @endif>Aktif</option>
                                                <option value="2" @if($val->status == '2') selected="true" @endif>Tidak Aktif</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" class="btn btn-flat btn-sm btn-primary" >Simpan</button>
                                          <a href="#" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Close</a>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
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
  <div class="modal fade bd-example-modal-sm-active-dept" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Ubah Department</h3>
        </div>
        <form action="{{url('/')}}/backend/mst/department/store" method="POST">
          {{csrf_field()}}
          <div class="modal-body">
              <div class="form-group">
                <label for="message-text" class="col-form-label">Department:</label>
                <input type="text" class="form-control" name="department" >
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Unit:</label>
                <input type="text" class="form-control" name="unit">
              </div>
              <div class="form-group">
                <label for="text1" class="control-label">Shift <span style="color: red;font-size: 19px"><b>*</b></span></label>
                <select class="form-control" name="shift">
                  <option value="Y">Y</option>
                  <option value="N">N</option>
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-flat btn-sm btn-primary" >Simpan</button>
            <a href="#" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection