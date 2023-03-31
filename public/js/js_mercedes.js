function cutiKhusus($jenis_cuti){
	var jenis_cuti = $jenis_cuti;
	if(jenis_cuti == 'C18'){
		$('.C18').val('0.5');
	}
/*	var keterangan_cuti_div = document.getElementById("keterangan_cuti_div");
	if(jenis_cuti == 'C5'){	
		keterangan_cuti_div.style.display = 'block';
		var keterangan_cuti = document.getElementById("keterangan_cuti").value;
	}else{
		keterangan_cuti_div.style.display = 'none';
		var keterangan_cuti = '';
	}	*/
}


$(window).load(function(){
	$('.jenis_cuti').change(function(){
		var nik = $("#nik").val();
		var kode_jenis_cuti = this.value;
		var idf = $("#idf").val();

		if(kode_jenis_cuti == 'C1'){
			var tipe_cuti = 'Cuti Tahunan';
		}else if(kode_jenis_cuti == 'C2'){
			var tipe_cuti = 'Sakit Sebagai Cuti';
		}else if(kode_jenis_cuti == 'C3'){
			var tipe_cuti = 'Izin Potong Cuti';
		}else if(kode_jenis_cuti == 'C4'){
			var tipe_cuti = 'Cuti Besar';
		}else if(kode_jenis_cuti == 'C5'){
			var tipe_cuti = 'Cuti Khusus';
		}else if(kode_jenis_cuti == 'C17'){
			var tipe_cuti = 'Cuti Sakit';
		}else{
			var tipe_cuti = 'Cuti Setengah';
		}
		var jenis_cuti_detail = kode_jenis_cuti.substr(1, 2);
		var nik = $("#nik").val();
		var tgl_cuti_awal = $(".tgl_cuti_awal"+jenis_cuti_detail).val();
		var tgl_cuti_akhir = $(".tgl_cuti_akhir"+jenis_cuti_detail).val();

		var counter = kode_jenis_cuti+'1';
		var periodecuti = '<div class="col-lg-12 div'+jenis_cuti_detail+'" id="'+kode_jenis_cuti+'-1">'+
								'<div class="col-lg-4 '+jenis_cuti_detail+'" id="">'+
									'<div class="form-group">'+
										'<label>Start Date '+tipe_cuti+'</label>'+
										'<div class="input-group date" data-provide="datepicker">'+
											'<input type="text" id="datefrom-'+counter+'" name="tgl_cuti_awal_'+kode_jenis_cuti+'[]" class="form-control tgl_cuti_awal'+counter+'">'+
												'<div class="input-group-addon">'+
													'<span class="glyphicon glyphicon-th"></span>'+
												'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-lg-4 '+jenis_cuti_detail+'">'+
									'<div class="form-group">'+
										'<label>End Date '+tipe_cuti+'</label>'+
										'<div class="input-group date" data-provide="datepicker">'+
											'<input type="text" id="dateto-'+counter+'" name="tgl_cuti_akhir_'+kode_jenis_cuti+'[]" class="form-control tgl_cuti_akhir'+counter+'" onchange="hitungcuti(\'' + counter + '\',\''+kode_jenis_cuti+'\',\''+nik+'\')">'+
											'<div class="input-group-addon">'+
												'<span class="glyphicon glyphicon-th"></span>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-lg-2">'+
									'<div class="form-group input-group">'+
										'<label>Jumlah Hari</label>'+
										'<input id="jumlah_hari'+counter+'" name="jumlah_hari_'+kode_jenis_cuti+'[]" class="form-control '+kode_jenis_cuti+'">'+
									'</div>'+
								'</div>'+
								'<div class="col-lg-2">'+
									'<div class="btn-group" role="group">'+
										'<label>Action&nbsp</label>'+
										'<button type="button" onclick="addcutidate(\''+kode_jenis_cuti+'-1\')" class="btn btn-info btn-md"><i class="icon-plus"></i></button>'+
										'<button type="button" onclick="deletecutidate(\''+kode_jenis_cuti+'-1\')" class="btn btn-danger btn-md"><i class="icon-remove"></i></button>'+
									'</div>'+
								'</div>'+
							'</div>';
		if(this.checked){
			if(kode_jenis_cuti == 'C4'){
				data = {		
					_token : token,
					nik:nik
				};
				$.ajax({
					url: base_url+'/backend/cuti/cuti_besar',
					type: 'POST',
					data: data,
				})
				.done(function(msg) {
					if(msg == 0){
						$.alert({	
							title: 'Alert!',
							type: 'red',
							content: 'Anda belum bisa menggunakan cuti besar!',
						});
					}else{
						$('#periode_cuti').append(periodecuti);
					}
				})
				.fail(function() {
					console.log('gagal')
				});
			}else{
				$('#periode_cuti').append(periodecuti);
			}
			var keterangan_cuti_div = document.getElementById("keterangan_cuti_div");
			if(kode_jenis_cuti == 'C5'){
				keterangan_cuti_div.style.display = 'block';
				var keterangan_cuti = document.getElementById("keterangan_cuti").value;
			}else{
				
			}

			$('#tambahtgl'+jenis_cuti_detail).click(function(){
				idf = (idf-1) + 2;
				var periodecutichild = '<div class="col-lg-4 '+jenis_cuti_detail+'" id=""><div class="form-group"><label>Start Date '+tipe_cuti+'</label><div class="input-group date" data-provide="datepicker"><input type="text" id="dateFrom[]" name="tgl_cuti_awal[]" class="form-control tgl_cuti_awal'+jenis_cuti_detail+' tglcuti_awal'+jenis_cuti_detail+''+idf+'"  onchange="panjangcuti('+jenis_cuti_detail+', '+nik+', 000, '+idf+')"><div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div></div></div></div><div class="col-lg-4 '+jenis_cuti_detail+'"><div class="form-group"><label>End Date '+tipe_cuti+'</label><div class="input-group date" data-provide="datepicker"><input type="text" id="dateFrom'+jenis_cuti_detail+'" name="tgl_cuti_akhir[]" class="form-control tgl_cuti_akhir'+jenis_cuti_detail+' tglcuti_akhir'+jenis_cuti_detail+''+idf+'" onchange="panjangcuti('+jenis_cuti_detail+', '+nik+', 000, '+idf+')"><div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div></div></div></div><div class="col-lg-4"><div class="form-group input-group"><label>Jumlah Hari '+tipe_cuti+'</label><input id="jumlah_hari'+jenis_cuti_detail+'" name="jumlah_hari[]" class="form-control jmlhhar'+jenis_cuti_detail+''+idf+'"></div></div>';
				$('.div'+jenis_cuti_detail).append(periodecutichild);
			});
		}else{
			$('.div' + jenis_cuti_detail).remove();
			var keterangan_cuti_div = document.getElementById("keterangan_cuti_div");
			if(kode_jenis_cuti == 'C5'){
				keterangan_cuti_div.style.display = 'none';
				var keterangan_cuti = '';
			}else{
				
			}
		}
	})
});


