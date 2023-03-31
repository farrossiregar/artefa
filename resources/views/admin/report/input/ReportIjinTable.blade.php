  <?php
	$action = $action;
	if($action == '2'){
  ?>
		<div class="table-responsive">
			<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
				<div class="row">
					<div class="col-sm-4">
					</div>
					<div class="col-sm-4">
						<h3>REPORT CUTI KARYAWAN</h3>
						<h5>Periode {{$namabulanawal}} {{$gettahunawal}} - {{$namabulanakhir}} {{$gettahunakhir}}</h5>
					</div>
					<div class="col-sm-4">
					</div>
				</div>
				<div class="col-md-12" id="ReportCutiTable">
					 <div class="col-md-12">
						<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
							<thead>
								<tr role="row">
									<th  >No</th>
									<th  >NIK</th>
									<th  >Nama</th>
									<th  >Dept / Unit</th>
									<th  >Jumlah Hari</th>
									<th  >Tgl Cuti Awal</th>
									<th  >Tgl Cuti Akhir</th>
									<th  >Sisa Cuti Tahunan</th>
									<th  >Sisa Cuti Besar</th>
									<th  >Keterangan</th>
								</tr>
							</thead>
							
							<tbody>
								<?php $no = 0 ?>;
								@foreach($data_cuti as $data)
								<?php $no = $no+1; ?>
								<tr class="gradeA odd">
									<td class="sorting_1"><?php echo $no ?></td>
									<td class=" ">{{$data->nik}}</td>
									<td class=" ">{{$data->nama_karyawan}}</td>
									<td class="center ">{{$data->department}} / {{$data->unit}}</td>
									<td class="center ">{{$data->jumlah_hari}}</td>
									<td class="center ">{{$data->tgl_cuti_awal}}</td>
									<td class="center ">{{$data->tgl_cuti_akhir}}</td>
									<td class="center ">{{$data->sisa_cuti_tahunan}}</td>
									<td class="center ">{{$data->sisa_cuti_besar}}</td>
									<td class="center ">{{$data->penjelasan_cuti}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					  </div>
				</div>
				
				<!-- <form> -->
				
				<div class="col-md-12" >
					<div class="row">
					<form action="{{url('/backend/report/report_cuti/export')}}" method="post">
						{{csrf_field()}}
						<input type="text" id="get_nama" name="get_nama" class="form-control"  value="{{$nama_karyawan}}" style="display:none;">
					  <input type="text" id="get_kd_divisi" name="get_kd_divisi" class="form-control"  value="{{$kd_divisi}}" style="display:none;">
					  <input type="text" id="tgl1" name="tgl1" class="form-control" value="{{$startdate}}" style="display:none;">
					  <input type="text" id="tgl2" name="tgl2" class="form-control" value="{{$enddate}}" style="display:none;">
					  <button class="btn btn-success"><i class="icon-ok"></i> Export</button>
					</form>
					</div>
					<br>
				</div>
				<!-- </form> -->
			</div>
		</div>
  <?php
	}else{
	}
  ?>