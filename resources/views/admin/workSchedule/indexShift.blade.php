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
            <div class="panel-heading">
                Upload / Input Form Bulanan
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                	<div class="col-md-12" style="padding-bottom: 60px;">
                		<div class="col-md-4">
                            <div class="col-md-6" style="padding: 0; margin-top: 6px">
                                Upload file .xls / .xlsx
                            </div>  
                            <div class="col-md-6">
                                <button class="btn btn-flat btn-primary btn-md" data-toggle="modal" data-target="#exampleModal">Select File..</button>
                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Open modal for @getbootstrap</button> -->
                            </div>      
                        </div>
                		<div class="col-md-8">
                            <div class="col-md-5">
                                <select name="dept_id" class="form-control" required>
                                    <!-- <option value="" disabled="true" selected="true">-- Pilih Departement --</option> -->
                                    @foreach($departements as $departement)
                                    <option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="month" class="form-control" required>
                                    <!-- <option value="" disabled="true" selected="true">-- Pilih Bulan --</option> -->
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <button class="btn btn-primary" onclick="getDays()">Reload Data</button>
                            </div>
                        </div>
                	</div>
                    <div class="col-md-12 table-responsive" id="shiftTable">
                    	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Upload File .xls / .xlsx</h3>
      </div>
      <div class="modal-body">
        <form method="post" action="{{url('/')}}/backend/uploadFileShift" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Unit:</label>
              <div class="col-md-12" style="padding: 0">
                  <div class="row">
                      <div class="col-md-6">
                          <select name="dept_id" class="form-control"> 
                              @foreach($departements as $departement)
                              <option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
            </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Bulan:</label>
            <div class="col-md-12" style="padding: 0">
                <div class="row">
                    <div class="col-md-6">
                        <select name="month" class="form-control">
                            <option value="" disabled="true" selected="true">-- Pilih Bulan --</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-6">
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
                </div>
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">File:</label>
            <input type="file" name="shiftSchedule" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-flat">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>
@endsection