function hitungcuti(jenis_cuti_detail,kode_jenis_cuti,nik){
	var inpcutiawal = "#datefrom-"+jenis_cuti_detail+"";
	var inpcutiakhir = "#dateto-"+jenis_cuti_detail+"";
	var jmlhhari = "#jumlah_hari"+jenis_cuti_detail+"";
	var tgl_cuti_awal = $(inpcutiawal).val();
	var tgl_cuti_akhir = $(inpcutiakhir).val();
	$('.loading').removeClass('hide');
	data = {		
		_token : token,
		tgl_cuti_awal : tgl_cuti_awal,
		tgl_cuti_akhir : tgl_cuti_akhir,
		nik:nik
	};
	
	$.ajax({
		url: base_url+'/backend/cuti/lamacutikaryawan',
		type: 'POST',
		data: data,
	})
	.done(function(msg) {
		$('.loading').addClass('hide');
		console.log(kode_jenis_cuti);
		if(kode_jenis_cuti == 'C18'){
			var setengah = parseFloat("0.5");
			$(jmlhhari).val(setengah);
		}else{
			$(jmlhhari).val(msg);
		}
		
		var c1= new Array();
		$('input[name^="jumlah_hari_C1"]').each(function(){
			c1.push($(this).val());
		});
		var totc1 = 0;
		for (var i = 0; i < c1.length; i++) {
			totc1 = totc1 + parseFloat(c1[i]);
		}
		var c2= new Array();
		$('input[name^="jumlah_hari_C2"]').each(function(){
			c2.push($(this).val());
		});
		var totc2 = 0;
		for (var j = 0; j < c2.length; j++) {
			totc2 = totc2 + parseFloat(c2[j]);
		}
		var c3= new Array();
		$('input[name^="jumlah_hari_C3"]').each(function(){
			c3.push($(this).val());
		});
		var totc3 = 0;
		for (var k = 0; k < c3.length; k++) {
			totc3 = totc3 + parseFloat(c3[k]);
		}
		var c4= new Array();
		$('input[name^="jumlah_hari_C4"]').each(function(){
			c4.push($(this).val());
		});
		var totc4 = 0;
		for (var l = 0; l < c4.length; l++) {
			totc4 = totc4 + parseFloat(c4[l]);
		}
		var c5= new Array();
		$('input[name^="jumlah_hari_C5"]').each(function(){
			c5.push($(this).val());
		});
		var totc5 = 0;
		for (var m = 0; m < c5.mength; m++) {
			totc5 = totc5 + parseFloat(c5[m]);
		}
		var c17= new Array();
		$('input[name^="jumlah_hari_C17"]').each(function(){
			c17.push($(this).val());
		});
		var totc17 = 0;
		for (var n = 0; n < c17.nength; n++) {
			totc17 = totc17 + parseFloat(c17[n]);
		}

		var c18= new Array();
		$('input[name^="jumlah_hari_C18"]').each(function(){
			c18.push($(this).val());
		});
		var totc18 = 0;
		for (var n = 0; n < c18.nength; n++) {
			totc18 = totc18 + parseFloat(c18[n]);
		}

		var tahunan = totc1+totc2+totc3;
		var besar = totc4;
	//	console.log('tahunan '+tahunan+' totc1 '+totc1);
	//	console.log('totc2 '+totc2+' totc3 '+totc3);
		var khusus = totc5;
		$("#cuti_tahunan_akan_diambil").val(tahunan.toString());
		$("#cuti_besar_akan_diambil").val(besar.toString());
	})
	.fail(function() {
		console.log('gagal');
	});
	
	// console.log(tasks);
	// console.log('cuti akhir = '+$(inpcutiakhir));
}

