<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="H2">Modal Form</h4>
			</div>
			<div class="modal-body">
				<div style="height:500px; overflow:scroll;">
					<div class="table-responsive">
						<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
							<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
								<thead>
									<tr>
										<th colspan = "4">
											<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data()" autofocus>
										</th>
									</tr>
									<tr role="row">
										<th tabindex="0" aria-controls="dataTables-example" rowspan="2" colspan="1" >Nama Karyawan</th>
										<th tabindex="0" aria-controls="dataTables-example" rowspan="2" colspan="1" >Id</th>
									</tr>
								</thead>
								<tbody id="isi_data">
									<?php
									//	foreach($datamngrspv as $data_mngr_spv){
									?>
										<!--tr class="gradeA odd">
										</tr-->
									<?php
									//	}
									?>
									@foreach($datamngrspv as $data_mngr_spv)
									<tr class="gradeA odd">
										<td onclick="post();">{{$data_mngr_spv->nama}}</td>
										<td onclick="post();">{{$data_mngr_spv->nik}}</td>
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