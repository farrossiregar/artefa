@extends('admin.partial.app')
@section('content')
<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Form Cuti</h1>
		</div>
            </div>
            <div class="row">
                    
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Form Cuti
                        </div>
						<!--form action="{{url('/backend/store/cuti/pengajuan_cuti')}}" method="post"-->
							{{csrf_field()}}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Form Cuti
										</div>
										<div class="col-lg-8" id="testdata">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>A. IDENTITAS PEMOHON</h4>
														<div class="col-lg-6">
															<label>Nama Karyawan</label>
															<?php echo $getuser; ?>
															<div class="form-group">
																<label>Jabatan</label>
																<input class="form-control" name="jabatan" id="jabatan" value="{{$parameter['jabatan']}}" readonly>
															</div>
															<div class="form-group">
																<label>Div/Dept/Bag</label>
																<select id="kd_divisi" name="kd_divisi" value="{{$parameter['dept_id']}}" class="form-control" required>
																	<option value="">Pilih Departement</option>
																	@foreach($departements as $departement)
																	<option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group">
																<label>NIK</label>
																<input class="form-control" name="nik" id="nik" value="{{$parameter['nik']}}" readonly>
															</div>
															<div class="form-group">
																<label>TMK</label>
																<input class="form-control" name="tmk" id="tmk" value="{{$parameter['tmk']}}" readonly>
															</div>
															<div class="form-group">
																<label>Tanggal</label>
																<input class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan" value="<?php echo date('Y-m-d'); ?>" readonly >
															</div>
														</div>
													</div>
												</div>
											</div>
											
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>B. PERIODE PERMOHONAN CUTI/IJIN</h4>
														<div class="col-lg-4">
															<div class="form-group">
																<label>Start Date</label>
																<div class="input-group date" data-provide="datepicker">
																	<input type="text" id="dateFrom" name="" class="form-control tgl_cuti_awal">
																	<div class="input-group-addon">
																		<span class="glyphicon glyphicon-th"></span>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
																<label>End Date :</label>
																<div class="input-group date" data-provide="datepicker">
																	<input type="text" id="dateFrom" name="" class="form-control tgl_cuti_akhir">
																	<div class="input-group-addon">
																		<span class="glyphicon glyphicon-th"></span>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group input-group">
																<label>Jumlah Hari Kerja :</label>
																<input id="jumlah_hari" name="jumlah_hari" class="form-control">
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>C. ALASAN CUTI/IJIN</h4>
														<div class="row">
														<input class="form-control" type="text" name="kode_cuti" id="kode_cuti" style="display:none;">
															<div class="col-lg-12">
																<div class="form-group">
																	<div class="">
																		<label>
																			<input type="radio" name="jenis_cuti" id="jenis_cuti" value="C1" onclick="cutiKhusus('C1');inputJumlahCuti('C1');lamaCuti('1');">Cuti Tahunan
																		</label>
																	</div>
																	<div class="" >
																		<label>
																			<input type="radio" name="jenis_cuti" id="jenis_cuti" value="C2" onclick="cutiKhusus('C2');inputJumlahCuti('C2');lamaCuti('2');">Sakit Sebagai Cuti (tanpa dengan dokter)
																		</label>
																	</div>
																	<div class="">
																		<label>
																			<input type="radio" name="jenis_cuti" id="jenis_cuti" value="C3" onclick="cutiKhusus('C3');inputJumlahCuti('C3');lamaCuti('3');">Izin potong cuti (ketidakhadiran diluar rencana cuti tahunan)
																		</label>
																	</div>
																	<div class="">
																		<label>
																			<input type="radio" name="jenis_cuti" id="jenis_cuti" value="C4" onclick="cutiKhusus('C4');inputJumlahCuti('C4');cuti_besar('C4');lamaCuti('4');">Cuti besar / panjang (setelah masa kerja 6 tahun berturut-turut)
																		</label>
																	</div>
																	<div class="" >
																		<label>
																			<input type="radio" name="jenis_cuti" id="jenis_cuti" value="C5" onclick="cutiKhusus('C5');inputJumlahCuti('C5');" >Cuti Khusus
																		</label>
																	</div>
																	<div class="" >
																		<label>
																			<input type="radio" name="jenis_cuti" id="jenis_cuti" value="C7" onclick="cutiKhusus('C7');inputJumlahCuti('C7');" >Cuti Sakit dengan Surat Dokter
																		</label>
																	</div>
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
													
														<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>E. PENJELASAN CUTI/IJIN/KETIDAKHADIRAN</h4>
														<div class="form-group">
															<textarea name="penjelasan_cuti" id="penjelasan_cuti" class="form-control" rows="3" ></textarea>
														</div>
													</div>
												</div> 
												
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>G. Alamat yang bisa dihubungi selama cuti/ijin tidak masuk kerja :</h4>
														<h6><i>(untuk kepentingan keadaan darurat)</i></h6>
														<div class="form-group">
															<textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
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
																	<div class="col-md-12">
																		<select name="petugas_pengganti" id="petugas_pengganti"  class="form-control">
																			<option selected disabled>- Pilih Nama -</option>
																			@foreach($data_karyawan as $datakaryawan)
																			<option value="{{$datakaryawan->nama}}">{{$datakaryawan->nama}}</option>
																			@endforeach
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-body">
														<div class="form-group">
															<div class="row">
																<div class="col-md-6">
																	<h4>I. Pengajuan Tanpa Approve	:</h4>
																</div>
															</div>
															<div class="row">	
																<div class="col-lg-12">
																	<div class="col-lg-4">
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="action" id="action1" value="Y">Ya
																				</label>
																			</div>
																		</div>	
																	</div>	
																	<div class="col-lg-4">
																		<div class="form-group">
																			<div class="">
																				<label>
																					<input type="radio" name="action" id="action2" value="N" >Tidak
																				</label>
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
										
										<div class="col-lg-4">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>D. PERHITUNGAN CUTI TAHUNAN</h4>
														<div class="col-lg-12">
															<div class="form-group">
																<label>Hak cuti hari sebelumnya</label>
																<input class="form-control" name="hak_cuti_tahunan" id="hak_cuti_tahunan" value="{{$parameter['sisa_cuti_tahunan']}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Telah diambil</label>
																<input class="form-control" name="cuti_tahunan_sudah_diambil" id="cuti_tahunan_sudah_diambil" value="{{$parameter['sisa_cuti_tahunan_diambil']}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Sisa sebelum diambil</label>
																<input class="form-control" name="cuti_tahunan_sebelum_diambil" id="cuti_tahunan_sebelum_diambil" value="{{$parameter['sisa_cuti_tahunan']}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Akan diambil</label>
																<input class="form-control" name="cuti_tahunan_akan_diambil" id="cuti_tahunan_akan_diambil" disabled> hari
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>D. PERHITUNGAN CUTI KHUSUS</h4>
														<div class="col-lg-12">
															<div class="form-group">
																<label>Hak cuti hari sebelumnya</label>
																<input class="form-control" name="hak_cuti_khusus" id="hak_cuti_khusus" value="{{$parameter['sisa_cuti_khusus']}}"" disabled> hari
															</div>
															<div class="form-group">
																<label>Telah diambil</label>
																<input class="form-control" name="cuti_khusus_sudah_diambil" id="cuti_khusus_sudah_diambil" value="{{$parameter['sisa_cuti_khusus_diambil']}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Sisa sebelum diambil</label>
																<input class="form-control" name="cuti_khusus_sebelum_diambil" id="cuti_khusus_sebelum_diambil" value="{{$parameter['sisa_cuti_khusus']}}" disabled> hari
															</div>
															<div class="form-group">
																<label>Akan diambil</label>
																<input class="form-control" name="cuti_khusus_akan_diambil" id="cuti_khusus_akan_diambil"  disabled> hari
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>Catatan</h4>
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
							<div class="row">	
								<div class="col-md-12">	
									<div class="form-group">	
										<button class="btn btn-success" onclick="saveCuti();"><i class="icon-ok"></i>Ajukan</button>
										<!--button class="btn btn-success"><i class="icon-ok"></i>Ajukan</button-->
									</div>
								</div>
							</div>
                        </div>
						<div class="col-lg-12">
							@include('admin.cuti.modalKaryawan')
						</div>
						<!--/form-->
                    </div>
                </div>
            </div>
        </div>
		
		<script type="text/javascript">
			$('.datepicker').datepicker({
				format: 'mm/dd/yyyy',
				startDate: '-3d'
			});
			
			var base_url = "{{ url('/') }}";
			var token = "{{csrf_token()}}";
		</script>
@endsection