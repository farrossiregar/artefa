@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Form Ijin</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ijin
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Form Ijin
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<!--form action="{{url('/backend/store/ijin/pengajuan_ijin')}}"  method="post"-->
														{{csrf_field()}}
														<div class="col-lg-12" id="form_ijin">
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
																			<input name="nik" id="nik" value="{{$parameter['nik']}}" class="form-control" readonly required>
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
																			<input name="jabatan" id="jabatan" value="{{$parameter['jabatan']}}" class="form-control" readonly required>
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
																				<option value="" selected disabled >Departemen</option>
																				@foreach($departements as $departement)
																				<option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
																				@endforeach
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="row">
																<div class="col-lg-4">
																	<label>Tanggal Ijin<span style="color: red;font-size: 19px"><b>*</b></span></label>
																</div>
																<div class="col-lg-8">
																	<div class="col-lg-12">
																		<div class="input-group date" data-provide="datepicker">
																			<input type="text" id="tgl_ijin_awal" name="tgl_ijin_awal" class="form-control datecalendar" onchange="hari();" required>
																			<div class="input-group-addon">
																				<span class="glyphicon glyphicon-th"></span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<div class="row">
																<div class="col-lg-4">
																	<label>Jam Ijin Awal & Akhir<span style="color: red;font-size: 19px"><b>*</b></span></label>
																</div>
																<div class="col-lg-8">
																	<div class="col-lg-6">
																		<div class="input-group">
																			<input  id="jam_ijin_awal" name="jam_ijin_awal" class="form-control" type="time" required/>
																			<span class="input-group-addon add-on"><i class="icon-time"></i></span>
																		</div>
																	</div>
																	<div class="col-lg-6">
																		<div class="input-group bootstrap-timepicker">
																			<input id="jam_ijin_akhir" name="jam_ijin_akhir" class="form-control" type="time" required/>
																			<span class="input-group-addon add-on"><i class="icon-time"></i></span>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Keterangan<span style="color: red;font-size: 19px"><b>*</b></span></label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<textarea name="keterangan_ijin" id="keterangan_ijin" class="form-control" rows="3" required></textarea>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Tindak Lanjut :</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="tindak_lanjut" id="tindak_lanjut" value="POTONG CUTI" >Potong Cuti
																				</label>
																			</div>
																		</div>	
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="tindak_lanjut" id="tindak_lanjut" value="POTONG INTENSIF" >Potong Intensif
																				</label>
																			</div>
																		</div>
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="tindak_lanjut" id="tindak_lanjut" value="EXTRA OFF" >Extra Off
																				</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<br><br><br>
															<div class="col-md-12">
																<div class="form-group">
																	<button class="btn btn-success" onclick="saveIjin();"><i class="icon-ok"></i>Ajukan</button>
																	<!--button type="submit" class="btn btn-success"><i class="icon-ok"></i>Ajukan</button-->
																	
																</div>
															</div>
														</div>
														<!--/form-->
														
														<div class="col-lg-12">
															@include('admin.cuti.modalKaryawan')
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
            </div>
        </div>
    </div>
	
	<script>
		$('.datepicker').datepicker({
			format: 'mm/dd/yyyy',
			startDate: '-3d'
		});

		datepickerDefault = new MtrDatepicker({
			target: "demo",
		});

		
		
	</script>
@endsection