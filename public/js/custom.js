$(document).ready(function() {
	$('.datepicker').datepicker({
          format: 'dd-mm-yyyy',
          orientation: "bottom"
      });
	// $('.datetimepicker').daterangepicker();
	$('.datetimepicker').daterangepicker({
		format: 'DD/MM/YYYY' 
	});

	$('.timepicker').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false
    });

	$(".chzn-select").chosen();

	//REAL TIME GRAPH FUNCTION 
	$(function () {

	    // We use an inline data source in the example, usually data would
	    // be fetched from a server

	    var data = [],
	        totalPoints = 300;

	    function getRandomData() {

	        if (data.length > 0)
	            data = data.slice(1);

	        // Do a random walk

	        while (data.length < totalPoints) {

	            var prev = data.length > 0 ? data[data.length - 1] : 50,
	                y = prev + Math.random() * 10 - 5;

	            if (y < 0) {
	                y = 0;
	            } else if (y > 100) {
	                y = 100;
	            }

	            data.push(y);
	        }

	        // Zip the generated y values with the x values

	        var res = [];
	        for (var i = 0; i < data.length; ++i) {
	            res.push([i, data[i]])
	        }

	        return res;
	    }

	    // Set up the control widget

	    var updateInterval = 30;
	    $("#updateInterval").val(updateInterval).change(function () {
	        var v = $(this).val();
	        if (v && !isNaN(+v)) {
	            updateInterval = +v;
	            if (updateInterval < 1) {
	                updateInterval = 1;
	            } else if (updateInterval > 2000) {
	                updateInterval = 2000;
	            }
	            $(this).val("" + updateInterval);
	        }
	    });

	    var plot = $.plot("#placeholderRT", [getRandomData()], {
	        series: {
	            shadowSize: 0	// Drawing is faster without shadows
	        },
	        yaxis: {
	            min: 0,
	            max: 100
	        },
	        xaxis: {
	            show: false
	        }
	    });

	    function update() {

	        plot.setData([getRandomData()]);

	        // Since the axes don't change, we don't need to call plot.setupGrid()

	        plot.draw();
	        setTimeout(update, updateInterval);
	    }

	    update();

	});
	//END REAL TIME GRAPH FUNCTION
	$("#checkAll").change(function () {
	    $("input:checkbox").prop('checked', $(this).prop("checked"));
	});
	
});

function checkAll(){
	$('.checkbox').attr( 'checked', true );
}

function check(){
	if(false == $("#select_all").prop("checked")){ //if this item is unchecked
        $("#select_all").attr('checked', false); //change "select all" checked status to false
    }

    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
      $("#select_all").attr('checked', true);
    }
}

