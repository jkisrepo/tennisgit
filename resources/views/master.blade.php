<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title ?? 'TENNiSWHIZ'}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('dist/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('dist/css/ionicons.min.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- Theme skin-->
    <link rel="stylesheet" href="{{asset('dist/css/skins/skin-red.min.css')}}">

    <!-- Morris charts -->
    <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">

    <link rel="stylesheet" href="{{asset('dist/build/css/bootstrap-datetimepicker.min.css')}}" />

    <link rel="stylesheet" href="{{asset('dist/build/css/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet" href="{{asset('chosen/chosen-bs.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
    @yield('css')
</head>

<div class="modal fade in" id="confirm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>



<body class="hold-transition skin-red sidebar-mini">

    <div class="wrapper">

        <!-- Main Header -->
        @include('header')


        <!-- Main Sidebar -->
        @include('main_sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">


            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('footer')


        <!-- Contro@include('footer')
  l Sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    @javascript('base_url', url('/'))
    @javascript('success_strings', config("strings.success"))
    @javascript('warning_strings', config("strings.warning"))
    <!-- jQuery 2.2.0 -->
    <script src="{{asset('plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
    <script src="{{asset('dist/js/bootstrap-toggle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('dist/build/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('dist/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('chosen/chosen.jquery.min.js')}}"></script>
    <script src="{{asset('dist/js/jquery-ui.min.js')}}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/app.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/master.js')}}"></script>
    @yield('js')
</body>

</html>
