<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="icon" type="image/png" sizes="64x64" href="{{url('images/MASTERMAUMAU.png')}}">
    <title>Dashboard - Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/form-login.css" rel="stylesheet">
    
</head>
<body class="hold-transition login-page">
    @yield('content')
	
	
	

  </body>
</html>
