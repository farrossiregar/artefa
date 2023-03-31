@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Approve Pengajuan Lembur</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Approve Lembur
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Approve Pengajuan Lembur
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<form action="{{url('/backend/store/lembur/approve_lembur')}}" method="post">
															{{csrf_field()}}
														<div class="col-lg-12">
															<div class="row" hidden>
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Id</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input class="form-control" name="id" id="id" value="{{$id}}" readonly  />
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
																			<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="{{$nama_karyawan}}" readonly />
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
																		<div class="form-group">
																			<input type="text" id="tgl_lembur_awal" name="tgl_lembur_awal" value="{{$data->tgl_lembur_awal}}" class="form-control" readonly>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="row">
																	<div class="col-lg-4">
																		<label>Tanggal & Jam Lembur Akhir</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input type="text" id="tgl_lembur_awal" name="tgl_lembur_akhir" value="{{$data->tgl_lembur_akhir}}" class="form-control" readonly>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Keterangan <?php echo $i; ?></label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<textarea name="keterangan_lembur" id="keterangan_lembur" value="{{$data->keterangan_lembur}}" class="form-control" rows="3" readonly >{{$data->keterangan_lembur}}</textarea>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Jenis Lembur <?php echo $i; ?></label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input type="text" id="jenis_lembur" name="jenis_lembur" value="{{$data->jenis_lembur}}" class="form-control" readonly>
																		</div>
																	</div>
																</div>
															</div>
															<br><br>
															@endforeach
															
															<br><br><br>
															<?php
																if($tombol == 'aktif'){
															?>
															<div class="row">
																<div class="col-lg-12">
																	<div class="col-lg-12">
																		<label>Action:</label>
																	</div>
																	<div class="col-lg-4">
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="action" id="action" value="Y" >Setujui
																				</label>
																			</div>
																		</div>	
																	</div>	
																	<div class="col-lg-4">
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="action" id="action" value="N" >Tolak
																				</label>
																			</div>
																		</div>	
																	</div>		
																</div>
															</div>
															<br>
															<div class="col-md-12">
																<button class="btn btn-success"><i class="icon-ok"></i>Approve</button>
															</div>
															<?php
																}else{
																	
																}
															?>
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
                    
                    </div>
                </div>
@endsection