function getDays(){
	var month = $('select[name="month"]').val();
	var year = $('select[name="year"]').val();
	var dept_id = $('select[name="dept_id"]').val();
	var lastDay = new Date(year, month, 0).getDate();
	$('.loading').removeClass('hide');
	var data = {
		month: month,
		year: year,
		dept_id: dept_id,
		lastDay: lastDay
	}
	$.ajax({
		url: '/backend/get/shift/table',
		type: 'GET',
		data: data,
	})
	.done(function(msg) {
		$('.loading').addClass('hide');
		// console.log(msg);return;
		$("#shiftTable").html(msg);
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

function getDaysNonShift(){
	var month = $('select[name="month"]').val();
	var year = $('select[name="year"]').val();
	var dept_id = $('select[name="dept_id"]').val();
	var lastDay = new Date(year, month, 0).getDate();
	$('.loading').removeClass('hide');
	var data = {
		month: month,
		year: year,
		dept_id: dept_id,
		lastDay: lastDay
	}
	$.ajax({
		url: '/backend/get/nonShift/table',
		type: 'GET',
		data: data,
	})
	.done(function(msg) {
		$('.loading').addClass('hide');
		// console.log(msg);return;
		$("#nonshiftTable").html(msg);
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

function saveScheduleShift(employees){
	var month = $('select[name="month"]').val();
	var year = $('select[name="year"]').val();
	var dept_id = $('select[name="dept_id"]').val();
	var lastDay = $('#lastDay').val();
	var value=[];
	var z = 0;
	$.confirm({
		icon: 'fa fa-warning',
		title: 'Confirm!',
	    content: 'Have you done ?',
	    type: 'red',
	    buttons: {
	        specialKey: {
	            text: 'Done',
	            btnClass: 'btn-success',
	            action: function(){
	            	$('.loading').removeClass('hide');
	                for (var i = 0; i < employees.length; i++) {
	                	var data=[];
	                	var x=0;
	                	for (var y = 1; y <=lastDay; y++) {
	                		var getID=employees[i].id+'&'+y;
	                		getValue = $("select[name='"+getID+"']").val();
	                		if(getValue != null){
	                			var split = getValue.split("-");
	                			var scheduleId = split[1];
	                			var empDay = split[0].split("&");
	                			var empID = empDay[0];
	                			var day = empDay[1];
	                			var date = year+'-'+month+'-'+day;
	                			data[x++] = {
	                				dept_id:dept_id,
	                				date:date,
	                				scheduleId:scheduleId,
	                				empID:empID
	                			}
	                		}
	                	}
	                	value[z++] = data;
	                }
	                values = value;
	                data = {		
	                	_token:token,
	                	values:values,
	                	month:month,
	                	year:year,
	                	lastDay:lastDay,
	                	dept_id:dept_id
	                };
	                // console.log(data);return;
	                $.ajax({
	                	url: base_url+'/backend/store/shift/schedule',
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
	        },
	        alphabet: {
	            text: 'Not yet',
	            btnClass: 'btn-red',
	            action: function(){
	            	$('.loading').addClass('hide');
	            }
	        }
	    }
	});
} 

function saveScheduleNonShift(employees){
	var month = $('select[name="month"]').val();
	var year = $('select[name="year"]').val();
	var dept_id = $('select[name="dept_id"]').val();
	var lastDay = $('#lastDay').val();
	var value=[];
	var z = 0;
	$.confirm({
		icon: 'fa fa-warning',
		title: 'Confirm!',
	    content: 'Have you done ?',
	    type: 'red',
	    buttons: {
	        specialKey: {
	            text: 'Done',
	            btnClass: 'btn-success',
	            action: function(){
	            	$('.loading').removeClass('hide');
	                for (var i = 0; i < employees.length; i++) {
	                	var data=[];
	                	var x=0;
	                	for (var y = 1; y <=lastDay; y++) {
	                		if(y<=9){
	                			var paramTgl = year+'-'+month+'-0'+y;
	                		}else{
	                			var paramTgl = year+'-'+month+'-'+y;
	                		}
	                		var getID=employees[i].id+'&'+paramTgl;
	                		getValue = $("select[name='"+getID+"']").val();
	                		if(getValue != null){
	                			var split = getValue.split("&");
	                			var nik = split[0];
	                			var date = split[1];
	                			var scheduleCode = split[2];
	                			data[x++] = {
	                				dept_id:dept_id,
	                				date:date,
	                				scheduleCode:scheduleCode,
	                				nik:nik
	                			}
	                		}
	                	}
	                	value[z++] = data;
	                }
	                values = value;
	                data = {		
	                	_token:token,
	                	values:values,
	                	month:month,
	                	year:year,
	                	lastDay:lastDay,
	                	dept_id:dept_id
	                };
	                $.ajax({
	                	url: base_url+'/backend/store/nonshift/schedule',
	                	type: 'POST',
	                	data: data,
	                })
	                .done(function(data) {
	                	$('.loading').addClass('hide');
	                	// console.log(data);return;
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
	        },
	        alphabet: {
	            text: 'Not yet',
	            btnClass: 'btn-red',
	            action: function(){
	            	// $.alert({
	            	//     title: 'Alert!',
	            	//     type: 'red',
	            	//     content: 'Please make an interview with this talent!',
	            	// });
	            	$('.loading').addClass('hide');
	            }
	        }
	    }
	});
}

function editScheduleShift(employee_id){
	$('.optHour').prop('disable',false);
	$('.optHour').removeClass('not-active');
	$('#btnsaveScheduleShift').removeClass('hide');
	$('#btneditScheduleShift').addClass('hide');
}

function editKaryawan(){
	$('.editKar').removeClass('not-active');
	$('.btneditKar').addClass('hide');
}

function getTukarJadwal(){
	$('.loading').removeClass('hide');
	var dept_id = $('select[name="dept_id"]').val();
	$.ajax({
		url: '/backend/get/table/rubah/jadwal',
		type: 'GET',
		data: {dept_id: dept_id},
	})
	.done(function(msg) {
		$('.loading').addClass('hide');
		$("#indexTableRubahJadwal").html(msg);
	})
	.fail(function() {
		console.log("error");
	});
}

function rubahJadwal(){
	var karyFrom = $('select[name="karyFrom"]').val();
	var karyTo = $('select[name="karyTo"]').val();
	var hourIdFrom = $('select[name="hourIdFrom"]').val();
	var hourIdTo = $('select[name="hourIdTo"]').val();
	var dateFrom = $('#dateFrom').val();
	var dateTo = $('#dateTo').val();
	var dept_id = $('select[name="dept_id"]').val();
	data = {		
    	_token:token,
    	karyFrom:karyFrom,
    	karyTo:karyTo,
    	dateFrom:dateFrom,
    	dateTo:dateTo,
    	hourIdTo:hourIdTo,
    	hourIdFrom:hourIdFrom,
    	dept_id:dept_id
    };
	$('.loading').removeClass('hide');
	$.ajax({
		url: '/backend/post/table/rubah/jadwal',
		type: 'POST',
		data: data,
	})
	.done(function(data) {
		$('.loading').addClass('hide');
		if (data = "Success") {
			$.alert({
			    title: 'Success!',
			    type: 'green',
			    content: 'Thank you!',
			});
			location. reload(true);
		}else{
			$.alert({
			    title: 'Alert!',
			    type: 'red',
			    content: 'Please try again',
			});
		}
		
	});
}

function tipeReportAbsen(){
	var value = $('select[name="tipe"]').val();
	if (value == 2) {
		$('#tahun').removeClass('hide');
		$('#periode').addClass('hide');
	}else{
		$('#tahun').addClass('hide');
		$('#periode').removeClass('hide');
	}
}

function periodeReportAbsensi(){
	var value = $('select[name="periode"]').val();
	if(value == 1){
		$('#month').removeClass('hide');
		$('#year').removeClass('hide');
		$('#daterange').addClass('hide');
	}else{
		$('#month').addClass('hide');
		$('#year').addClass('hide');
		$('#daterange').removeClass('hide');

	}
}

function deptReportAbsensi(){
	var value = $('select[name="berdasarkan"]').val();
	$('.loading').removeClass('hide');
	if (value == 1) {
		$('#department').removeClass('hide');
		$('#karyawan').addClass('hide');
		$.ajax({
			url: '/backend/getDepartment',
			type: 'GET',
		})
		.done(function(msg) {
			$('.loading').addClass('hide');
			$("#department").html(msg);
		})
		.fail(function() {
			$('.loading').addClass('hide');
			console.log("error");
		});
		
	}else if(value == 2){
		$('.loading').addClass('hide');
		$('#department').addClass('hide');
		$('#karyawan').addClass('hide');
	}else{
		$('.loading').addClass('hide');
		$('#department').addClass('hide');
		$('#karyawan').removeClass('hide');
		// $('.chosen-container').setAttribute("style", "width:100%!important;");
	}
}

function getDataReportAbsensi(){
	var tipe = $('select[name="tipe"]').val();
	var berdasarkan = $('select[name="berdasarkan"]').val();
	var idKar = $('select[name="idKar"]').val();
	if (berdasarkan == 1) { //per department
		var department = $('select[name="department"]').val();
	}else{
		var department = 'all';
	}
	$('.loading').removeClass('hide');
	if (tipe == 1 || tipe == 3) { //Detail Perbulan
		var periode = $('select[name="periode"]').val();
		if (periode == 1) { //perbulan
			var month = $('select[name="month"]').val();
			var year = $('select[name="year"]').val();
			data = {
				_token:token,
				tipe:tipe,
				berdasarkan:berdasarkan,
				department:department,
				periode:periode,
				month:month,
				idKar:idKar,
				year:year,
			}
		}
		else{
			var daterange = $('input[name="daterange"]').val();
			var split = daterange.split(" - ");
			var dateFrom = split[0];
			var dateTo = split[1];
			data = {
				_token:token,
				tipe:tipe,
				berdasarkan:berdasarkan,
				department:department,
				periode:periode,
				dateFrom:dateFrom,
				idKar:idKar,
				dateTo:dateTo,
			}	
		}
		$.ajax({
			url: '/backend/getDataReportAbsensi',
			type: 'POST',
			data: data,
		})
		.done(function(msg) {
			$('.loading').addClass('hide');
			// console.log(msg);return;
			$("#reportAbsensi").html(msg);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}else{
		var tahun = $('select[name="tahun"]').val();
		data = {
			_token:token,
			tipe:tipe,
			berdasarkan:berdasarkan,
			department:department,
			tahun:tahun,
			idKar:idKar
		}
		$.ajax({
			url: '/backend/getDataReportAbsensi',
			type: 'POST',
			data: data,
		})
		.done(function(msg) {
			$('.loading').addClass('hide');
			// console.log(msg);return;
			$("#reportAbsensi").html(msg);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
}

function getDataReportUMUT(){
	var periode = $('select[name="periode"]').val();
	var idKar = $('select[name="idKar"]').val();
	if (periode == 1) { //perbulan
		var month = $('select[name="month"]').val();
		var year = $('select[name="year"]').val();
		data = {
			_token:token,
			periode:periode,
			month:month,
			idKar:idKar,
			year:year,
		}
	}
	else{
		var daterange = $('input[name="daterange"]').val();
		var split = daterange.split(" - ");
		var dateFrom = split[0];
		var dateTo = split[1];
		data = {
			_token:token,
			periode:periode,
			idKar:idKar,
			dateFrom:dateFrom,
			dateTo:dateTo,
		}	
	}
	$('.loading').removeClass('hide');
	// console.log(data);return;
	$.ajax({
		url: '/backend/getDataReportUmut',
		type: 'POST',
		data: data,
	})
	.done(function(msg) {
		$('.loading').addClass('hide');
		// console.log(msg);return;
		$("#reportUMUT").html(msg);
	})
	.fail(function() {
		console.log("error");
		$.alert({
		    title: 'Alert!',
		    type: 'red',
		    content: 'Please try again',
		});
	});
}

// function exportUMUT(){
// 	var arr = [];
// 	var i =0;
//        $('#umut:checked').each(function () {
//            arr[i++] = $(this).val();
//        });
// 	var periode = $('select[name="periode"]').val();
// 	if (periode == 1) { //perbulan
// 		var month = $('select[name="month"]').val();
// 		var year = $('select[name="year"]').val();
// 		data = {
// 			_token:token,
// 			idkar:arr,
// 			periode:periode,
// 			month:month,
// 			year:year,
// 		}
// 		// location.href = "/backend/exportumut/"+arr+"/"+periode+"/"+month+"/"+year;
// 		// location.href = "/backend/exportumut?var1=["+arr+"]&var2="+periode+"&var3="+month+"&var4="+year;
// 	}
// 	else{
// 		var daterange = $('input[name="daterange"]').val();
// 		var split = daterange.split(" - ");
// 		var dateFrom = split[0];
// 		var dateTo = split[1];
// 		data = {
// 			_token:token,
// 			idkar:arr,
// 			periode:periode,
// 			dateFrom:dateFrom,
// 			dateTo:dateTo,
// 		}	
// 		// location.href = "/backend/exportumut/"+arr+"/"+periode+"/"+dateFrom+"/"+dateTo;
// 		// location.href = "/backend/exportumut?var1=["+arr+"]&var2="+periode+"&var3="+dateFrom+"&var4="+dateTo;
// 	}
// 		// location.href = "/backend/exportumut?var1=["+arr+"]&var2="+periode;
// 	$.ajax({
// 		url: '/backend/exportumut',
// 		type: 'POST',
// 		data: data,
// 		responseType: 'arraybuffer',
// 		headers: {'Content-Type': 'application/x-www-form-urlencoded'}
// 	})
// 	.done(function(msg) {
// 		// $("#exportUMUT").html(msg);
// 		var blob = new Blob([msg], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
// 		// saveAs(blob, "as.xlsx");
// 	})
// 	.fail(function() {
// 		console.log("error");
// 	})
// 	.always(function() {
// 		console.log("complete");
// 	});
	
// }

function getGridKaryawan(){
	var dept_id = $('select[name="dept_id"]').val();
	$('.loading').removeClass('hide');
	data = {
		_token:token,
		dept_id:dept_id,
	}
	$.ajax({
		url: '/backend/data/karyawan',
		type: 'POST',
		data: data,
	})
	.done(function(msg) {
		$('.loading').addClass('hide');
		$("#semuakaryawan").remove();
		$("#karyawan").html(msg);
	})
	.fail(function() {
		console.log("error");
		$.alert({
		    title: 'Alert!',
		    type: 'red',
		    content: 'Please try again',
		});
	});
}

function search(type){
	if (type == 'karyawan') {
		var dept_id = $('select[name="dept_id"]').val();
		var content = $("input[name=content]").val();
		$('.loading').removeClass('hide');
		data = {
			_token:token,
			dept_id:dept_id,
		}
		$.ajax({
			url: '/backend/karyawan/search',
			type: 'POST',
			data: data,
		})
		.done(function(msg) {
			$('.loading').addClass('hide');
			$("#karyawan").html(msg);
		})
		.fail(function() {
			console.log("error");
			$.alert({
			    title: 'Alert!',
			    type: 'red',
			    content: 'Please try again',
			});
		});
	}
}

function nonaktif(id){
	var tgl_resign = $("#tgl_resign-"+id).val();
	$('.loading').removeClass('hide');
	data = {
		_token:token,
		tgl_resign:tgl_resign,
	}
	$.ajax({
		url: '/backend/karyawan/nonaktif/'+id,
		type: 'POST',
		data: data,
	})
	.done(function(data) {
		$('.loading').addClass('hide');
		$.alert({
		    title: 'Success!',
		    type: 'green',
		    content: 'Karyawan Berhasil Dinonaktifkan',
		});
		location. reload(true);
	})
	.fail(function() {
		console.log("error");
		$.alert({
		    title: 'Alert!',
		    type: 'red',
		    content: 'Please try again',
		});
	});
}

function chartKehadiran(){
	var department = $('select[name="department"]').val();
	var date = $('input[name="date"]').val();
	$('.loading').removeClass('hide');
	data = {
		dept_id:department,
		date:date
	}
	$.ajax({
		url: '/',
		type: 'GET',
		data: data,
	})
	.done(function(data) {
		$('.loading').addClass('hide');
		var label = data['label'];
		var val = data['val'];
		var empslabel = data['empslabel'];
		var empsval = data['empsval'];
		$('#kehadiranperhari').remove();
		$('#divkehadiranperhari').html('<canvas id="kehadiranperhari"></canvas>');
		var kehadiranperhari = document.getElementById("kehadiranperhari");
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


		$('#kehadiranperbulan').remove();
		$('#divkehadiranperbulan').html('<canvas id="kehadiranperbulan"></canvas>');
		var ctx = document.getElementById("kehadiranperbulan");

		var myLineChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: label,
		        datasets: [{ 
		            data: val,
		            label: "Kehadiran",
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
	            },
	        }
		});
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
};



function chartCuti(){
	var department = $('select[name="department"]').val();
//	var date = $('input[name="date"]').val();
	$('.loading').removeClass('hide');
	data = {
		dept_id:department
	}
	$.ajax({
		url: '/',
		type: 'GET',
		data: data,
	})
	.done(function(data) {
		$('.loading').addClass('hide');
		var labelcutiharian = data['labelcutiharian'];
		var valuecutiharian = data['valuecutiharian'];
		var labelcutibulanan= data['labelcutibulanan'];
		var valuecutibulanan = data['valuecutibulanan'];
		var persencutihari = data['persencutihari'];
		var persentidakcutihari = data['persentidakcutihari'];
		var persentasecutiharianchart = [persencutihari, persentidakcutihari];
		var persencutibulan = data['persencutibulan'];
		var persentidakcutibulan = data['persentidakcutibulan'];
		var persentasecutibulananchart = [persencutibulan, persentidakcutibulan];

		
		$('#rankcutiperhari').remove();
		$('#divrankcutiperhari').html('<canvas id="rankcutiperhari"></canvas>');
		var rankcutiperhari = document.getElementById("rankcutiperhari");
		var myLineChart = new Chart(rankcutiperhari, {
		    type: 'line',
		    data: {
		        labels: labelcutiharian,
		        datasets: [{ 
		            data: valuecutiharian,
		            label: "Jumlah Karyawan Per Level",
		            backgroundColor: "#c2f442",
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


		$('#rankcutiperbulan').remove();
		$('#divrankcutiperbulan').html('<canvas id="rankcutiperbulan"></canvas>');
		var rankcutiperbulan = document.getElementById("rankcutiperbulan");

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
	                    stacked: true
	                }]
	            },
	        }
		});


		$('#persentasecutihari').remove();
		$('#divpersentasecutihari').html('<canvas id="persentasecutihari"></canvas>');
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


		
		$('#persentasecutibulan').remove();
		$('#divpersentasecutibulan').html('<canvas id="persentasecutibulan"></canvas>');
		var myLineChart = new Chart(persentasecutibulan, {
			type: 'pie',
			data: {
				labels:['Cuti Per Bulan', 'Hadir Per Bulan'],
				datasets: [{ 
					data: persentasecutibulananchart,
					label: "Rank Cuti Per Bulan",
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
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
};


function numbersonly(ini, e){
	if (e.keyCode>=49){
		if(e.keyCode<=57){
		a = ini.value.toString().replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
		ini.value = tandaPemisahTitik(b);
		return false;
		}
		else if(e.keyCode<=105){
			if(e.keyCode>=96){
				//e.keycode = e.keycode - 47;
				a = ini.value.toString().replace(".","");
				b = a.replace(/[^\d]/g,"");
				b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
				ini.value = tandaPemisahTitik(b);
				//alert(e.keycode);
				return false;
				}
			else {return false;}
		}
		else {
			return false; }
	}else if (e.keyCode==48){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==95){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==8 || e.keycode==46){
		a = ini.value.replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = b.substr(0,b.length -1);
		if (tandaPemisahTitik(b)!=""){
			ini.value = tandaPemisahTitik(b);
		} else {
			ini.value = "";
		}
		
		return false;
	} else if (e.keyCode==9){
		return true;
	} else if (e.keyCode==17){
		return true;
	} else {
		//alert (e.keyCode);
		return false;
	}

}

function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");
	b=b.replace("-","");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		 j = j + 1;
		 if (((j % 3) == 1) && (j != 1)){
		   c = b.substr(i-1,1) + "." + c;
		 } else {
		   c = b.substr(i-1,1) + c;
		 }
	}
	if (_minus) c = "-" + c ;
	return c;
}

function bersihPemisah(ini){
	a = ini.toString().replace(".","");
	//a = a.replace(".","");
	return a;
}

function addcutidate(kode){
	var nik = $("#nik").val();
	splitkode = kode.split("-");
	var kode_jenis_cuti = splitkode[0];
	var counter = parseInt(splitkode[1]) + 1;
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
	}else{
		var tipe_cuti = 'Cuti Sakit';
	}
	var jenis_cuti_detail = kode_jenis_cuti.substr(1, 2);
	var tgl_cuti_awal = $(".tgl_cuti_awal"+jenis_cuti_detail).val();
	var tgl_cuti_akhir = $(".tgl_cuti_akhir"+jenis_cuti_detail).val();
	var count = kode_jenis_cuti+counter;
	var periodecuti = '<div class="col-lg-12 div'+jenis_cuti_detail+'" id="'+kode_jenis_cuti+'-'+counter+'">'+
							'<div class="col-lg-4 '+jenis_cuti_detail+'" id="">'+
								'<div class="form-group">'+
									'<label>Start Date '+tipe_cuti+'</label>'+
									'<div class="input-group date" data-provide="datepicker">'+
										'<input type="text" id="datefrom-'+count+'" name="tgl_cuti_awal_'+kode_jenis_cuti+'[]" class="form-control tgl_cuti_awal'+count+'">'+
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
										'<input type="text" id="dateto-'+count+'" name="tgl_cuti_akhir_'+kode_jenis_cuti+'[]" class="form-control tgl_cuti_akhir'+count+'" onchange="hitungcuti(\'' + count + '\',\''+kode_jenis_cuti+'\',\''+nik+'\')">'+
										'<div class="input-group-addon">'+
											'<span class="glyphicon glyphicon-th"></span>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-2">'+
								'<div class="form-group input-group">'+
									'<label>Jumlah Hari</label>'+
									'<input id="jumlah_hari'+count+'" name="jumlah_hari_'+kode_jenis_cuti+'[]" class="form-control '+kode_jenis_cuti+'">'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-2">'+
								'<div class="btn-group" role="group">'+
									'<label>Action&nbsp</label>'+
									'<button type="button" onclick="addcutidate(\''+kode_jenis_cuti+'-'+counter+'\')" class="btn btn-info btn-md"><i class="icon-plus"></i></button>'+
									'<button type="button" onclick="deletecutidate(\''+kode_jenis_cuti+'-'+counter+'\')" class="btn btn-danger btn-md"><i class="icon-remove"></i></button>'+
								'</div>'+
							'</div>'+
						'</div>';
	$('#periode_cuti').append(periodecuti);
}

function deletecutidate(id){
	var div = "#"+id+"";
	console.log(div);
	$(div).remove();
	return false;
}