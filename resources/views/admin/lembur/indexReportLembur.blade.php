@extends('admin.partial.app')
@section('content')
<div class="inner">
                    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Report Lembur</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Rekap Lembur
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Rekap Lembur
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="panel panel-default">
													<div class="panel-body">
														<div class="row">
															<div class="col-lg-4">
																<h5>PT CAKRAWALA AUTOMOTIF RABHASA</h5>
															</div>
															<div class="col-lg-4">
																<h5>REKAP LEMBUR KARYAWAN</h5>
															</div>
															<div class="col-lg-4">
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-12">&nbsp
															</div>
															<div class="col-lg-12">&nbsp
															</div>
														</div>
														<!--form action="{{url('/backend/rekap/rekap_lembur/get_table')}}" method="post"-->
														{{csrf_field()}}
														<div class="row">
															<div class="col-lg-12">
																<div class="col-lg-6">
																	<label>Nama Karyawan</label>
																	<div class="form-group input-group" onclick="filterkaryawan();">
																		<input class="form-control" name="nama_karyawan" id="nama_karyawan" required readonly />
																		<span class="input-group-addon" data-toggle="modal" data-target="#formModal"><i class="icon-search"></i></span>
																		
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="form-group">
																		<label>NIK</label>
																		<input id="nik" name="nik" class="form-control" required readonly>
																	</div>
																</div>
															</div>
														</div> 
														
														<div class="row">
															<div class="col-lg-12">
																<div class="col-lg-6">
																	<div class="form-group">
																		<label>Divisi</label>
																		<select id="kd_divisi" name="kd_divisi" class="form-control">
																			<option value="" selected>Semua Departemen</option>
																			@foreach($departements as $departement)
																			<option value="{{$departement->id}}">{{$departement->department}}-{{$departement->unit}}</option>
																			@endforeach
																		</select>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="form-group">
																		<label>Bulan/Tahun</label>
																		<div class="row">
																			<div class="col-md-6">
																				<select id="bulan" name="bulan" value="{{$bulan}}"class="form-control" required readonly>
																					<option value="" selected="" disabled="">- Pilih Bulan -</option>
																					<option value="01">Januari</option>
																					<option value="02">Februari</option>
																					<option value="03">Maret</option>
																					<option value="04">April</option>
																					<option value="05">Mei</option>
																					<option value="06">Juni</option>
																					<option value="07">Juli</option>
																					<option value="08">Agustus</option>
																					<option value="09">September</option>
																					<option value="10">Oktober</option>
																					<option value="11">November</option>
																					<option value="12">Desember</option>
																				</select>
																			</div>
																			<div class="col-md-6">
																				<select id="tahun" name="tahun" class="form-control" required readonly>
																					<option value="" selected="" disabled="">- Pilih Tahun -</option>
																					<?php
																						$year = date('Y');
																						$year_5 = date('Y') - 4;
																					?>
																					@foreach( range( $year, $year_5 ) as $i )
																					<option value="{{$i}}">{{$i}}</option>
																					@endforeach
																				</select>
																			</div>
																			
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<div class="col-md-12">
																		<div class="col-md-3">
																			<div class="form-group">
																				<br>
																				<button class="btn btn-success" onclick="getTableLembur();"><i class="icon-ok"></i> Submit</button>
																				<!--button class="btn btn-success"><i class="icon-ok"></i> Submit</button-->
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--/form-->
														<div class="col-md-12" id="reportlembur">
														</div>

														<div class="col-md-12" style="display:none;">
															@ include('admin.lembur.input.ReportLemburTable')
														</div>


														<div class="row">
															<div class="col-md-12">
																<div class="col-md-3">
																	<div class="form-group">
																	<form action="{{url('/backend/rekap/rekap_lembur/export')}}" method="POST">
																		{{csrf_field()}}
																		<input class="form-control" name="get_nama" id="get_nama" style="display:none;" />
																		<input id="get_kd_divisi" name="get_kd_divisi" class="form-control" style="display:none;" >
																		<input id="get_nik" name="get_nik"  class="form-control" style="display:none;" >
																		<input id="get_bulan" name="get_bulan" class="form-control" style="display:none;" >
																		<input id="get_tahun" name="get_tahun" class="form-control" style="display:none;" >
																		<button type="submit" id="btnexp" style="display:none;" class="btn btn-success">Export</button>
																	</form>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div class="col-lg-12">
													<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title" id="H2">Modal Form</h4>
																</div>
																<div class="modal-body">
																	<div style="height:500px; overflow:scroll;">
																		<div class="row">
																			<div class="col-lg-12">
																				<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data()" autofocus>
																			</div>
																		</div>
																	   <div class="table-responsive">
																			<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
																				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
																					
																					<thead>
																						<tr>
																							<th colspan = "4">
																								
																							</th>
																						</tr>
																						<tr role="row">
																							<th tabindex="0" aria-controls="dataTables-example" rowspan="2" colspan="1" >Nama Karyawan</th>
																							<th tabindex="0" aria-controls="dataTables-example" rowspan="2" colspan="1" >Id</th>
																						</tr>
																					</thead>
																					<tbody id="isi_data">
																						@foreach($data_karyawan as $datakaryawan)
																						<tr class="gradeA odd">
																							<td onclick="post();">{{$datakaryawan->nama}}</td>
																							<td onclick="post();">{{$datakaryawan->nik}}</td>
																						</tr>
																						@endforeach
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                    
                    </div>
@endsection