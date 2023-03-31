@extends('admin.partial.app')
@section('content')
<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Report</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Report Cuti
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Data Cuti Karyawan
								</div>
								<div class="col-md-12">
								<br>
									<div class="row">
										<!--form action="{{url('/backend/report/report_cuti/get_table')}}" method="POST"-->
											{{csrf_field()}}
										<div class="col-md-3">
											<div class="form-group">
												<label>Nama Karyawan</label>
												<div class="form-group input-group" onclick="filterkaryawan();">
													<input class="form-control" name="nama_karyawan" id="nama_karyawan" required readonly />
													<span class="input-group-addon" data-toggle="modal" data-target="#formModal"><i class="icon-search"></i></span>
													
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Pilih Departement :</label>
												<select id="kd_divisi" name="kd_divisi" class="form-control">
													<option value="" selected> Semua Departemen</option>
													@foreach($departements as $departement)
													<option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div id="datePickerBlock" class="body collapse in">
											<div class="col-md-6">
												<div class="col-lg-6">
													<div class="form-group">
														<label>Start Date :</label>
														<div class="input-group date" data-provide="datepicker">
															<input type="text" id="start-date" name="start-date" class="form-control">
															<div class="input-group-addon">
																<span class="glyphicon glyphicon-th"></span>
															</div>
														</div>
														
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label>End Date :</label>
														<div class="input-group date" data-provide="datepicker">
															<input type="text" id="end-date" name="end-date" class="form-control">
															<div class="input-group-addon">
																<span class="glyphicon glyphicon-th"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-3">
													<div class="form-group">
														<br>
														<button class="btn btn-success" onclick="getdatacuti();"><i class="icon-ok"></i> Submit</button>
														<!--button class="btn btn-success"><i class="icon-ok"></i> Submit</button-->
													</div>
												</div>
											</div>
										</div>
										<!--/form-->
									</div>
								</div>
								<div class="col-md-12" id="datacuti">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="H2">Modal Form</h4>
								</div>
								<div class="modal-body">
									<div style="height:500px; overflow:scroll;">
										<div class="row">
											<div class="col-lg-12">
												<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data()" autofocus>
											</div>
										</div>
										<div class="table-responsive">
											<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
												<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
													
													<thead>
														<tr>
															<th colspan = "4">
																
															</th>
														</tr>
														<tr role="row">
															<th tabindex="0" aria-controls="dataTables-example" rowspan="2" colspan="1" >Nama Karyawan</th>
															<th tabindex="0" aria-controls="dataTables-example" rowspan="2" colspan="1" >Id</th>
														</tr>
													</thead>
													<tbody id="isi_data">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('.datepicker').datepicker({
		format: 'mm/dd/yyyy',
		startDate: '-3d'
	});
</script>
@endsection