@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Pengajuan Lembur</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Lembur
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Edit Pengajuan Lembur
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<!--form action="{{url('/backend/store/lembur/edit_lembur')}}" method="post"-->
															{{csrf_field()}}
														<div class="col-lg-12">
															<div class="row" hidden>
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Id</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input class="form-control" name="id" id="id" value="{{$id}}"   readonly/>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Nama</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="{{$nama_karyawan}}"  readonly/>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>NIK</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input name="nik" id="nik" class="form-control" value="{{$nik}}" readonly>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Jabatan</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input name="jabatan" id="jabatan" class="form-control" value="{{$jabatan}}" readonly>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Div / Dept / Bagian</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input type="text" id="kd_divisi" name="kd_divisi" value="{{$kd_divisi}}" class="form-control" readonly>
																				
																		</div>
																	</div>
																</div>
															</div>
															<br><br>
															<?php
																$i= 0;
															?>
															@foreach($data_lembur as $data)
															<?php
																$i = $i+1;
															?>
															<div class="row">
																<div class="col-lg-12">
																	
																	<div class="col-lg-4">
																		<label>Tanggal & Jam Lembur awal <?php echo $i; ?></label>
																	</div>
																	<div class="col-lg-8">
																		<!--div class="form-group">
																			<input type="text" class="form-control fld{{$data->kd}}" id="tgl_lembur_awal" name="tgl_lembur_awal" value="{{$data->tgl_lembur_awal}}" readonly>
																		</div-->
																		<?php
																			$tgl_lembur_awal1 = explode('-', substr($data->tgl_lembur_awal, 0, 10));
																			$tgl_lembur_awal2 = $tgl_lembur_awal1[1].'/'.$tgl_lembur_awal1[2].'/'.$tgl_lembur_awal1[0];
																			$jam_lembur_awal = substr($data->tgl_lembur_awal, 11, 8);
																		?>
																		<div class="col-lg-6">
																			<div class="input-group date" data-provide="datepicker">
																				<input type="text" id="tgl_lembur_awal{{$data->kd}}" name="tgl_lembur_awal{{$data->kd}}" value="<?php echo $tgl_lembur_awal2; ?>" class="form-control datecalendar fld{{$data->kd}}" onchange="hari();" readonly>
																				<div class="input-group-addon">
																					<span class="glyphicon glyphicon-th"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-6">
																			<div class="input-group">
																				<input  id="jam_lembur_awal{{$data->kd}}" name="jam_lembur_awal{{$data->kd}}" class="form-control fld{{$data->kd}}" value="<?php echo $jam_lembur_awal; ?>" type="time" readonly />
																				<span class="input-group-addon add-on"><i class="icon-time"></i></span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="row">
																	<div class="col-lg-4">
																		<label>Tanggal & Jam Lembur Akhir <?php echo $i; ?></label>
																	</div>
																	<div class="col-lg-8">
																		<?php
																			$tgl_lembur_akhir1 = explode('-', substr($data->tgl_lembur_akhir, 0, 10));
																			$tgl_lembur_akhir2 = $tgl_lembur_akhir1[1].'/'.$tgl_lembur_akhir1[2].'/'.$tgl_lembur_akhir1[0];
																			$jam_lembur_akhir = substr($data->tgl_lembur_akhir, 11, 8);
																		?>
																		<div class="col-lg-6">
																			<div class="input-group date" data-provide="datepicker">
																				<input type="text" id="tgl_lembur_akhir{{$data->kd}}" name="tgl_lembur_akhir{{$data->kd}}" value="<?php echo $tgl_lembur_akhir2; ?>" class="form-control datecalendar fld{{$data->kd}}" onchange="hari();" readonly>
																				<div class="input-group-addon">
																					<span class="glyphicon glyphicon-th"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-6">
																			<div class="input-group">
																				<input  id="jam_lembur_akhir{{$data->kd}}" name="jam_lembur_akhir{{$data->kd}}" class="form-control fld{{$data->kd}}" value="<?php echo $jam_lembur_akhir; ?>" type="time" readonly/>
																				<span class="input-group-addon add-on"><i class="icon-time"></i></span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Keterangan <?php echo $i; ?></label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<textarea name="keterangan_lembur{{$data->kd}}" class="form-control fld{{$data->kd}}" id="keterangan_lembur{{$data->kd}}" value="{{$data->keterangan_lembur}}" rows="3"  readonly>{{$data->keterangan_lembur}}</textarea>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-md-12" id="div-btn{{$data->kd}}">
																<button class="btn btn-info btn{{$data->kd}}" onclick="editdatalembur('{{$data->kd}}')" ><i class="icon-ok"></i>Edit</button>
															</div>
															<br><br>
															@endforeach
															
															<br>
															<br>
														</div>
														<div class="col-md-12">
															<div class="col-md-12" >
																<a href="{{url('/')}}/backend/lembur/data_lembur"><button class="btn btn-danger"><i class="icon-ok"></i>Keluar</button></a>
															</div>
														</div>
														
														<!--/form-->
														
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
@endsection