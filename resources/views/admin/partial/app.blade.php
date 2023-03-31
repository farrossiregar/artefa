<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/theme.css" />
    <link rel="stylesheet" href="/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="/assets/plugins/Font-Awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="/assets/plugins/chosen/chosen.min.css" />
	
	<link href="/assets/css/jquery-ui.css" rel="stylesheet" />	
    <script type="text/javascript">
      var base_url = "{{ url('/') }}";
      var token = "{{csrf_token()}}";
    </script>
    <!--END GLOBAL STYLES -->
    <!-- PAGE LEVEL STYLES -->
    <!-- <link href="/assets/css/layout2.css" rel="stylesheet" /> -->
    <link href="/assets/css/jquery-ui.css" rel="stylesheet" />
    <link href="/assets/plugins/flot/examples/examples.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/plugins/timeline/timeline.css" />
    <link rel="stylesheet" href="/css/loader.css" />
    <link rel="stylesheet" href="/css/custom.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/jquery-confirm-master/dist/jquery-confirm.min.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker-bs3.css" />
    <link href="/assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/plugins/uniform/themes/default/css/uniform.default.css" />
    <link rel="stylesheet" href="/assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
    <link rel="stylesheet" href="/assets/plugins/colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" href="/assets/plugins/tagsinput/jquery.tagsinput.css" />
    <link rel="stylesheet" href="/assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />    
    <!--  ADD INPUT FIELD  -->
    <!--script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"-->
    <!--  END ADD INPUT FIELD  -->

</head>
<body class="padTop53 " >
    <div id="wrap" >
        @include('admin.partial.header')
        <!-- MENU SECTION -->
        <div id="left" >
            @include('admin.partial.sidebar')
        </div>
        <!--END MENU SECTION -->

        <!--PAGE CONTENT -->
        <div id="content">
            <div class="loading hide"></div>
            @yield('content')
        </div>
    </div>

    <!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <div id="footer">
        <!-- <p>&copy;  binarytheme &nbsp;2014 &nbsp;</p> -->
    </div>
    <!--END FOOTER -->
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- GLOBAL SCRIPTS -->
    <script src="/assets/plugins/jquery-2.0.3.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
	<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script-->
    <!-- END GLOBAL SCRIPTS -->

    <!-- PAGE LEVEL SCRIPTS -->
    
	 
	
    <script src="/js/custom.js"></script>
    <script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
    <script src="/js/js_mercedes.js"></script>
    <!--script src="/assets/js/formsInit.js"></script-->
	<script>
    //    $(function () { formInit(); });

    </script>

    <script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="{{ url('/') }}/assets/plugins/jquery-confirm-master/dist/jquery-confirm.min.js"></script>
    
    <script src="/assets/plugins/timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/plugins/daterangepicker/moment.min.js"></script>
    
    <!-- GRAFIK KARYAWAN AKTIF-NON AKTIF -->
    <!--script src="/assets/plugins/flot/jquery.flot.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.time.js"></script>
    <script  src="/assets/plugins/flot/jquery.flot.stack.js"></script>
    <script src="/assets/js/pie_chart.js"></script-->

    <script src="/assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="/assets/plugins/morris/morris.js"></script>

    <script src="/assets/plugins/uniform/jquery.uniform.min.js"></script>
    <script src="/assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="/assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="/assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
</body>
</html>