function panjangcuti($jenis_cuti_detail, $nik, $id){
	var nik = $nik;
	var idf = $idf;
	if($id == 0){
		var id = 0;
	}else{
		var id = $id;
	}
	console.log('jenis_cuti '+$jenis_cuti_detail);
	var jenis_cuti_detail = $jenis_cuti_detail;
	if(idf == 0){
		var tgl_cuti_awal = $(".tgl_cuti_awal"+jenis_cuti_detail).val();
		var tgl_cuti_akhir = $(".tgl_cuti_akhir"+jenis_cuti_detail).val();
	}else{
		var tgl_cuti_awal = $(".tglcuti_awal"+jenis_cuti_detail+idf).val();
		var tgl_cuti_akhir = $(".tglcuti_akhir"+jenis_cuti_detail+idf).val();
	}
	
	if(tgl_cuti_awal != '' && tgl_cuti_akhir != '' && nik != ''){
		if(jenis_cuti_detail == '1' || jenis_cuti_detail == '2' || jenis_cuti_detail == '3' || jenis_cuti_detail == '4'){
			data = {		
				_token : token,
				tgl_cuti_awal : tgl_cuti_awal,
				tgl_cuti_akhir : tgl_cuti_akhir,
				nik : nik
			};
	
			$.ajax({
				url: base_url+'/backend/cuti/lamacutikaryawan',
				type: 'POST',
				data: data,
			})
			.done(function(msg) {
				if(tgl_cuti_awal != '' && tgl_cuti_akhir != '' && nik != ''){
					console.log(msg);
				/*	if(id == 0){
						if(idf == 0){
							$("#jumlah_hari"+jenis_cuti_detail).val(msg);
						}else{
							$(".jmlhhar"+jenis_cuti_detail+idf).val(msg);
						}
					}else{
						$("#jumlah_hari"+id).val(msg);
					}	*/
				//	var arr = $('#jumlah_hari[]');
					var arr = document.querySelector('[id^=jmlhhar]')
					var tot=0;
					for(var i=0;i<arr.length;i++){
						if(parseInt(arr[i].value))
							tot += parseInt(arr[i].value);
					}
					$('#cuti_tahunan_akan_diambil').val(tot);
					$('#cuti_besar_akan_diambil').val('');
				}else{
					$("#jumlah_hari").val('');
					$("#cuti_tahunan_akan_diambil").val('');
					$('#cuti_besar_akan_diambil').val('');
				}
			})
			.fail(function() {
				console.log('gagal');
			});
		}else{
			
		}
	}
}

function lamaCuti($jenis_cuti_detail){
	var jenis_cuti_detail = $jenis_cuti_detail;
	if(jenis_cuti_detail == '5'){
		var jumlahhari = '3';
	}else if(jenis_cuti_detail == '6'){
		var jumlahhari = '2';
	}else if(jenis_cuti_detail == '7'){
		var jumlahhari = '2';
	}else if(jenis_cuti_detail == '8'){
		var jumlahhari = '2';
	}else if(jenis_cuti_detail == '9'){
		var jumlahhari = '2';
	}else if(jenis_cuti_detail == '10'){
		var jumlahhari = '2';
	}else if(jenis_cuti_detail == '11'){
		var jumlahhari = '1';
	}else if(jenis_cuti_detail == '12'){
		var jumlahhari = '40';
	}else if(jenis_cuti_detail == '13'){
		var jumlahhari = '90';
	}else if(jenis_cuti_detail == '14'){
		var jumlahhari = '45';
	}else{
		var jumlahhari = '0';
	}
	$('#cuti_tahunan_akan_diambil').val('');
	$('#cuti_besar_akan_diambil').val('');
	$('#jumlah_hari5').val(jumlahhari);
	$('input[name^="jumlah_hari_C5"]').each(function(){
		c5.push($(this).val(jumlahhari));
	});
}

function saveIjin(){
	var nama_karyawan = $('#nama_karyawan').val();
	var nik = $('#nik').val();
	var kd_divisi = $('select[name="kd_divisi"]').val();
	var jabatan = $('#jabatan').val();
	var tgl_ijin_awal = $('#tgl_ijin_awal').val();
	var jam_ijin_awal = $('#jam_ijin_awal').val();
	var tgl_ijin_akhir = $('#tgl_ijin_awal').val();
	var jam_ijin_akhir = $('#jam_ijin_akhir').val();
	var tindak_lanjut = $("input[name='tindak_lanjut']:checked").val();
	var keterangan_ijin = $('#keterangan_ijin').val();
	console.log(tgl_ijin_akhir);
	$('.loading').removeClass('hide');
	data = {		
		_token:token,
		nama_karyawan : nama_karyawan,
		nik : nik,
		kd_divisi : kd_divisi,
		jabatan : jabatan,
		tgl_ijin_awal : tgl_ijin_awal,
		tgl_ijin_akhir : tgl_ijin_akhir,
		jam_ijin_awal : jam_ijin_awal,
		jam_ijin_akhir : jam_ijin_akhir,
		tindak_lanjut : tindak_lanjut,
		keterangan_ijin : keterangan_ijin
	};
	
	console.log(data);
	$.ajax({
		url: base_url+'/backend/store/ijin/pengajuan_ijin',
		type: 'POST',
		data: data,
	})
	.done(function(data) {
		$('.loading').addClass('hide');
		$.alert({
			title: 'Success!',
			type: 'green',
			content: 'Thank you!',
		});
		location. reload(true);
	})
	.fail(function() {
		$('.loading').addClass('hide');
		$.alert({
			title: 'Alert!',
			type: 'red',
			content: 'Please try again',
		});
	});
}


function filterkaryawan(){
	var dept_id = $('#kd_divisi').val();
	var empty = "<tr class='gradeA odd'><td onclick='post();'></td><td onclick='post();'></td></tr>";
	data = {
		'_token': token,
		dept_id: dept_id
	};
	$.ajax({
		url: base_url + '/backend/post/cuti/filterkaryawan',
		type: 'POST',
		data: data,
		success: function (data) {	
			$('#isi_data').html(empty + data);
		}
	});
}


