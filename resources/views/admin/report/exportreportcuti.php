<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=ReportCuti.xls");
?>
  <div class="col-md-12">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
			<tbody>
				<tr role="row">
					<td colspan="8"><h3>REPORT CUTI</h3></td>
				</tr>
				<tr role="row">
					<td colspan="8"></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
			<thead>
				<tr role="row">
					<th >No</th>
					<th >NIK</th>
					<th >Nama</th>
					<th >Dept</th>
					<th >Sisa Cuti Tahunan</th>
					<th >Sisa Cuti Besar</th>
					<th >Sisa Others</th>
					<th >Tgl Cuti Diambil</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($data_cuti as $data)
				<tr class="gradeA odd">
					<td class="sorting_1">{{$data->nama_karyawan}}</td>
					<td class=" ">{{$data->nik}}</td>
					<td class=" ">{{$data->nama_karyawan}}</td>
					<td class="center ">{{$data->kd_divisi}}</td>
					<td class="center ">{{$data->sisa_cuti_tahunan}}</td>
					<td class="center ">{{$data->sisa_cuti_besar}}</td>
					<td class="center ">{{$data->sisa_cuti_khusus}}</td>
					<td class="center ">{{$data->tglcutidiambil}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
  </div>
  <?php
	}else{
	}
  ?>