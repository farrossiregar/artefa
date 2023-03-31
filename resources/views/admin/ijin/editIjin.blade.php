@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Pengajuan Ijin</h1>
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
											Edit Pengajuan Ijin
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<!--form action="{{url('/backend/store/ijin/edit_ijin')}}"  method="post"-->
															{{csrf_field()}}
															
														<div class="col-lg-12" id="form_ijin">
															<div class="row" hidden>
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Id</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input class="form-control" name="id" id="id" value="{{$id}}"  readonly/>
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
																			<input name="jabatan" id="jabatan" class="form-control" value="{{$jabatan}}" readonly >
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
																			<input name="kd_divisi" id="kd_divisi" class="form-control" value="{{$kd_divisi}}" readonly >
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="row">
																<div class="col-lg-12">
																	
																	<div class="col-lg-4">
																		<label>Tanggal & Jam ijin awal</label>
																	</div>
																	<div class="col-lg-8">
																		<?php
																			$tgl_ijin_awal1 = explode('-', substr($tgl_ijin_awal, 0, 10));
																			$tgl_ijin_awal2 = $tgl_ijin_awal1[1].'/'.$tgl_ijin_awal1[2].'/'.$tgl_ijin_awal1[0];
																			$jam_ijin_awal = substr($tgl_ijin_awal, 11, 8);
																		?>
																		<div class="col-lg-6">
																			<div class="input-group date" data-provide="datepicker">
																				<input type="text" id="tgl_ijin_awal" name="tgl_ijin_awal" value="<?php echo $tgl_ijin_awal2; ?>" class="form-control datecalendar" onchange="hari();">
																				<div class="input-group-addon">
																					<span class="glyphicon glyphicon-th"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-6">
																			<div class="input-group">
																				<input  id="jam_ijin_awal" name="jam_ijin_awal" class="form-control" value="<?php echo $jam_ijin_awal; ?>"type="time" />
																				<span class="input-group-addon add-on"><i class="icon-time"></i></span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<div class="col-lg-12">
																<div class="row">
																	<div class="col-lg-4">
																		<label>Tanggal & Jam ijin Akhir</label>
																	</div>
																	<div class="col-lg-8">
																		<?php
																			$tgl_ijin_akhir1 = explode('-', substr($tgl_ijin_akhir, 0, 10));
																			$tgl_ijin_akhir2 = $tgl_ijin_akhir1[1].'/'.$tgl_ijin_akhir1[2].'/'.$tgl_ijin_akhir1[0];
																			$jam_ijin_akhir = substr($tgl_ijin_akhir, 11, 8);
																		?>
																		<div class="col-lg-6">
																			<div class="input-group date" data-provide="datepicker">
																				<input type="text" id="tgl_ijin_akhir" name="tgl_ijin_akhir" value="<?php echo $tgl_ijin_akhir2; ?>" class="form-control datecalendar" onchange="hari();">
																				<div class="input-group-addon">
																					<span class="glyphicon glyphicon-th"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-6">
																			<div class="input-group">
																				<input  id="jam_ijin_akhir" name="jam_ijin_akhir" class="form-control" value="<?php echo $jam_ijin_akhir; ?>" type="time" />
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
																		<label>Keterangan</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<textarea name="keterangan_ijin" id="keterangan_ijin" class="form-control" rows="3" value="{{$keterangan_ijin}}" >{{$keterangan_ijin}}</textarea>
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
																					<input type="radio" name="tindak_lanjut" id="tindak_lanjut" value="POTONG CUTI" <?php if($tindak_lanjut == 'POTONG CUTI'){echo "checked";}?>>Potong Cuti
																				</label>
																			</div>
																		</div>	
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="tindak_lanjut" id="tindak_lanjut" value="POTONG INTENSIF" <?php if($tindak_lanjut == 'POTONG INTENSIF'){echo "checked";}?>>Potong Intensif
																				</label>
																			</div>
																		</div>
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="tindak_lanjut" id="tindak_lanjut" value="EXTRA OFF" <?php if($tindak_lanjut == 'EXTRA OFF'){echo "checked";}?>>Extra Off
																				</label>
																			</div>
																		</div>
																	</div>
																	<!--div class="col-lg-8">
																		<div class="form-group">
																			<input name="tindak_lanjut" id="tindak_lanjut" class="form-control" value="{{$tindak_lanjut}}" >
																		</div>
																	</div-->
																</div>
															</div>
															<br><br><br>
															<br>
															<div class="col-md-12">
																<button type="submit" onclick="editdataijin();" class="btn btn-success"><i class="icon-ok"></i>Ubah</button>
																<a href="{{url('/')}}/backend/ijin/data_ijin"><button class="btn btn-danger"><i class="icon-ok"></i>Keluar</button></a>
															</div>
														</div>
														<div class="col-md-12">
															<div class="col-md-12" >
																
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