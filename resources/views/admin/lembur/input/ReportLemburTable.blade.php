
 <?php
	$action = $action;
	if($action == '2'){
 
 ?>
<div class="col-md-12" id="semuakaryawan" style="padding: 0;">
	<div class="panel panel-default">
		<div class="panel-heading flex-center">
			<b>Rekap Lembur</b>
		</div>
		<div class="panel-body" style="overflow:scroll;">
			<div class="table-responsive" style="width: 1076px; overflow:auto;">
				<div style="max-height: 350px; overflow-y: scroll;">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center">No</div></th>
								<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" style="width: 70px">Nama Pegawai</div></th>
								<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" >NIK</div></th>
								<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" >Dept / Unit</div></th>
								<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" style="width: 70px">Tanggal</div></th>
								<th rowspan="2" style="vertical-align: middle;"><div align="center">Jenis K / L</div></th>
								<th rowspan="2" style="vertical-align: middle;"><div align="center">Jadwal</div></th>
								<th rowspan="1" colspan="7" style="vertical-align: middle;"><div align="center" >Waktu Lembur</div></th>
								<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center">Keterangan</div></th>
								<th rowspan="1" colspan="2" style="vertical-align: middle;"><div align="center">Diketahui</div></th>
							</tr>
							<tr role="row">
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Mulai (Form)</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Selesai (Form)</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Mulai (Finger)</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Selesai (Finger)</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Mulai (Valid)</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Selesai (Valid)</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Jumlah</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">1</th>
								<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center" >2</th>
							</tr>
						</thead>
						<tbody>   
							<?php
								$no = 0;
							?>
							@foreach($data_lembur as $data)
							
							<?php
								$no = $no+1;
								// $tgl_lembur = substr($data->tgl_lembur_awal, 0, 11);
								// $jam_awal = substr($data->tgl_lembur_awal, 10, 9);
								// $jam_akhir = substr($data->tgl_lembur_akhir, 10, 9);
								// $wjm = $data->wjm;
								// if($wjm == ''){
								// 	$wjm = '00:00:00';
								// }else{
								// 	$wjm = $data->wjm.'00';
								// }

								// $wjk = $data->wjk;
								// if($wjk == ''){
								// 	$wjk = '00:00:00';
								// }else{
								// 	$wjk = $data->wjk.'00';
								// }
							?>
							<tr>                       
								<td><?php echo $no; ?></td>
								<td>{{$data->nama_karyawan}}</td>
								<td>{{$data->nik}}</td>
								<td>{{$data->unit}}</td>
								<td>{{\Carbon\Carbon::parse($data->tgl_lembur_awal)->format('d-m-Y')}}</td>
								<td>{{$data->jenis_lembur}}</td>
								<?php
								if ($data->shifting == 'Y') {
								 	$jadwalshift = \App\Models\ShiftSchedule::where('date',\Carbon\Carbon::parse($data->tgl_lembur_awal)->format('Y-m-d'))->where('nik',$data->nik)->first();
								 	$mstjadwal = \App\Models\Schedule::where('dept_id',$jadwalshift->dept)
								 					->where('code',$jadwalshift->schedule_code)->first();
								 	$time_awal = \Carbon\Carbon::parse($mstjadwal->time_schedule_awal)->format('H:i');
								 	$time_akhir = \Carbon\Carbon::parse($mstjadwal->time_schedule_akhir)->format('H:i');
								 	$jadwal = $jadwalshift->schedule_code." - (".$time_awal."-".$time_akhir.")";
								}else{
									$jadwalnonshift = \App\Models\NonshiftSchedule::where('date',\Carbon\Carbon::parse($data->tgl_lembur_awal)->format('Y-m-d'))->where('nik',$data->nik)->first();
									$jadwalnonshift = \App\Models\MstNonshiftSchedules::where('id',$jadwalnonshift->schedule_code)->first();
									$time_awal = \Carbon\Carbon::parse($jadwalnonshift->time_schedule_awal)
													->format('H:i');
								 	$time_akhir = \Carbon\Carbon::parse($jadwalnonshift->time_schedule_akhir)
								 					->format('H:i');
								 	$jadwal = $jadwalnonshift->schedule_code." - (".$time_awal."-".$time_akhir.")";
								}
								?>
								<td>{{$jadwal}}</td>
								<td>{{\Carbon\Carbon::parse($data->tgl_lembur_awal)->format('H:i:s')}}</td>
								<td>{{\Carbon\Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s')}}</td>
								<td>{{$data->wjm}}</td>
								<td>{{$data->wjk}}</td>
								<td>
								<?php
									if($data->batas_lembur == 'Bawah'){
										if(\Carbon\Carbon::parse($data->tgl_lembur_awal)->format('H:i:s') > $data->wjm){
											echo $data->wjm;
										}else{
											echo \Carbon\Carbon::parse($data->tgl_lembur_awal)->format('H:i:s');
										}
									}else{
										echo \Carbon\Carbon::parse($data->tgl_lembur_awal)->format('H:i:s');
									}
								?>
								</td>
								<td>
								<?php
									if($data->batas_lembur == 'Bawah'){
										if(\Carbon\Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s') > $data->wjk){
											echo $data->wjk;
										}else{
											echo \Carbon\Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s');
										}
									}else{
										echo \Carbon\Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s');
									}
								?>
								</td>
								<td>{{$data->lama_lembur}}</td>
								<td>{{$data->keterangan_lembur}}</td>
								<td>{{$data->app1}}</td>
								<td>{{$data->app2}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="col-md-3">
		</div>
		<div class="col-md-3">
		</div>
		<div class="col-md-3">
		</div>
		<div class="col-md-3">
			<div class="form-group">
			<form action="{{url('/backend/rekap/rekap_lembur/export')}}" method="POST">
				{{csrf_field()}}
				<input class="form-control" name="get_nama_karyawan" value="{{$nama_karyawan}}" id="get_nama_karyawan" style="display:none;" />
				<input id="get_div" name="get_div" value="{{$kd_divisi}}" class="form-control" style="display:none;" >
				<input id="get_nik" name="get_nik" value="{{$nik}}" class="form-control" style="display:none;" >
				<input id="get_bulan" name="get_bulan" value="{{$bulan}}" class="form-control" style="display:none;" >
				<input id="get_tahun" name="get_tahun" value="{{$tahun}}" class="form-control" style="display:none;" >
				<button href="" type="submit" class="btn btn-success">Print</button>
			</form>
			</div>
		</div>
	</div>
</div>

<?php
	}else{
	}
?>