function post() {
	var table = document.getElementsByTagName("table")[0];
	var tbody = table.getElementsByTagName("tbody")[0];
	tbody.onclick = function (e) {
		e = e || window.event;
		var data = [];
		var target = e.srcElement || e.target;
		while (target && target.nodeName !== "TR") {
			target = target.parentNode;
		}
		if (target) {
			var cells = target.getElementsByTagName("td");
			for (var i = 0; i < cells.length; i++) {
				data.push(cells[i].innerHTML);
				dt = data.toString();
			}
		}
	
		dt = data.toString();
		dt_split = dt.split(",");
		var nik = dt_split[1];
		data = {
			'_token': token,
			nik: nik
		};
		if(nik != ''){
			$.ajax({
				url: base_url + '/backend/post/cuti/user',
				type: 'POST',
				data: data,
				success: function (data) {
					dt = data[0].toString();
					dt_split = dt.split(",");	
					console.log(data[0]);
					$('#nama_karyawan').val(data[0]['nama']);
					$('#nik').val(data[0]['nik']);
					$('#jabatan').val(data[0]['level']);
					$('#kd_divisi').val(data[0]['dept_id']);
					$('#tmk').val(data[0]['tgl_join']);
					$('#hak_cuti_tahunan').val(data[0]['sesudah']);
					$('#cuti_tahunan_sudah_diambil').val(data[0]['cutitahunan']);
					$('#cuti_tahunan_sebelum_diambil').val(data[0]['sesudah']);
					$('#hak_cuti_besar').val(data[0]['sesudahB']);
					$('#cuti_besar_sudah_diambil').val(data[0]['cutibesar']);
					$('#cuti_besar_sebelum_diambil').val(data[0]['sesudahB']);
				}
			});
		}else{
			$('#nama_karyawan').val('');
			$('#nik').val('');
			$('#jabatan').val('');
			$('#kd_divisi').val('');
			$('#tmk').val('');
			$('#hak_cuti_tahunan').val('');
			$('#cuti_tahunan_sudah_diambil').val('');
			$('#cuti_tahunan_sebelum_diambil').val('');
			$('#hak_cuti_khusus').val('');
			$('#cuti_khusus_sudah_diambil').val('');
			$('#cuti_khusus_sebelum_diambil').val('');
		}
		$("#formModal").modal('hide');
	};
}

function hari($id){
	var id = $id;
	var eventDate = $('.datecalendar'+id).val();
	var dateElement = eventDate.split("/");
	var dateFormat = dateElement[2]+'-'+dateElement[0]+'-'+dateElement[1];
	var date = new Date(dateFormat+'T10:00:00Z'); //To avoid timezone issues
	var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	var day = weekday[date.getDay()];
	$('#nama_hari'+id).val(day);
	console.log(day);
}


function cari_data(){
	var $rows = $('#isi_data tr');
	$('#search').keyup(function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		
		$rows.show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
	});
}


function tambahHobi() {
	var idf = $("#idf").val();
//	var stre="<p id='srow" + idf + "'><input type='text' size='40' name='rincian_hoby[]' placeholder='Masukkan Hobi' /> <input type='text' size='30' name='jenis_hoby[]' placeholder='Utama/Sambilan' /> <a href='#' style=\"color:#3399FD;\" onclick='hapusElemen(\"#srow" + idf + "\"); return false;'>Hapus</a></p>";
	var stre="<div id='srow" + idf + "'><div class='input-group date col-md-12' data-provide='datepicker'><input type='text' id='tgl_lembur_awal[]' name='tgl_lembur_awal[]' placeholder='Tanggal Lembur' class='form-control datecalendar tgl_lembur_awal"+idf+"' onchange='cektgllembur("+idf+");'><div class='input-group-addon'><span class='glyphicon glyphicon-th'></span></div></div><br><div class='input-group col-md-6'><input class='form-control timeselector jam_lembur_awal[] jla"+idf+"' id='jam_lembur_awal[]' name='jam_lembur_awal[]' type='time' onchange='cektgllembur("+idf+");'/><span class='input-group-addon add-on'><i class='icon-time'></i></span></div><div class='input-group col-md-6'><input class='form-control timeselector jam_lembur_akhir[] jlb"+idf+"' id='jam_lembur_akhir[]' name='jam_lembur_akhir[]' type='time' onchange='cektgllembur("+idf+");'/><span class='input-group-addon add-on'><i class='icon-time'></i></span></div><br><br><br><div class='col-md-12'><textarea name='keterangan_lembur[]' id='keterangan_lembur[]' placeholder='Keterangan Lembur' class='form-control keterangan_lembur[]' rows='3' ></textarea></div><br><div class='col-md-12'><a href='#' class='btn btn-danger'  onclick='hapusElemen(\"#srow" + idf + "\"); return false;'>Hapus</a></div></div><br>";
	$("#divHobi").append(stre); 
	idf = (idf-1) + 2;
	$("#idf").val(idf);
}
function hapusElemen(idf) {
	$(idf).remove();
}

