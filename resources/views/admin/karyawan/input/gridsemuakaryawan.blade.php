<div class="panel panel-default">
    <div class="panel-heading flex-center">
        <b>Tabel Semua Karyawan</b>
    </div>
    <div class="panel-body">
        <!-- <div class="pull-right" style="width: 30%; padding-bottom: 10px">
          <div class="sidebar-form" style="margin-right: auto;">
            <div class="input-group">
              <input type="text" name="content" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                    <button onclick="search('karyawan')" name="search" id="search-btn" class="btn btn-flat"><i class="icon-search"></i>
                    </button>
                  </span>
            </div>
          </div>
        </div> -->

        <div class="table-responsive" style="width: 1076px; overflow:auto;">
            <div style="max-height: 350px; overflow-y: scroll;">
              <table class="table table-bordered">
                  <thead>
                      <tr bgcolor="#6cddbf">
                          <th style="vertical-align: middle;"><div align="center">No</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 80px">Action</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 70px">NIK</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 150px">Nama</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 150px">Email</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 100px">Level</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 120px">Jabatan</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 100px">Shift/NonShift</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 100px">Tgl Join</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 100px">Status</div></th>
                          <th style="vertical-align: middle;"><div align="center" style="width: 100px">Tgl Resign</div></th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($departements as $departement)
                      <tr>
                        <?php
                        ($departement->department == $departement->unit)?$unitdept = $departement->unit:$unitdept = $departement->department.' - '.$unitdept = $departement->unit;
                        ?>
                            <td colspan="11" bgcolor="#c5ed4e"><b>{{$unitdept}}</b></td>
                      </tr>
                      <?php
                        $employees = \App\Models\Employee::where('dept_id',$departement->id)->get();
                        $z=0;
                      ?>
                        @foreach($employees as $employee)
                          <?php $z++; ?>
                          <tr>
                              <td><span style="display: table;margin: auto;">{{$z}}</span></div></td>
                              <td>
                                  <div class="btn-group" style="display: table;margin: auto;">
                                    @if($employee->status == 1)
                                    <a class="btn btn-warning btn-sm" href="{{ url('/') }}/backend/karyawan/edit/{{$employee->id}}" data-toggle="tooltip" data-placement="right" title="View"><i class="icon-eye-open"></i></a>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target=".bd-example-modal-sm-active-{{$employee->id}}"><i class="icon-minus-sign"></i></button>
                                    @else
                                    <a class="btn btn-success btn-sm" href="{{ url('/') }}/backend/karyawan/edit/{{$employee->id}}" data-toggle="tooltip" data-placement="right" title="Aktifkan"><i class="icon-ok-sign"></i></a>
                                    @endif
                                  </div>
                              </td>
                              <td><span>{{$employee->nik}}</span></td>
                              <td><span>{{$employee->nama}}</span></td>
                              <td><span>{{$employee->email}}</span></td>
                              <td><span>{{$employee->level}}</span></td>
                              <td><span>{{$employee->jabatan}}</span></td>
                              @if($employee->shifting == 'Y')
                                  <td><span>Shift</span></td>
                              @else
                                  <td><span>Non Shift</span></td>
                              @endif
                              <td><span>{{\Carbon\Carbon::parse($employee->tgl_join)->format('d/M/Y')}}</span></td>
                              <?php 
                              if($employee->status == 1){
                                $status = 'Aktif';
                              }else{
                                $status = 'Nonaktif';
                              }
                              ?>
                              <td><span style="display: table;margin: auto;">{{$status}}</span></td>
                              @if($employee->tgl_resign != '1970-01-01')
                              <td><span style="display: table;margin: auto;">{{\Carbon\Carbon::parse($employee->tgl_resign)->format('d/M/Y')}}</span></td>
                              @else
                              <td><span style="display: table;margin: auto;">-</span></td>
                              @endif
                          </tr>
                          <!-- MODAL -->
                            <div class="modal fade bd-example-modal-sm-active-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Tanggal Resign</h3>
                                  </div>
                                  <form action="{{url('/')}}/backend/karyawan/nonaktif/{{$employee->id}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-md-4">Tanggal Resign <span style="color: red;font-size: 19px"><b>*</b></span></label>
                                            <div class="col-lg-8">
                                                <div class="input-group date" data-provide="datepicker">
                                                  <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                  </div>
                                                  <input type="text" name="tgl_resign" id="tgl_resign-{{$employee->id}}" autocomplete="off" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" onclick="nonaktif({{$employee->id}})" class="btn btn-flat btn-sm btn-primary">Submit</button>
                                      <a href="#" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Close</a>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        @endforeach
                      @endforeach
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd-MM-yyyy',
            orientation: "bottom"
        });
    });
</script>
