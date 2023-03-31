@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Approve Pengajuan Ijin</h1>
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
											Approve Pengajuan Ijin
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<form action="{{url('/backend/store/ijin/approve_ijin')}}"  method="post">
															{{csrf_field()}}
															
														<div class="col-lg-12" id="form_ijin">
															<div class="row" hidden>
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<label>Id</label>
																	</div>
																	<div class="col-lg-8">
																		<div class="form-group">
																			<input class="form-control" name="id" id="id" value="{{$id}}" readonly />
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
																			<input name="kd_divisi" id="kd_divisi" class="form-control" value="{{$kd_divisi}}" readonly>
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
																		<div class="form-group">
																			<input name="tgl_ijin_awal" id="tgl_ijin_awal" class="form-control" value="{{$tgl_ijin_awal}}" readonly>
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
																		<div class="form-group">
																			<input name="tgl_ijin_akhir" id="tgl_ijin_akhir" class="form-control" value="{{$tgl_ijin_akhir}}" readonly>
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
																			<textarea name="keterangan_ijin" id="keterangan_ijin" class="form-control" rows="3" value="{{$keterangan_ijin}}" readonly>{{$keterangan_ijin}}</textarea>
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
																			<input name="tindak_lanjut" id="tindak_lanjut" class="form-control" value="{{$tindak_lanjut}}" readonly>
																		</div>
																	</div>
																</div>
															</div>
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
																<button type="submit" class="btn btn-success"><i class="icon-ok"></i>Setujui</button>
															</div>
															<?php
																}
															?>
															
															@if (\Session::has('success'))
																<div class="col-md-12">
																	<button type="submit" class="btn btn-success"><i class="icon-ok"></i>{!! \Session::get('success') !!}</button>
																</div>
															@endif
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