function cektgllembur($idf){
	var nik = $('#nik').val();
	var tgl_lembur = $('.tgl_lembur_awal' + $idf).val();
	var jam_lembur_awal = $('.jla' + $idf).val();
	var jam_lembur_akhir = $('.jlb' + $idf).val();

	data = {
		'_token': token,
		nik : nik,
		tgl_lembur : tgl_lembur,
		jam_lembur_awal : jam_lembur_awal,
		jam_lembur_akhir : jam_lembur_akhir
	}
	if(nik != '' && tgl_lembur != '' && jam_lembur_awal != '' && jam_lembur_akhir != ''){
		$.ajax({
			url: base_url + '/backend/lembur/cektgllembur',
			type: 'POST',
			data: data,
			success: function (ret) {
				if(ret == 1){
					$.alert({
						title: 'Alert!',
						type: 'red',
						content: 'Data sudah ada',
					});
				//	$('.tgl_lembur_awal' + $idf).val('');
					$('.jla' + $idf).val('');
					$('.jlb' + $idf).val('');
				}else{
					
				}
			}
		})
	}
}

function getTableCuti(){
	$('.loading').removeClass('hide');
	var nama_karyawan = $('#nama_karyawan').val();
	var kd_divisi = $('#kd_divisi').val();
	var start_date = $('#start-date').val();
	var end_date = $('#end-date').val();

	var head = '<div class="table-responsive" style="padding: 0;"><div class="panel panel-default"><div class="panel-heading flex-center"><b>Report Cuti</b></div><div class="panel-body" style="overflow:scroll;"><div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"></div><div class="row"><div class="col-sm-4"></div><div class="col-sm-4"><h3>REPORT CUTI KARYAWAN</h3></div><div class="col-sm-4"></div></div><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info"><thead><tr role="row"><th  >No</th><th  >NIK</th><th  >Nama</th><th  >Dept / Unit</th><th  >Sisa Cuti Tahunan</th><th  >Sisa Cuti Besar</th><th  >Tgl Cuti Awal</th><th  >Tgl Cuti Akhir</th><th  >Penjelasan Cuti</th></tr></thead><tbody>';
	var foot = '</tbody></table></div></div></div></div>';
	
	data = {
		'_token': token,
		nama_karyawan : nama_karyawan,
		kd_divisi : kd_divisi,
		start_date : start_date,
		end_date : end_date
	}
	$.ajax({
		url: base_url + '/backend/report/report_cuti/get_table',
		type: 'POST',
		data: data,
		success: function (table) {
			$('.loading').addClass('hide');	
			$('#reportcuti').html(head + table + foot);
			$('#get_nama').val(nama_karyawan);
			$('#get_kd_divisi').val(kd_divisi);
			$('#tgl1').val(start_date);
			$('#tgl2').val(end_date);
			$('#btnexp').show();
		}
	});
}

function getTableLembur(){
	$('.loading').removeClass('hide');
	var nama_karyawan = $('#nama_karyawan').val();
	var nik = $('#nik').val();
	var dept_id = $('#kd_divisi').val();
	var bulan = $('#bulan').val();
	var tahun = $('#tahun').val();
	var head = '<div class="col-md-12" id="semuakaryawan" style="padding: 0;"><div class="panel panel-default"><div class="panel-heading flex-center"><b>Rekap Lembur</b></div><div class="panel-body"><div><div style="max-height: 350px; overflow-y: scroll;"><table class="table table-bordered"><thead><tr><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center">No</div></th><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" style="width: 70px">Nama Pegawai</div></th><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" >NIK</div></th><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" >Dept / Unit</div></th><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center" style="width: 70px">Tanggal</div></th><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center">Jadwal Karyawan</div></th><th rowspan="2" style="vertical-align: middle;"><div align="center">Jenis K / L</div></th><th rowspan="1" colspan="7" style="vertical-align: middle;"><div align="center" >Waktu Lembur</div></th><th rowspan="2" colspan="1" style="vertical-align: middle;"><div align="center">Keterangan</div></th><th rowspan="1" colspan="2" style="vertical-align: middle;"><div align="center">Diketahui</div></th></tr><tr role="row"><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Mulai (Form)</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Selesai (Form)</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Mulai (Finger)</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Selesai (Finger)</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Mulai (Valid)</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Selesai (Valid)</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">Jumlah</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center">1</th><th rowspan="1" colspan="1" style="vertical-align: middle;"><div align="center" >2</th></tr></thead><tbody>';
	var foot = '</tbody></table></div></div></div></div></div>';
	var test = 'test';
	data = {
		'_token': token,
		nama_karyawan : nama_karyawan,
		nik : nik,
		dept_id : dept_id,
		bulan : bulan,
		tahun : tahun
	}
	$.ajax({
		url: base_url + '/backend/rekap/rekap_lembur/get_table',
		type: 'POST',
		data: data,
		success: function (table) {
			$('.loading').addClass('hide');	
			$('#reportlembur').html(head + table + foot);
			$('#get_nama').val(nama_karyawan);
			$('#get_nik').val(nik);
			$('#get_kd_divisi').val(dept_id);
			$('#get_bulan').val(bulan);
			$('#get_tahun').val(tahun);
			$('#btnexp').show();
		}
	});
}


