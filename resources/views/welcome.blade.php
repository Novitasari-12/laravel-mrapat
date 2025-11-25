{{-- <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Auth</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin-lte')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/admin-lte')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin-lte')}}/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
    <a href="/"> @yield('title') </a>

    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">


        @yield('content')

        <!-- /.social-auth-links -->
      <hr/>
        <a href=" {{asset('android_app/MRAPAT.apk')}} " class="btn btn-xs btn-info col-md-12"> DOWNLOAD APLIKASI ABSENSI DISINI </a>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{asset('assets/admin-lte')}}/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('assets/admin-lte')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('assets/admin-lte')}}/dist/js/adminlte.min.js"></script>

  </body>
</html> --}}


<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title> {{env('APP_NAME')}} </title>

  @include('user-partials.style')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="/" class="navbar-brand">
        <img src="{{asset('assets/admin-lte')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> {{env('APP_NAME')}} </span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        @include('user-partials.navbar-left')

        <!-- SEARCH FORM -->
        @include('user-partials.navbar-search')
      </div>

      <!-- Right navbar links -->
      @include('user-partials.navbar-right')
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('user-partials.content-header')
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        @include('alert.alert')
      </div>
      @yield('content')
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  @include('user-partials.footer')
</div>
<!-- ./wrapper -->

@include('user-partials.script')
</body>
</html>

