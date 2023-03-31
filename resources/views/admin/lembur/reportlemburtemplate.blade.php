<table border='1'>
    <thead>
        <tr>
			<td colspan="17" style="align:center;" rowspan="2" align="center"><h2><b>DATA LEMBUR</b></h2></td> 
		</tr>
		<tr>
			<td colspan="17" ></td> 
		</tr>
	</thead>
</table>


<table border='1'>
    <thead>
		<tr>
			<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center">No</div></th>
			<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" style="width: 70px">Nama Pegawai</div></th>
			<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" >NIK</div></th>
			<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" >Dept / Unit</div></th>
			<th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" style="width: 70px">Tanggal</div></th>
			<th rowspan="2" style="vertical-align: middle;"><div align="center">Jenis K / L</div></th>
			<th rowspan="1" colspan="8" style="vertical-align: middle;"><div align="center" >Waktu Lembur</div></th>
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
			<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Lama Break (Jam)</th>
			<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Lama Lembur</th>
			<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">1</th>
			<th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center" >2</th>
		</tr>
    </thead>
    <tbody>
    <?php $no = 0; ?>
    @foreach($lembur AS $datalembur)
	<?php $no = $no+1; ?>
        <tr>
			<td><?php echo $no ?></td>
			<td>{{$datalembur->nama_karyawan}}</td>
			<td>{{$datalembur->nik}}</td>
            <td>{{$datalembur->dept_id}}</td>
            <td>
				<?php
					$tgl_lembur = substr($datalembur->tgl_lembur_awal, 0, 11);
					echo $tgl_lembur;
				?>
			</td>
            <td>{{$datalembur->jenis_lembur}}</td>
            <td>
				<?php
					$jam_lembur_awal = substr($datalembur->tgl_lembur_awal, 11, 8);
					echo $jam_lembur_awal;
				?>
			</td>
            <td>
				<?php
					$jam_lembur_akhir = substr($datalembur->tgl_lembur_akhir, 11, 8);
					echo $jam_lembur_akhir;
				?>
			</td>
			<?php
				$wjm = $datalembur->wjm;
				if($wjm == ''){
					$wjm = '00:00:00';
				}else{
					$wjm = $datalembur->wjm.':00';
				}

				$wjk = $datalembur->wjk;
				if($wjk == ''){
					$wjk = '00:00:00';
				}else{
					$wjk = $datalembur->wjk.':00';
				}
			?>
            <td><?php echo $wjm ?></td>
            <td><?php echo $wjk ?></td>
			<td>
				<?php
					if($datalembur->batas_lembur == 'Bawah'){
						if($jam_lembur_awal > $datalembur->wjm.':00'){
							echo $datalembur->wjm.':00';
						}else{
							echo $jam_lembur_awal;
						}
					}else{
						echo $jam_lembur_awal;
					}
				?>
			</td>
            <td>
				<?php
					if($datalembur->batas_lembur == 'Bawah'){
						if($jam_lembur_akhir > $datalembur->wjk.':00'){
							echo $jam_lembur_akhir;
						}else{
							echo $datalembur->wjk.':00';
						}
					}else{
						echo $jam_lembur_akhir;
					}
				?>
			</td>
            <td>
				<?php
					if($datalembur->batas_lembur == 'Atas'){
						if($jam_lembur_akhir > $datalembur->wjk.':00'){
							$diff = abs(strtotime($jam_lembur_akhir) - strtotime($datalembur->wjk.':00'));
						}else{
							$diff = abs(strtotime($datalembur->wjk.':00') - strtotime($jam_lembur_akhir));
						}
						
						$years   = floor($diff / (365*60*60*24)); 
						$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
						$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						
						$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
						$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
						
						echo $hours.':'.$minuts;
					}else{
						if($jam_lembur_awal > $datalembur->wjm.':00'){
							$diff = abs(strtotime($jam_lembur_awal) - strtotime($datalembur->wjm.':00'));
						}else{
							$diff = abs(strtotime($datalembur->wjm.':00') - strtotime($jam_lembur_awal));
						}
			
						$years   = floor($diff / (365*60*60*24)); 
						$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
						$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						
						$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
						$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
						
						echo $hours.':'.$minuts;
					}
				?>
			</td>
            <td>{{$datalembur->lama_lembur}}</td>
            <td>{{$datalembur->keterangan_lembur}}</td>
            <td>{{$datalembur->app1}}</td>
            <td>{{$datalembur->app2}}</td>
            <td>{{$datalembur->app3}}</td>
        </tr>
    @endforeach
    </tbody>
</table>