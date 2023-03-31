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
					@if (\Session::has('success'))
						<div class="alert alert-success">
							<ul>
								<li>{!! \Session::get('success') !!}</li>
							</ul>
						</div>
					@endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Form Cuti
                        </div>
						<form action="{{url('/backend/store/cuti/pengajuan_cuti')}}" method="post">
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
															<label>Nama Karyawan<span style="color: red;font-size: 19px"><b>*</b></span></label>
															<?php echo $getuser; ?>
															<div class="form-group">
																<label>Jabatan<span style="color: red;font-size: 19px"><b>*</b></span></label>
																<input class="form-control" name="jabatan" id="jabatan" value="{{$parameter['jabatan']}}" required readonly>
															</div>
															<div class="form-group">
																<label>Div/Dept/Bag<span style="color: red;font-size: 19px"><b>*</b></span></label>
																<?php
																//	if($getdiv == '1'){
																?>
																<select id="kd_divisi" name="kd_divisi" value="{{$parameter['dept_id']}}" class="form-control" required>
																	<option value="">Pilih Departement</option>
																	@foreach($departements as $departement)
																	<option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
																	@endforeach
																</select>
																<?php
																//	}else{
																?>
																<!--input class="form-control" name="kd_divisi" id="kd_divisi" value="{{$parameter['dept_id']}}" required readonly-->
																<?php
																//	}
																?>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group">
																<label>NIK<span style="color: red;font-size: 19px"><b>*</b></span></label>
																<input class="form-control" name="nik" id="nik" value="{{$parameter['nik']}}" readonly required>
															</div>
															<div class="form-group">
																<label>TMK</label>
																<input class="form-control" name="tmk" id="tmk" value="{{$parameter['tmk']}}" readonly required>
															</div>
															<div class="form-group">
																<label>Tanggal</label>
																<input class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan" value="<?php echo date('Y-m-d'); ?>" readonly required>
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
														<input class="form-control" type="text" name="kode_cuti" id="kode_cuti" style="display:none;">
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
																	@role('Super Admin')
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti17" value="C17" onclick="cutiKhusus('C17');inputJumlahCuti('C17');lamaCuti('17');">Cuti Sakit dengan Surat Dokter
																		</label>
																	</div>
																	@endrole
																	<div class="checkbox">
																		<label>
																			<input type="checkbox" name="jenis_cuti" class="jenis_cuti" id="jenis_cuti18" value="C18" onclick="cutiKhusus('C18');inputJumlahCuti('C18');lamaCuti('18');">Cuti Setengah
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
														<h4>C. PERIODE PERMOHONAN CUTI/IJIN</h4>
														<input id="idf" value="1" type="hidden" />
														<div class="row" id="periode_cuti">
														</div>
													</div>
												</div>
											</div>
											
											
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<h4>E. PENJELASAN CUTI/IJIN/KETIDAKHADIRAN<span style="color: red;font-size: 19px"><b>*</b></span></h4>
														<div class="form-group">
															<textarea name="penjelasan_cuti" id="penjelasan_cuti" required="true" class="form-control" rows="3" ></textarea>
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
												@role('Super Admin')
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
												@endrole
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
																<input class="form-control" name="hak_cuti_tahunan" id="hak_cuti_tahunan" value="{{$parameter['sisa_cuti_tahunan']}}" readonly> hari
															</div>
															<div class="form-group">
																<label>Telah diambil</label>
																<input class="form-control" name="cuti_tahunan_sudah_diambil" id="cuti_tahunan_sudah_diambil" value="{{$parameter['sisa_cuti_tahunan_diambil']}}" readonly> hari
															</div>
															<div class="form-group">
																<label>Sisa sebelum diambil</label>
																<input class="form-control" name="cuti_tahunan_sebelum_diambil" id="cuti_tahunan_sebelum_diambil" value="{{$parameter['sisa_cuti_tahunan']}}" readonly> hari
															</div>
															<div class="form-group">
																<label>Akan diambil</label>
																<input class="form-control" name="cuti_tahunan_akan_diambil" id="cuti_tahunan_akan_diambil" readonly> hari
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
																<input class="form-control" name="hak_cuti_besar" id="hak_cuti_besar" value="{{$parameter['sisa_cuti_besar']}}" readonly> hari
															</div>
															<div class="form-group">
																<label>Telah diambil</label>
																<input class="form-control" name="cuti_besar_sudah_diambil" id="cuti_besar_sudah_diambil" value="{{$parameter['sisa_cuti_besar_diambil']}}" readonly> hari
															</div>
															<div class="form-group">
																<label>Sisa sebelum diambil</label>
																<input class="form-control" name="cuti_besar_sebelum_diambil" id="cuti_besar_sebelum_diambil" value="{{$parameter['sisa_cuti_besar']}}" readonly> hari
															</div>
															<div class="form-group">
																<label>Akan diambil</label>
																<input class="form-control" name="cuti_besar_akan_diambil" id="cuti_besar_akan_diambil"  readonly> hari
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
										<!--button class="btn btn-success" onclick="saveCuti();"><i class="icon-ok"></i>Ajukan</button-->
										<button class="btn btn-success"><i class="icon-ok"></i>Ajukan</button>
									</div>
								</div>
							</div>
                        </div>
						<div class="col-lg-12">
							@include('admin.cuti.modalKaryawan')
						</div>
						</form>
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