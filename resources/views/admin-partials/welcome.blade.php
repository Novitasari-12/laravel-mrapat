{{-- 
@include('admin-partials.header')

@include('admin-partials.settings')
@include('admin-partials.breadcrumbs')


@include('admin-partials.footer')
 --}}


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
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title> {{env('APP_NAME')}} </title>

  @include('admin-partials.style')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    @include('admin-partials.navbar-left-menu')

    <!-- SEARCH FORM -->
    @include('admin-partials.navbar-search')

    <!-- Right navbar links -->
    @include('admin-partials.navbar-right-menu')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @include('admin-partials.sidebar-logo')

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @include('admin-partials.sidebar-user')

      <!-- Sidebar Menu -->
      @include('admin-partials.sidebar')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin-partials.content-header')
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		    @include('alert.alert')
        @yield('content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('admin-partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('admin-partials.script')
</body>
</html>
