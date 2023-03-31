<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=ReportCuti.xls");
?>
  <div class="col-md-12">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
		<thead>
			<tr role="row">
				<th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 184px;">No</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 252px;">NIK</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 233px;">Nama</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 159px;">Dept</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 118px;">Sisa Cuti Tahunan</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 118px;">Sisa Cuti Besar</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 118px;">Sisa Others</th>
			</tr>
		</thead>
		
		<tbody>
			@foreach($data_cuti as $data)
			<tr class="gradeA odd">
				<td class="sorting_1">{{$data->nama_karyawan}}</td>
				<td class=" ">{{$data->nik}}</td>
				<td class=" ">{{$data->nama_karyawan}}</td>
				<td class="center ">{{$data->kd_divisi}}</td>
				<td class="center "></td>
				<td class="center "></td>
				<td class="center "></td>
			</tr>
			@endforeach
		</tbody>
	</table>
  </div>
  <?php
	}else{
	}
  ?>