function getTableIjin(){
	$('.loading').removeClass('hide');
	var nama_karyawan = $('#nama_karyawan').val();
	var dept_id = $('#kd_divisi').val();
	var start_date = $('#start-date').val();
	var end_date = $('#end-date').val();
	var head = '<div class="table-responsive" style="padding: 0;"><div class="panel panel-default"><div class="panel-heading flex-center"><b>Report Ijin</b></div><div class="panel-body" style="overflow:scroll;"><div class=""><div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><div class="row"><div class="col-sm-4"></div></div><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info"><thead><tr role="row"><th  >No</th><th  >Status</th><th  >NIK</th><th  >Nama</th><th  >Dept / Unit</th><th  >Tgl Ijin Awal</th><th  >Tgl Ijin Akhir</th><th  >Keterangan</th></tr></thead><tbody>';
	var foot = '</tbody></table></div></div></div></div></div></div>';

	data = {
		'_token': token,
		nama_karyawan : nama_karyawan,
		dept_id : dept_id,
		start_date : start_date,
		end_date : end_date
	}
	$.ajax({
		url: base_url + '/backend/report/report_ijin/get_table',
		type: 'POST',
		data: data,
		success: function (data) {
			$('.loading').addClass('hide');	
			$('#reportijin').html(head + data + foot);
			$('#get_nama').val(nama_karyawan);
			$('#get_kd_divisi').val(dept_id);
			$('#tgl1').val(start_date);
			$('#tgl2').val(end_date);
			$('#btnexp').show();
		}
	});
}


function getdatacuti(){
	$('.loading').removeClass('hide');
	var nama_karyawan = $('#nama_karyawan').val();
	var dept_id = $('#kd_divisi').val();
	var start_date = $('#start-date').val();
	var end_date = $('#end-date').val();
	var head = '<br><br><div class="table-responsive"><div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info"><thead><tr role="row"><th  >No</th><th  >Action</th><th  >Status</th><th  >NIK</th><th  >Nama</th><th  >Dept / Unit</th><th  >Tgl Cuti Awal</th><th  >Tgl Cuti Akhir</th><th  >Jumlah Hari</th><th  >Keterangan</th></tr></thead><tbody>';
	var foot = '</tbody></table></div></div></div>';
	data = {
		'_token': token,
		nama_karyawan : nama_karyawan,
		dept_id : dept_id,
		start_date : start_date,
		end_date : end_date
	}
	$.ajax({
		url: base_url + '/backend/cuti/data_cuti_table',
		type: 'POST',
		data: data,
		success: function (data) {
			$('.loading').addClass('hide');	
			$('#datacuti').html(head + data + foot);
		}
	});
}



function approve($type, $id){
	$('.loading').removeClass('hide');
	if($type == '1'){
		window.location.href = "approve_cuti/" + $id;
	}else if($type == '2'){
		window.location.href = "approve_lembur/" + $id;
	}else if($type == '3'){
		window.location.href = "approve_ijin/" + $id;
	}else{

	}
	$('.loading').addClass('hide');
}

function edit($type, $id){
	$('.loading').removeClass('hide');
	if($type == '1'){
		window.location.href = "edit_cuti/" + $id;
	}else if($type == '2'){
		window.location.href = "edit_lembur/" + $id;
	}else if($type == '3'){
		window.location.href = "edit_ijin/" + $id;
	}else{

	}
	$('.loading').addClass('hide');
}

function editdatacuti($id, $jenis_cuti_detail){
	var kode_cuti = $jenis_cuti_detail;
	var jenis_cuti_detail = kode_cuti.substr(1, 2);
	$('.fld' + $id).removeAttr('readonly');
	$('.btn' + $id).hide();
	var nik = $('#nik').val();
	var datastartdate = $('#tgl_cuti_awal' + $id).val();
	var dataenddate = $('#tgl_cuti_akhir' + $id).val();
//	var fields ="<div><div class='input-group date col-md-12' data-provide='datepicker'><input type='text' id='tgl_lembur_awal" + $id + "' name='tgl_lembur_awal" + $id + "' placeholder='Tanggal Lembur' class='form-control datecalendar'><div class='input-group-addon'><span class='glyphicon glyphicon-th'></span></div></div><br><div class='input-group col-md-6'><input class='form-control timeselector jam_lembur_awal[]' id='jam_lembur_awal[]' name='jam_lembur_awal[]' type='time' /><span class='input-group-addon add-on'><i class='icon-time'></i></span></div><div class='input-group col-md-6'><input class='form-control timeselector jam_lembur_akhir[]' id='jam_lembur_akhir[]' name='jam_lembur_akhir[]' type='time' /><span class='input-group-addon add-on'><i class='icon-time'></i></span></div><br><br><br><div class='col-md-12'><textarea name='keterangan_lembur[]' id='keterangan_lembur[]' placeholder='Keterangan Lembur' class='form-control keterangan_lembur[]' rows='3' ></textarea></div><br><div class='col-md-12'><a href='#' class='btn btn-danger'  onclick='hapusElemen(\"#srow" + idf + "\"); return false;'>Hapus</a></div></div><br>";
	var editbtn = '<button class="btn btn-info btn' + $id + '" onclick="editdatacuti("'+$id+'", "'+$jenis_cuti_detail+'");" ><i class="icon-ok"></i>Edit</button>';
	var savebtn = '<button class="btn btn-success sv' + $id + '" onclick="" ><i class="icon-ok"></i></button>';
	var cancelbtn = '<button class="btn btn-danger cncl' + $id + '" onclick="" ><i class="icon-remove"></i></button>';
	var startdate = '<div class="input-group date" data-provide="datepicker"><input type="text" id="tgl_cuti_awal'+$id+'" name="tgl_cuti_awal'+$id+'" value="'+datastartdate+'" class="form-control datecalendar fld'+$id+' tgl_cuti_awal'+jenis_cuti_detail+'" onchange="panjangcuti('+jenis_cuti_detail+', '+nik+', '+$id+', 00);" ><div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div></div>';
	var enddate = '<div class="input-group date" data-provide="datepicker"><input type="text" id="tgl_cuti_akhir'+$id+'" name="tgl_cuti_akhir'+$id+'" value="'+dataenddate+'" class="form-control datecalendar fld'+$id+' tgl_cuti_akhir'+jenis_cuti_detail+'" onchange="panjangcuti('+jenis_cuti_detail+', '+nik+', '+$id+', 00);"><div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div></div>';
	$('#div-date1'+$id).html(startdate);
	$('#div-date2'+$id).html(enddate);
	
	$('#div-btn' + $id).html(savebtn + cancelbtn);
	$('.cncl' + $id).click(function(){
		$('#div-btn' + $id).html(editbtn);
		$('.fld' + $id).attr('readonly');
	});
	$('.sv' + $id).click(function(){
		$('.loading').removeClass('hide');
		var id = $id;
		var jenis_cuti = $("input[name='jenis_cuti']:checked").val();
		if(jenis_cuti == ''){
			var jenis_cuti = '';
		}else{
			var jenis_cuti = $("input[name='jenis_cuti']:checked").val();
		}
		var tgl_cuti_awal = $('#tgl_cuti_awal' + $id).val();
		var tgl_cuti_akhir = $('#tgl_cuti_akhir' + $id).val();
		var jumlah_hari = $('#jumlah_hari' + $id).val();
		data = {
			'_token': token,
			id : id,
			jenis_cuti : jenis_cuti,
			tgl_cuti_awal : tgl_cuti_awal,
			tgl_cuti_akhir : tgl_cuti_akhir,
			jumlah_hari : jumlah_hari

		}
		$.ajax({
			url: base_url + '/backend/store/cuti/edit_cuti',
			type: 'POST',
			data: data,
		})
		.done(function(data) {
			$('.loading').addClass('hide');
			$.alert({
				title: 'Success!',
				type: 'green',
				content: 'Thank you!',
			});
			window.location.href = "/backend/cuti/data_cuti";
		})
		.fail(function() {
			$('.loading').addClass('hide');
			$.alert({
				title: 'Alert!',
				type: 'red',
				content: 'Please try again',
			});
		});
	});
}

