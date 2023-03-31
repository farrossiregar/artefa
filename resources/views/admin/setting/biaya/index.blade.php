@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
    <div class="col-lg-12">
        <h2> Master Biaya </h2>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading flex-center">
                <b>List Master Biaya</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><div align="center">No</div></th>
                                <th style="vertical-align: middle;"><div align="center">Type</div></th>
                                <th style="vertical-align: middle;"><div align="center">Biaya</div></th>
                                <th style="vertical-align: middle;"><div align="center" >Keterangan</div></th>
                                <th><div align="center" style="width: 50px">Action</div></th>
                            </tr>
                        </thead>
                        <?php $i=0; ?>
                        <tbody>
                        @foreach($mstbiaya as $val)
                        <?php $i++ ?>
                            <tr>
                                <td><span style="display: table;margin: auto;">{{$i}}</span></td>
                                <td><div align="center"><span>{{$val->type}}</span></div></td>
                                <td><div align="center"><span>Rp. {{number_format($val->amount,0)}}</span></div></td>
                                <td><span>{{$val->keterangan}}</span></td>
                                <td><span style="display: table;margin: auto;"><button class="btn btn-warning btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm-active-{{$val->id}}"><i class="icon-edit"></i></button></span></td>
                            </tr>
                            <!-- MODAL -->
                              <div class="modal fade bd-example-modal-sm-active-{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel">Ubah Biaya</h3>
                                    </div>
                                    <form action="{{url('/')}}/backend/biaya/edit/{{$val->id}}" method="POST">
                                      {{csrf_field()}}
                                      <div class="modal-body">
                                          <div class="form-group">
                                              <label for="text1" class="control-label col-md-4">Biaya <span style="color: red;font-size: 19px"><b>*</b></span></label>
                                              <div class="col-lg-8">
                                                  <div class="input-group input-append date">
                                                      <span class="input-group-addon add-on"><i class="icon-money"></i></span><input type="text" name="amount" class="form-control"  required="true" autocomplete="off" placeholder="Masukan Nominal" maxlength="50" onkeydown="return numbersonly(this,event)">
                                                  </div>
                                              </div>
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

@endsection