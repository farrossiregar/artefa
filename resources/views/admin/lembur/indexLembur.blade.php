@extends('admin.partial.app')
@section('content')

<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Form Lembur</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Lembur
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
						@if (\Session::has('success'))
							<div class="alert alert-success">
								<ul>
									<li>{!! \Session::get('success') !!}</li>
								</ul>
							</div>
						@endif
						
						
							<div class="panel panel-default">
								<div class="panel-heading">
									Form Lembur
								</div>
								<div class="col-lg-12">
									<div class="row">
										<div class="panel panel-default">
											<div class="panel-body">
												<form action="{{url('/backend/store/lembur/pengajuan_lembur')}}" method="post">
												{{csrf_field()}}
												<div class="col-lg-12">
													<div class="row">
														<div class="col-lg-12">
															<div class="col-lg-4">
																<label>Nama<span style="color: red;font-size: 19px"><b>*</b></span></label>
															</div>
															<div class="col-lg-8">
																<?php echo $getuser ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<div class="col-lg-4">
																<label>NIK<span style="color: red;font-size: 19px"><b>*</b></span></label>
															</div>
															<div class="col-lg-8">
																<div class="form-group">
																	<input name="nik" id="nik" value="{{$parameter['nik']}}" class="form-control" required readonly>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<div class="col-lg-4">
																<label>Jabatan<span style="color: red;font-size: 19px"><b>*</b></span></label>
															</div>
															<div class="col-lg-8">
																<div class="form-group">
																	<input name="jabatan" id="jabatan" value="{{$parameter['level']}}" class="form-control" required readonly>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<div class="col-lg-4">
																<label>Div / Dept / Bagian<span style="color: red;font-size: 19px"><b>*</b></span></label>
															</div>
															<div class="col-lg-8">
																<div class="form-group">
																	<select id="kd_divisi" name="kd_divisi" class="form-control" required>
																		<option value=""selected disabled>PILIH DEPARTEMENT</option>
																		@foreach($departements as $departement)
																		<option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
																		@endforeach
																	</select>
																</div>
															</div>
														</div>
													</div>
													
													
													<br>
													<div class="row">
														<div class="col-md-12">
															<input id="idf" value="1" type="hidden" />
															<div class="col-md-12">
																<button type="button"  class="btn btn-primary" onclick="tambahHobi(); return false;">Tambah Tanggal Lembur</button>
															</div>
															<br>
															<div id="divHobi">
															</div>
														</div>
													</div>
													
													<br><br>
													<div class="col-md-12">
														<!--button class="btn btn-success" onclick="saveLembur();"><i class="icon-ok"></i>Ajukan</button-->
														<button class="btn btn-success"><i class="icon-ok"></i>Ajukan</button>
													</div>
												</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		@include('admin.cuti.modalKaryawan')
	</div>	
</div>
</div>
	
	<script type="text/javascript">
		$('.timeselector').timespinner({
  			format: 'HH:mm'
		});
	</script>
	<script>
		$('.datepicker').datepicker({
			format: 'mm/dd/yyyy',
			startDate: '-3d'
		});
	</script>
	
	
@endsection