function editdatacuti2($id){
//	$('.flds' + $id).removeAttr('readonly');
	$('.btns' + $id).hide();

	var editbtn = '<button class="btn btn-info btns' + $id + '" onclick="editdatacuti2("'+$id+'");" ><i class="icon-ok"></i>Edit</button>';
	var savebtn = '<button class="btn btn-success sv' + $id + '" onclick="" ><i class="icon-ok"></i>Ubah</button>';
	var cancelbtn = '<button class="btn btn-danger cncls' + $id + '" onclick="" ><i class="icon-ok"></i>Batal</button>';

	$('#div-btn2' + $id).html(savebtn + cancelbtn);
	$('.cncls' + $id).click(function(){
		$('#div-btn2' + $id).html(editbtn);
	//	$('.fld' + $id).attr('readonly');
	});
	$('.sv' + $id).click(function(){
		$('.loading').removeClass('hide');
		var id = $id;
		var alamat = $('#alamat').val();
		var penjelasan_cuti = $('#penjelasan_cuti').val();
		var petugas_pengganti = $('#petugas_pengganti').val();
		data = {
			'_token': token,
			id : id,
			alamat : alamat,
			penjelasan_cuti : penjelasan_cuti,
			petugas_pengganti : petugas_pengganti
		}
		console.log(data);
		$.ajax({
			url: base_url + '/backend/store/cuti/edit_cuti2',
			type: 'POST',
			data: data,
		})
		
		.done(function(data) {
			$('.loading').addClass('hide');
			$.alert({
				title: 'Success!',
				type: 'green',
				content: 'Thank you!',
			});
			window.location.href = "/backend/cuti/data_cuti";
		})
		.fail(function() {
			$('.loading').addClass('hide');
			$.alert({
				title: 'Alert!',
				type: 'red',
				content: 'Please try again',
			});
		});
	});
}

