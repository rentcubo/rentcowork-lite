<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{Setting::get('site_name')}}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/Ionicons/css/ionicons.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('admin-assets/dist/css/AdminLTE.min.css')}}">

	<link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{asset('admin-assets/dist/css/skins/_all-skins.min.css')}}">
	<!-- Morris chart -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/morris.js/morris.css')}}">
	<!-- jvectormap -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/jvectormap/jquery-jvectormap.css')}}">
	<link rel="stylesheet" href="{{ asset('admin-assets/node_modules/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
	<!-- Date Picker -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">

	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/select2/dist/css/select2.css')}}">

	<link rel="stylesheet" href="{{asset('admin-assets/bower_components/select2/dist/css/select2.min.css')}}">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{asset('admin-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link rel="icon" href="{{Setting::get('site_icon')}}" type="image/png" sizes="16x16">

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	@yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	@include('layouts.admin.header')

	@include('layouts.admin.sidebar')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		
		 <section class="content-header">
                <h1>@yield('content-header')<small>@yield('content-sub-header')</small></h1>
                <ol class="breadcrumb">@yield('breadcrumb')</ol>
            </section>
		
		@yield('content')

	</div>
	
	@include('layouts.admin.footer')
	
	<!-- Control Sidebar -->
	
	<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

@include('layouts.admin.scripts')

</body>
</html>
