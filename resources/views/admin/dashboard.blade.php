@extends('admin.partial.app')
@section('content')
<div class="inner">
<div class="row">
	<div class="col-lg-12">
	    <h1> Admin Dashboard </h1>
	</div>
</div>
<div class="row">
	@role('Super Admin')
		<div class="col-lg-12">
		    <div class="box dark">
		        <header>
		            <div class="toolbar">
		                <ul class="nav">
		                    <li>
		                        <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-1">
		                            <i class="icon-chevron-up"></i>
		                        </a>
		                    </li>
		                </ul>
		            </div>
		        </header>
		        <div id="div-1" class="accordion-body collapse in body">
		            <div class="row">
		            	<div class="col-lg-12" style="padding-bottom: 20px">
		            		<div class="row">
		            			<div class="col-lg-3"></div>
		            			<div class="col-lg-3">
		            				<select name="department" class="form-control col-md-6">
		            				    @foreach($dept as $department)
		            				    <option value="{{$department->id}}">{{$department->department}} - {{$department->unit}}</option>
		            				    @endforeach
		            				</select>
		            			</div>
		            			<div class="col-lg-2">
		            				<?php $now=\Carbon\Carbon::now()->format('d-m-Y'); ?>
		            				<input type="text" class="form-control datepicker" placeholder="{{$now}}" name="date">
		            			</div>
		            			<div class="col-lg-2">
		            				<button type="button" onclick="chartKehadiran();chartCuti();" class="btn btn-md btn-success">Reload Data</button>
		            			</div>
		            			<div class="col-lg-2"></div>
		            		</div>
		            	</div>
		            	<div class="col-lg-8">
			            	<div class="row">
			            		<div class="col-lg-12">
			            		    <div class="panel panel-default">
			            		        <div class="panel-heading">
			            		            <b>Kehadiran per Bulan (%)</b>
			            		        </div>
			            		        <div class="panel-body" id="divkehadiranperbulan">
			            		            <canvas id="kehadiranperbulan"></canvas>
			            		        </div>
			            		    </div>
			            		</div>
    			            	<div class="col-lg-12">
    			            	    <div class="panel panel-default">
    			            	        <div class="panel-heading">
    			            	            <b>Keterlambatan per Bulan</b>
    			            	        </div>
    			            	        <div class="panel-body" id="divkehadiranperhari">
    			            	            <canvas id="kehadiranperhari"></canvas>
    			            	        </div>
    			            	    </div>
    			            	</div>
			            	</div>
							<div class="row">
								<div class="col-lg-6 hide">
    			            	    <div class="panel panel-default">
    			            	        <div class="panel-heading">
    			            	            <b>Persentase Cuti Per Hari (%)</b>
    			            	        </div>
    			            	        <div class="panel-body" id="divpersentasecutihari">
    			            	            <canvas id="persentasecutihari"></canvas>
    			            	        </div>
    			            	    </div>
								</div>
								<div class="col-lg-6">
    			            	    <div class="panel panel-default">
    			            	        <div class="panel-heading">
    			            	            <b>Persentase Cuti Per Bulan (%)</b>
    			            	        </div>
    			            	        <div class="panel-body" id="divpersentasecutibulan">
    			            	            <canvas id="persentasecutibulan"></canvas>
    			            	        </div>
    			            	    </div>
								</div>
								<div class="col-lg-6">
    			            	    <div class="panel panel-default">
    			            	        <div class="panel-heading">
    			            	            <b>Jumlah Karyawan Per Level (Orang)</b>
    			            	        </div>
    			            	        <div class="panel-body" id="divrankcutiperhari">
    			            	            <canvas id="rankcutiperhari"></canvas>
    			            	        </div>
    			            	    </div>
    			            	</div>
    			            	<div class="col-lg-6">
    			            	    <div class="panel panel-default">
    			            	        <div class="panel-heading">
    			            	            <b>Jumlah Karyawan Per Masa Kerja (Orang)</b>
    			            	        </div>
    			            	        <div class="panel-body" id="divrankcutiperbulan">
    			            	            <canvas id="rankcutiperbulan"></canvas>
    			            	        </div>
    			            	    </div>
								</div>

								<br>
								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<b>Karyawan Aktif Non Aktif (Orang)</b>
										</div>
										<div class="panel-body" id="divrankcutiperbulan">
											<canvas id="aktifnonaktif"></canvas>
										</div>
									</div>
								</div>
							</div>
		            	</div>

						<div class="col-md-4">
							<div class="panel panel-danger">
								<div class="panel-heading">
									NOTIFIKASI PENGAJUAN
								</div>
								<?php
									class waktu_pengajuan{
										protected $tgl_pengajuan;
										
										public function __construct($tgl_pengajuan){
											$this->tgl_pengajuan = $tgl_pengajuan;
											$diff = abs(strtotime(date('Y-m-d H:i:s')) - strtotime($this->tgl_pengajuan));
											$years   = floor($diff / (365*60*60*24)); 
											$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
											$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
											$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
											$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
											
											if($days > 0){
												$waktu = $days.' hari yang lalu';
											}else{
												if($hours > 0){
													$waktu = $hours.' jam yang lalu';
												}else{
													$waktu = $minuts.' menit yang lalu';
												}
											}
											echo $waktu;
										}
									}

									class approval_pengajuan{
										protected $app_pengajuan1;
										protected $app_pengajuan2;
										protected $app_pengajuan3;
										
										public function __construct($app_pengajuan1, $app_pengajuan2, $app_pengajuan3){
											if($app_pengajuan1 == ''){
												echo "";
											}else{
												if($app_pengajuan1 == 'Y'){
													if($app_pengajuan2 == ''){
														echo "<i class='icon-check'></i>App1";
													}else{
														if($app_pengajuan2 == 'Y'){
															if($app_pengajuan3 == ''){
																echo "<i class='icon-check'></i>App2";
															}else{
																if($app_pengajuan3 == 'Y'){
																	echo "<i class='icon-check'></i>App3";
																}else{
																	echo "<i class='icon-close'></i>App3";
																}
															}
														}else{
															echo "<i class='icon-close'></i>App2";
														}
													}
												}else{
													echo "<i class='icon-close'></i>App1";
												}
											}
										}
									}
								?>
								<div class="panel-body" style="height:500px; overflow:scroll;">
									@foreach($data_cuti as $datacuti)
									<div class="alert alert-success" name="pengajuan_cuti" value="{{$datacuti->id}}">
										<!--form action="{{$cuti_url}}" method="get"-->
										<form action="{{url('/backend/cuti/approve_cuti/')}}{{'/'.$datacuti->id}}" method="get">
										{{csrf_field()}}
											<button type="submit" name="approvecuti" id="approvecuti" value="{{$datacuti->id}}" class="btn btn-success">
												Pengajuan Cuti
											</button> : {{$datacuti->nama_karyawan}} 
											<a style="float:right;">
												<?php 
													$waktu_cuti = new waktu_pengajuan($datacuti->tgl_pengajuan_cuti); 
												?>
											</a>
											<br>
											<?php
												$approval = new approval_pengajuan($datacuti->app1, $datacuti->app2, $datacuti->app3); 
											?>
										</form>
									</div>
									@endforeach
									
									@foreach($data_ijin as $dataijin)
									<div class="alert alert-warning" name="pengajuan_ijin" value="{{$dataijin->id}}">
										<!--form action="{{$ijin_url}}" method="{{$post}}"-->
										<form action="{{url('/backend/ijin/approve_ijin/')}}{{'/'.$dataijin->id}}" method="get">
										{{csrf_field()}}
											<button type="submit" name="approveijin" id="approveijin" value="{{$dataijin->id}}" class="btn btn-warning">
												Pengajuan Ijin
											</button> : {{$dataijin->nama_karyawan}} 
											<a style="float:right;">
												<?php
													$waktu_ijin = new waktu_pengajuan($dataijin->tgl_pengajuan_ijin); 
												?>
											</a>
											<br>
											<?php
												$approval = new approval_pengajuan($dataijin->app1, $dataijin->app2, $dataijin->app3); 
											?>
										</form>
									</div>
									@endforeach
									
									@foreach($data_lembur as $datalembur)
									<div class="alert alert-info" name="pengajuan_lembur" value="{{$datalembur->id}}">
										<!--form action="{{$lembur_url}}" method="{{$post}}"-->
										<form action="{{url('/backend/lembur/approve_lembur/')}}{{'/'.$datalembur->id}}" method="get">
										{{csrf_field()}}
											<button type="submit" name="approvelembur" id="approvelembur" value="{{$datalembur->id}}" class="btn btn-info">
												Pengajuan Lembur
											</button> : {{$datalembur->nama_karyawan}} 
											<a style="float:right;">
												<?php
													$waktu_lembur = new waktu_pengajuan($datalembur->tgl_pengajuan_lembur); 
												?>
											</a>
											<br>
											<?php
												$approval = new approval_pengajuan($datalembur->app1, $datalembur->app2, $datalembur->app3); 
											?>
										</form>
									</div>
									@endforeach
								</div>
							</div>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		

		<script src="/assets/plugins/jquery-2.0.3.min.js"></script>
		<script src="/assets/plugins/morris/raphael-2.1.0.min.js"></script>
		<script src="/assets/plugins/morris/morris.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

		<script>
			$(document).ready(function() {
				var label = {!!json_encode($label)!!};
				var val = {!!json_encode($val)!!};
				var empsval = {!!json_encode($empsval)!!};
				var empslabel = {!!json_encode($empslabel)!!};
				var kehadiranperhari = document.getElementById("kehadiranperhari");
				var ctx = document.getElementById("kehadiranperbulan");

				var rankcutiperhari = document.getElementById("rankcutiperhari");
				var labelcutiharian = {!!json_encode($labelcutiharian)!!};
				var valuecutiharian = {!!json_encode($valuecutiharian)!!};
			//	alert(valuecutiharian);

				var rankcutiperbulan = document.getElementById("rankcutiperbulan");
				var labelcutibulanan = {!!json_encode($labelcutibulanan)!!};
				var valuecutibulanan = {!!json_encode($valuecutibulanan)!!};
				
				var persentasecutihari = document.getElementById("persentasecutihari");
				var persencutihari = {!!json_encode($persencutihari)!!};
				var persentidakcutihari = {!!json_encode($persentidakcutihari)!!};
				var persentasecutiharianchart = [persencutihari, persentidakcutihari];
				
				var persentasecutibulan = document.getElementById("persentasecutibulan");
				var persencutibulan = {!!json_encode($persencutibulan)!!};
				var persentidakcutibulan = {!!json_encode($persentidakcutibulan)!!};
				var persentasecutibulanananchart = [persencutibulan, persentidakcutibulan];

				var aktifnonaktif = document.getElementById("aktifnonaktif");
				var labelstatuskaryawan = {!!json_encode($labelstatuskaryawan)!!};
				var valuestatuskaryawan = {!!json_encode($valuestatuskaryawan)!!};
				

				var myLineChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: label,
						datasets: [{ 
							data: val,
							label: "Kehadiran Perbulan",
							backgroundColor:['#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b','#4abf7b'],
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								stacked: true
							}]
						}
					}
				});
				var myLineChart = new Chart(kehadiranperhari, {
					type: 'line',
					data: {
						labels: empslabel,
						datasets: [{ 
							data: empsval,
							label: "Keterlambatan Per Bulan",
							borderColor: "#3e95cd",
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								ticks: {
									beginAtZero: true,
									min: 0
								}
							}]
						}
					}
				});

				var myLineChart = new Chart(rankcutiperhari, {
					type: 'line',
					data: {
						labels: labelcutiharian,
						datasets: [{ 
							data: valuecutiharian,
							label: "Jumlah Karyawan Per Level",
							borderColor: "#c2f442",
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								ticks: {
									beginAtZero: true,
									min: 0
								}
							}]
						}
					}
				});

				var myLineChart = new Chart(rankcutiperbulan, {
					type: 'bar',
					data: {
						labels: labelcutibulanan,
						datasets: [{ 
							data: valuecutibulanan,
							label: "Jumlah Karyawan Per Masa Kerja",
							backgroundColor:['#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c','#048c8c'],
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								ticks: {
									beginAtZero: true,
									min: 0
								}
							}]
						}
					}
				});

				var myLineChart = new Chart(aktifnonaktif, {
					type: 'pie',
					data: {
						labels:['Non Aktif', 'Aktif'],
						datasets: [{ 
							data: valuestatuskaryawan,
							label: "Rank Cuti Per Hari",
							backgroundColor: ["#e02c2c", "#6acc28"],
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								ticks: {
									beginAtZero: true,
									min: 0
								}
							}]
						}
					}
				});


				var myLineChart = new Chart(persentasecutihari, {
					type: 'pie',
					data: {
						labels:['Cuti Per Hari', 'Hadir Per Hari'],
						datasets: [{ 
							data: persentasecutiharianchart,
							label: "Rank Cuti Per Hari",
							borderColor: ["#e02c2c", "#6acc28"],
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								ticks: {
									beginAtZero: true,
									min: 0
								}
							}]
						}
					}
				});

				var myLineChart = new Chart(persentasecutibulan, {
					type: 'pie',
					data: {
						labels:['Cuti Per Bulan', 'Hadir Per Bulan'],
						datasets: [{ 
							data: persentasecutiharianchart,
							label: "Rank Cuti Per Hari",
							borderColor: ["#e02c2c", "#6acc28"],
							fill: false
						}
						]
					},
					options: {
						scales: {
							xAxes: [{
							ticks: {
									display: false
								}
							}],
							yAxes: [{
								ticks: {
									beginAtZero: true,
									min: 0
								}
							}]
						}
					}
				});

			});
		</script>
	@else
		<div class="col-md-8">
			<div class="flex-center">
				<img src="{{url('/')}}/img/logo.jpg">
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					NOTIFIKASI PENGAJUAN
				</div>
				<?php
					class waktu_pengajuan{
						protected $tgl_pengajuan;
						
						public function __construct($tgl_pengajuan){
							$this->tgl_pengajuan = $tgl_pengajuan;
							
							$diff = abs(strtotime(date('Y-m-d H:i:s')) - strtotime($this->tgl_pengajuan));
				
							$years   = floor($diff / (365*60*60*24)); 
							$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
							$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
							
							$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
							$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
							
							if($days > 0){
								$waktu = $days.' hari yang lalu';
							}else{
								if($hours > 0){
									$waktu = $hours.' jam yang lalu';
								}else{
									$waktu = $minuts.' menit yang lalu';
								}
							}
							echo $waktu;
						}
					}

					class approval_pengajuan{
						protected $app_pengajuan1;
						protected $app_pengajuan2;
						protected $app_pengajuan3;
						
						public function __construct($app_pengajuan1, $app_pengajuan2, $app_pengajuan3){
							if($app_pengajuan1 == ''){
								echo "";
							}else{
								if($app_pengajuan1 == 'Y'){
									if($app_pengajuan2 == ''){
										echo "<i class='icon-check'></i>App1";
									}else{
										if($app_pengajuan2 == 'Y'){
											if($app_pengajuan3 == ''){
												echo "<i class='icon-check'></i>App2";
											}else{
												if($app_pengajuan3 == 'Y'){
													echo "<i class='icon-check'></i>App3";
												}else{
													echo "<i class='icon-close'></i>App3";
												}
											}
										}else{
											echo "<i class='icon-close'></i>App2";
										}
									}
								}else{
									echo "<i class='icon-close'></i>App1";
								}
							}
						}
					}
				?>
				<div class="panel-body" style="height:500px; overflow:scroll;">
					@foreach($data_cuti as $datacuti)
					<div class="alert alert-success" name="pengajuan_cuti" value="{{$datacuti->id}}">
						<!--form action="{{$cuti_url}}" method="{{$post}}"-->
						<form action="{{url('/backend/cuti/approve_cuti/')}}{{'/'.$datacuti->id}}" method="get">
						{{csrf_field()}}
							<button type="submit" name="approvecuti" id="approvecuti" value="{{$datacuti->id}}" class="btn btn-success">
								Pengajuan Cuti
							</button> : {{$datacuti->nama_karyawan}} 
							<a style="float:right;">
								<?php 
									$waktu_cuti = new waktu_pengajuan($datacuti->tgl_pengajuan_cuti); 
								?>
							</a>
							<br>
							<?php
								$approval = new approval_pengajuan($datacuti->app1, $datacuti->app2, $datacuti->app3); 
							?>
						</form>
					</div>
					@endforeach
					
					@foreach($data_ijin as $dataijin)
					<div class="alert alert-warning" name="pengajuan_ijin" value="{{$dataijin->id}}">
						<!--form action="{{$ijin_url}}" method="{{$post}}"-->
						<form action="{{url('/backend/ijin/approve_ijin/')}}{{'/'.$dataijin->id}}" method="get">
						{{csrf_field()}}
							<button type="submit" name="approveijin" id="approveijin" value="{{$dataijin->id}}" class="btn btn-warning">
								Pengajuan Ijin
							</button> : {{$dataijin->nama_karyawan}} 
							<a style="float:right;">
								<?php
									$waktu_ijin = new waktu_pengajuan($dataijin->tgl_pengajuan_ijin); 
								?>
							</a>
							<br>
							<?php
								$approval = new approval_pengajuan($dataijin->app1, $dataijin->app2, $dataijin->app3); 
							?>
						</form>
					</div>
					@endforeach
					
					@foreach($data_lembur as $datalembur)
					<div class="alert alert-info" name="pengajuan_lembur" value="{{$datalembur->id}}">
						<!--form action="{{$lembur_url}}" method="{{$post}}"-->
						<form action="{{url('/backend/lembur/approve_lembur/')}}{{'/'.$datalembur->id}}" method="get">
						{{csrf_field()}}
							<button type="submit" name="approvelembur" id="approvelembur" value="{{$datalembur->id}}" class="btn btn-info">
								Pengajuan Lembur
							</button> : {{$datalembur->nama_karyawan}} 
							<a style="float:right;">
								<?php
									$waktu_lembur = new waktu_pengajuan($datalembur->tgl_pengajuan_lembur); 
								?>
							</a>
							<br>
							<?php
								$approval = new approval_pengajuan($datalembur->app1, $datalembur->app2, $datalembur->app3); 
							?>
						</form>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	@endrole
</div>
<hr />
</div>
@endsection

