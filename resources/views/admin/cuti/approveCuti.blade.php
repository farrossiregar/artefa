@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Approve Pengajuan Cuti</h1>
                </div>
            </div>
            <div class="row">
                    
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Approve Pengajuan Cuti
                        </div>
						
						<form action="{{url('/backend/store/cuti/approve_cuti')}}" method="post">
							{{csrf_field()}}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Form Cuti
										</div>
										<div class="col-lg-8">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>A. IDENTITAS PEMOHON</h4>
														<div class="col-lg-6" hidden>
															<label>Id</label>
															<div class="form-group">
																<input class="form-control" name="id" id="id" value="{{$id}}" readonly />
															</div>
														</div>
														<div class="col-lg-6">
															<label>Nama Karyawan</label>
															<div class="form-group">
																<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="{{$nama_karyawan}}" readonly />
															</div>
															<div class="form-group">
																<label>Jabatan</label>
																<input class="form-control" name="jabatan" id="jabatan" value="{{$jabatan}}" readonly>
															</div>
															<div class="form-group">
																<label>Div/Dept/Bag</label>
																<input class="form-control" name="kd_divisi" id="kd_divisi" value="{{$kd_divisi}}" readonly>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group">
																<label>NIK</label>
																<input class="form-control" name="nik" id="nik" value="{{$nik}}" readonly >
															</div>
															<div class="form-group">
																<label>TMK</label>
																<input class="form-control" name="tmk" id="tmk" value="{{$tgl_masuk_karyawan}}" readonly>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>B. PERIODE PERMOHONAN CUTI/IJIN</h4>
														@foreach($data_cuti as $data)
														<?php
															if($data->jenis_cuti == 'C1'){
																$jenis_cuti = 'Cuti Tahunan';
															}else if($data->jenis_cuti == 'C2'){
																$jenis_cuti = 'Sakit Sebagai Cuti';
															}else if($data->jenis_cuti == 'C3'){
																$jenis_cuti = 'Ijin';
															}else if($data->jenis_cuti == 'C4'){
																$jenis_cuti = 'Cuti Besar';
															}else if($data->jenis_cuti == 'C17'){
																$jenis_cuti = 'Sakit';
															}else{
																$jenis_cuti = 'Cuti Khusus';
															}
														?>
														<div class="col-lg-4">
															<div class="form-group">
																<label>Start Date {{$jenis_cuti}}</label>
																<input class="form-control" name="tgl_cuti_awal" id="tgl_cuti_awal" value="{{$data->tgl_cuti_awal}}" readonly >
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
																<label>End Date {{$jenis_cuti}}</label>
																<input class="form-control" name="tgl_cuti_akhir" id="tgl_cuti_akhir" value="{{$data->tgl_cuti_akhir}}" readonly >
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
																<label>Jumlah Hari {{$jenis_cuti}}</label>
																<input id="jumlah_hari" name="jumlah_hari" class="form-control" value="{{$data->jumlah_hari}}" readonly>
															</div>
														</div>
														@endforeach
													</div>
												</div>
											</div>
											
											<!--div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>C. ALASAN CUTI/IJIN</h4>
														<div class="row">
															@foreach($data_cuti as $data)
															<?php
																if($data->jenis_cuti == 'C1'){
																	$jenis_cuti = 'Cuti Tahunan';
																}else if($data->jenis_cuti == 'C2'){
																	$jenis_cuti = 'Sakit Sebagai Cuti';
																}else if($data->jenis_cuti == 'C3'){
																	$jenis_cuti = 'Ijin';
																}else if($data->jenis_cuti == 'C4'){
																	$jenis_cuti = 'Cuti Besar';
																}else if($data->jenis_cuti == 'C17'){
																	$jenis_cuti = 'Sakit';
																}else{
																	$jenis_cuti = 'Cuti Khusus';
																}
															?>
															<div class="col-lg-6">
																<div class="form-group">
																	<input class="form-control" name="jenis_cuti" id="jenis_cuti" value="{{$jenis_cuti}}" readonly >
																</div>
															</div>
															@endforeach
														</div>
													</div>
												</div>
											</div-->
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>E. PENJELASAN CUTI/IJIN/KETIDAKHADIRAN</h4>
														<div class="form-group">
															<textarea name="penjelasan_cuti" id="penjelasan_cuti" class="form-control" rows="3" value="{{$penjelasan_cuti}}" readonly>{{$penjelasan_cuti}}</textarea>
														</div>
													</div>
												</div> 
												
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>G. Alamat yang bisa dihubungi selama cuti/ijin tidak masuk kerja :</h4>
														<h6><i>(untuk kepentingan keadaan darurat)</i></h6>
														<div class="form-group">
															<textarea name="alamat" id="alamat" class="form-control" rows="3" value="{{$alamat}}" readonly>{{$alamat}}</textarea>
														</div>
													</div>
												</div>
												
												<div class="panel panel-default">
													<div class="panel-body">
														<div class="form-group">
															<div class="row">
																<div class="col-md-6">
																	<h4>H. Usulan Petugas Pengganti	:</h4>
																</div>
															</div>
															<div class="row">	
																<div class="col-md-6">
																	<div class="form-group">
																		<input id="petugas_pemimpin" name="petugas_pemimpin" class="form-control" value="{{$petugas_pengganti}}" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-lg-4">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>D. PERHITUNGAN CUTI TAHUNAN</h4>
														<div class="col-lg-12">
															<div class="form-group">
																<label>Hak cuti hari sebelumnya</label>
																<input class="form-control" name="hak_cuti_tahunan" id="hak_cuti_tahunan" value="{{$sisa_cuti_tahunan}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Telah diambil</label>
																<input class="form-control" name="cuti_tahunan_sudah_diambil" id="cuti_tahunan_sudah_diambil" value="{{$sisa_cuti_tahunan_sudah_diambil}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Sisa sebelum diambil</label>
																<input class="form-control" name="cuti_tahunan_sebelum_diambil" id="cuti_tahunan_sebelum_diambil" value="{{$sisa_cuti_tahunan_diambil}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Akan diambil</label>
																<input class="form-control" name="cuti_tahunan_akan_diambil" id="cuti_tahunan_akan_diambil" value="{{$totaljumlahhari}}" disabled> hari
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>D. PERHITUNGAN CUTI BESAR</h4>
														<div class="col-lg-12">
															<div class="form-group">
																<label>Hak cuti hari sebelumnya</label>
																<input class="form-control" name="hak_cuti_besar" id="hak_cuti_besar" value="{{$sisa_cuti_besar}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Telah diambil</label>
																<input class="form-control" name="cuti_besar_sudah_diambil" id="cuti_besar_sudah_diambil" value="{{$sisa_cuti_besar_sudah_diambil}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Sisa sebelum diambil</label>
																<input class="form-control" name="cuti_besar_sebelum_diambil" id="cuti_besar_sebelum_diambil" value="{{$sisa_cuti_besar_diambil}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Akan diambil</label>
																<input class="form-control" name="cuti_besar_akan_diambil" id="cuti_besar_akan_diambil"  value="{{$totaljumlahharibesar}}" disabled> hari
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>Catatan<h4>
														<div class="col-lg-12">
															<ol>
																<li>Formulir harus dilengkapi dengan baik.</li>
																<li>Cuti & ijin akan dipotong setelah approval.</li>
																<li>Segala bentuk ijin/ketidakhadiran (kecuali sakit akan dipotong cuti tahunan).</li>
																<li>Ketidakhadiran tanpa alasan yang sah akan dipotong dari cuti tahunan.</li>
															</ol>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
                            </div>
							<br><br><br>
							<?php
								if($tombol == 'aktif'){
							?>
							<div class="row">
								<div class="col-lg-6">
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
								<button class="btn btn-success"><i class="icon-ok"></i>Simpan</button>
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
@endsection