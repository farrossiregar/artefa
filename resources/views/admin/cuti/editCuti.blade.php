@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Pengajuan Cuti</h1>
                </div>
            </div>
            <div class="row">
                    
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Edit Pengajuan Cuti
                        </div>
						
						<!--form action="{{url('/backend/store/cuti/approve_cuti')}}" method="post"-->
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
														<!--div class="col-lg-6" hidden>
															<label>Id</label>
															<div class="form-group">
																<input class="form-control" name="id" id="id" value="{{$id}}" readonly />
															</div>
														</div-->
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
														<h4>B. ALASAN CUTI/IJIN</h4>
															
														<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti1" value="C1" onclick="cutiKhusus('C1');inputJumlahCuti('C1');lamaCuti('1');" onchange="checkbox('1');">Cuti Tahunan
																		</label>
																	</div>
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti2" value="C2" onclick="cutiKhusus('C2');inputJumlahCuti('C2');lamaCuti('2');">Sakit Sebagai Cuti (tanpa Surat Dokter)
																		</label>
																	</div>
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti3" value="C3" onclick="cutiKhusus('C3');inputJumlahCuti('C3');lamaCuti('3');">Izin Potong Cuti (ketidakhadiran diluar rencana cuti tahunan)
																		</label>
																	</div>
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti4" value="C4" onclick="cutiKhusus('C4');inputJumlahCuti('C4');lamaCuti('4');">Cuti besar / panjang (setelah masa kerja 6 tahun berturut-turut)
																		</label>
																	</div>
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti5" value="C5" onclick="cutiKhusus('C5');inputJumlahCuti('C5');lamaCuti('5');">Cuti Khusus
																		</label>
																	</div>
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti17" value="C17" onclick="cutiKhusus('C17');inputJumlahCuti('C17');lamaCuti('17');">Cuti Sakit dengan Surat Dokter
																		</label>
																	</div>
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti18" value="C18" onclick="cutiKhusus('C18');inputJumlahCuti('C18');lamaCuti('18');">Cuti Setengah
																		</label>
																	</div>
																</div>
																<div class="col-lg-12" id="keterangan_cuti_div" style="display:none;">
																<div class="col-lg-6">
																	<div class="form-group">
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="5" onclick="lamaCuti('5');">Cuti Pernikahan Karyawan / Karyawati pertama kali (3 hari)
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="6" onclick="lamaCuti('6');">Pernikahan anak (2 hari)<br><br>
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="7" onclick="lamaCuti('7');">Istri karyawan melahirkan atau keguguran(2 hari)<br><br>
																			</label>
																		</div>
																		<div class="raio">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="8" onclick="lamaCuti('8');">Kematian suami/istri/anak (2 hari)<br><br>
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="9" onclick="lamaCuti('9');">Kematian orang tua/mertua (2 hari)<br><br>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="form-group">
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="10" onclick="lamaCuti('10');">Khitanan / Pembaptisan anak (2 hari)<br><br>
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="11" onclick="lamaCuti('11');">Kematian anggota keluarga 1 (satu) rumah (1 hari)<br><br>
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="12" onclick="lamaCuti('12');">Ibadah Haji (40 hari)<br><br>
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="13" onclick="lamaCuti('13');">Cuti hamil & melahirkan (1.5 bulan sebelum dan sesudah melahirkan)
																			</label>
																		</div>
																		<div class="">
																			<label>
																				<input type="radio" name="keterangan_cuti" id="keterangan_cuti" value="14" onclick="lamaCuti('14');">Cuti Keguguran (1.5 bulan dengan surat dokter)
																			</label>
																		</div>
																	</div>
																</div>
															</div>
															</div>
														</div>
														<div class="row">
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>C. PERIODE PERMOHONAN CUTI/IJIN</h4>
														
														
														@foreach($data_cuti as $data)
														<?php
															$kode_cuti = substr($data->jenis_cuti, 1, 2);
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
															
															$tgl_cuti_awal1 = explode('-', substr($data->tgl_cuti_awal, 0, 10));
															$tgl_cuti_awal2 = $tgl_cuti_awal1[1].'/'.$tgl_cuti_awal1[2].'/'.$tgl_cuti_awal1[0];

															$tgl_cuti_akhir1 = explode('-', substr($data->tgl_cuti_akhir, 0, 10));
															$tgl_cuti_akhir2 = $tgl_cuti_akhir1[1].'/'.$tgl_cuti_akhir1[2].'/'.$tgl_cuti_akhir1[0];

														?>
														
														<br>
														<!--div class="row">
															<div class="col-lg-3">
																<div class="form-group">
																	<label>Jenis Cuti</label>
																</div>
															</div>
															<div class="col-lg-3">
																<div class="form-group">
																	<label>Start Date</label>
																</div>
															</div>
															<div class="col-lg-3">
																<div class="form-group">
																	<label>End Date</label>
																</div>
															</div>
															<div class="col-lg-3">
																<div class="form-group">
																	<label>Jumlah Hari</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-3">
																<div class="form-group">
																	<label>{{$data->jenis_cuti_detail}}</label>
																</div>
															</div>
															<div class="col-lg-3" id="div-date1{{$data->kd}}">
																<div class="form-group">
																	<input id="tgl_cuti_awal{{$data->kd}}" name="tgl_cuti_awal{{$data->kd}}" class="form-control fld{{$data->kd}}" value="{{$tgl_cuti_awal2}}" readonly>
																</div>
															</div>
															<div class="col-lg-3" id="div-date2{{$data->kd}}">
																<div class="form-group">
																	<input id="tgl_cuti_akhir{{$data->kd}}" name="tgl_cuti_akhir{{$data->kd}}" class="form-control fld{{$data->kd}}" value="{{$tgl_cuti_akhir2}}" readonly>
																</div>
															</div>
															<div class="col-lg-3">
																<div class="form-group">
																	<input id="jumlah_hari{{$data->kd}}" name="jumlah_hari" class="form-control fld{{$data->kd}}" value="{{$data->jumlah_hari}}" readonly>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-6" id="div-btn{{$data->kd}}">
																<button class="btn btn-info btn{{$data->kd}}" onclick='editdatacuti("{{$data->kd}}", "{{$data->jenis_cuti}}");'><i class="icon-ok"></i>Edit</button>
															</div>
														</div>
														<br-->



														<div class="row">
														<div class="col-lg-12 div'+jenis_cuti_detail+'" id="'+kode_jenis_cuti+'-1">
															<div class="col-lg-4 '+jenis_cuti_detail+'" id="">
																<div class="form-group">
																	<label>Start Date {{$data->jenis_cuti_detail}}</label>
																	<div class="input-group date" data-provide="datepicker">
																		<input type="text" id="tgl_cuti_awal{{$data->kd}}" name="tgl_cuti_awal_'+kode_jenis_cuti+'[]" value="{{$tgl_cuti_awal2}}" class="form-control tgl_cuti_awal'+counter+' fld{{$data->kd}}" readonly>
																			<div class="input-group-addon">
																				<span class="glyphicon glyphicon-th"></span>
																			</div>
																	</div>
																</div>
															</div>
															<div class="col-lg-4 '+jenis_cuti_detail+'">
																<div class="form-group">
																	<label>End Date {{$data->jenis_cuti_detail}}</label>
																	<div class="input-group date" data-provide="datepicker">
																		<input type="text" id="tgl_cuti_akhir{{$data->kd}}" name="tgl_cuti_akhir_'+kode_jenis_cuti+'[]" value="{{$tgl_cuti_akhir2}}" class="form-control tgl_cuti_akhir fld{{$data->kd}}" readonly>
																		<div class="input-group-addon">
																			<span class="glyphicon glyphicon-th"></span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-lg-2">
																<div class="form-group input-group">
																	<label>Jumlah Hari </label>
																	<input id="jumlah_hari{{$data->kd}}" name="jumlah_hari" value="{{$data->jumlah_hari}}" class="form-control fld{{$data->kd}}" readonly>
																</div>
															</div>
															<div class="col-lg-2">
																<div class="btn-group" role="group">
																	<label>&nbsp</label>
																	<!--button type="button" onclick="addcutidate(\''+kode_jenis_cuti+'-1\')" class="btn btn-info btn-md"><i class="icon-plus"></i></button>
																	<button type="button" onclick="deletecutidate(\''+kode_jenis_cuti+'-1\')" class="btn btn-danger btn-md"><i class="icon-remove"></i></button-->
																	<div class="col-lg-6" id="div-btn{{$data->kd}}">
																		<button class="btn btn-info btn{{$data->kd}}" onclick='editdatacuti("{{$data->kd}}", "{{$data->jenis_cuti}}");'><i class="icon-ok"></i>Edit</button>
																	</div>
																</div>
															</div>
														</div>
														</div>
														
														@endforeach
														
													</div>
												</div>
											</div>
											
											
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>E. PENJELASAN CUTI/IJIN/KETIDAKHADIRAN</h4>
														<div class="form-group">
															<textarea name="penjelasan_cuti" id="penjelasan_cuti" class="form-control" rows="3" value="{{$penjelasan_cuti}}" >{{$penjelasan_cuti}}</textarea>
														</div>
													</div>
												</div> 
												
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>G. Alamat yang bisa dihubungi selama cuti/ijin tidak masuk kerja :</h4>
														<h6><i>(untuk kepentingan keadaan darurat)</i></h6>
														<div class="form-group">
															<textarea name="alamat" id="alamat" class="form-control" rows="3" value="{{$alamat}}" >{{$alamat}}</textarea>
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
																	<select name="petugas_pengganti" id="petugas_pengganti"  class="form-control">
																		<option selected disabled>- Pilih Nama -</option>
																		@foreach($data_karyawan as $datakaryawan)
																		<option value="{{$datakaryawan->nama}}" <?php if($petugas_pengganti == $datakaryawan->nama){echo "selected";} ?>>{{$datakaryawan->nama}}</option>
																		@endforeach
																	</select>
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
                        </div>
						<div class="row">
							<div class="col-md-12">
								<div class="col-lg-12" id="div-btn2{{$data->id}}">
									<button class="btn btn-info btns{{$data->kd}}" onclick='editdatacuti2("{{$data->id}}");'><i class="icon-ok"></i>Edit</button>
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-12">
									<a href="{{url('/')}}/backend/cuti/data_cuti"><button class="btn btn-danger"><i class="icon-ok"></i>Keluar</button></a>
								</div>
							</div>
						</div>
						
						<br>
						<!--/form-->
                    </div>
                </div>
            </div>
        </div>
@endsection