function editdatalembur($id){
	$('.fld' + $id).removeAttr('readonly');
	$('.btn' + $id).hide();
//	var fields ="<div><div class='input-group date col-md-12' data-provide='datepicker'><input type='text' id='tgl_lembur_awal" + $id + "' name='tgl_lembur_awal" + $id + "' placeholder='Tanggal Lembur' class='form-control datecalendar'><div class='input-group-addon'><span class='glyphicon glyphicon-th'></span></div></div><br><div class='input-group col-md-6'><input class='form-control timeselector jam_lembur_awal[]' id='jam_lembur_awal[]' name='jam_lembur_awal[]' type='time' /><span class='input-group-addon add-on'><i class='icon-time'></i></span></div><div class='input-group col-md-6'><input class='form-control timeselector jam_lembur_akhir[]' id='jam_lembur_akhir[]' name='jam_lembur_akhir[]' type='time' /><span class='input-group-addon add-on'><i class='icon-time'></i></span></div><br><br><br><div class='col-md-12'><textarea name='keterangan_lembur[]' id='keterangan_lembur[]' placeholder='Keterangan Lembur' class='form-control keterangan_lembur[]' rows='3' ></textarea></div><br><div class='col-md-12'><a href='#' class='btn btn-danger'  onclick='hapusElemen(\"#srow" + idf + "\"); return false;'>Hapus</a></div></div><br>";
	var editbtn = '<button class="btn btn-info btn' + $id + '" onclick="editdatalembur({{$data->kd}})" ><i class="icon-ok"></i>Edit</button>';
	var savebtn = '<button class="btn btn-success sv' + $id + '" onclick="" ><i class="icon-ok"></i>Ubah</button>';
	var cancelbtn = '<button class="btn btn-danger cncl' + $id + '" onclick="" ><i class="icon-ok"></i>Batal</button>';
	$('#div-btn' + $id).html(savebtn + cancelbtn);
	$('.cncl' + $id).click(function(){
		$('#div-btn' + $id).html(editbtn);
		$('.fld' + $id).attr('readonly');
	});
	$('.sv' + $id).click(function(){
		$('.loading').removeClass('hide');
		var id = $id;
		var tgl_lembur_awal = $('#tgl_lembur_awal' + $id).val();
		var tgl_lembur_akhir = $('#tgl_lembur_akhir' + $id).val();
		var jam_lembur_awal = $('#jam_lembur_awal' + $id).val();
		var jam_lembur_akhir = $('#jam_lembur_akhir' + $id).val();
		var keterangan = $('#keterangan_lembur' + $id).val();
		data = {
			'_token': token,
			id : id,
			tgl_lembur_awal : tgl_lembur_awal,
			tgl_lembur_akhir : tgl_lembur_akhir,
			jam_lembur_awal : jam_lembur_awal,
			jam_lembur_akhir : jam_lembur_akhir,
			keterangan : keterangan
		}
		$.ajax({
			url: base_url + '/backend/store/lembur/edit_lembur',
			type: 'POST',
			data: data,
		})
		.done(function(data) {
			$('.loading').addClass('hide');
			$.alert({
				title: 'Success!',
				type: 'green',
				content: 'Thank you!',
			});
			window.location.href = "/backend/lembur/data_lembur";
		})
		.fail(function() {
			alert(id + tgl_lembur_awal + tgl_lembur_akhir + jam_lembur_awal);
			$('.loading').addClass('hide');
			$.alert({
				title: 'Alert!',
				type: 'red',
				content: 'Please try again',
			});
		});
	});
}

function editdataijin(){
	$('.loading').removeClass('hide');
	var id = $('#id').val();
	var tgl_ijin_awal = $('#tgl_ijin_awal').val();
	var tgl_ijin_akhir = $('#tgl_ijin_akhir').val();
	var jam_ijin_awal = $('#jam_ijin_awal').val();
	var jam_ijin_akhir = $('#jam_ijin_akhir').val();
	var keterangan = $('#keterangan_ijin').val();
	var tindak_lanjut = $("input[name='tindak_lanjut']:checked").val();
	data = {
		'_token': token,
		id : id,
		tgl_ijin_awal : tgl_ijin_awal,
		tgl_ijin_akhir : tgl_ijin_akhir,
		jam_ijin_awal : jam_ijin_awal,
		jam_ijin_akhir : jam_ijin_akhir,
		keterangan : keterangan,
		tindak_lanjut : tindak_lanjut
	}
	$.ajax({
		url: base_url + '/backend/store/ijin/edit_ijin',
		type: 'POST',
		data: data,
	})
	.done(function(data) {
		$('.loading').addClass('hide');
		$.alert({
			title: 'Success!',
			type: 'green', 	
			content: 'Thank you!',
		});
		window.location.href = "/backend/ijin/data_ijin";
	})
	.fail(function() {
		$('.loading').addClass('hide');
		$.alert({
			title: 'Alert!',
			type: 'red',
			content: 'Please try again',
		});
	});
}


function getdatalembur(){
	$('.loading').removeClass('hide');
	var nama_karyawan = $('#nama_karyawan').val();
	var dept_id = $('#kd_divisi').val();
	var start_date = $('#start-date').val();
	var end_date = $('#end-date').val();
	var head = '<br><br><div class="table-responsive"><div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info"><thead><tr role="row"><th  >No</th><th  >Action</th><th  >Status</th><th  >NIK</th><th  >Nama</th><th  >Dept / Unit</th><th  >Tgl Lembur Awal</th><th  >Tgl Lembur Akhir</th><th  >Keterangan</th></tr></thead><tbody>';
	var foot = '</tbody></table></div></div></div>';
	data = {
		'_token': token,
		nama_karyawan : nama_karyawan,
		dept_id : dept_id,
		start_date : start_date,
		end_date : end_date
	}
	$.ajax({
		url: base_url + '/backend/lembur/data_lembur_table',
		type: 'POST',
		data: data,
		success: function (data) {
			$('.loading').addClass('hide');	
			$('#datalembur').html(head + data + foot);
		}
	});
}

function getdataijin(){
	$('.loading').removeClass('hide');
	var nama_karyawan = $('#nama_karyawan').val();
	var dept_id = $('#kd_divisi').val();
	var start_date = $('#start-date').val();
	var end_date = $('#end-date').val();
	var head = '<br><br><div class="table-responsive"><div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info"><thead><tr role="row"><th  >No</th><th  >Action</th><th  >Status</th><th  >NIK</th><th  >Nama</th><th  >Dept / Unit</th><th  >Tgl Ijin Awal</th><th  >Tgl Ijin Akhir</th><th  >Keterangan</th></tr></thead><tbody>';
	var foot = '</tbody></table></div></div></div>';
	data = {
		'_token': token,
		nama_karyawan : nama_karyawan,
		dept_id : dept_id,
		start_date : start_date,
		end_date : end_date
	}
	$.ajax({
		url: base_url + '/backend/ijin/data_ijin_table',
		type: 'POST',
		data: data,
		success: function (data) {
			$('.loading').addClass('hide');	
			$('#dataijin').html(head + data + foot);
		}
	});
}
