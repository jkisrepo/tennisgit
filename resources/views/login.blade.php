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
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <style type="text/css">
        body {
            background-color: #FFF;

        }

        .login-page,
        .register-page {
            background-color: #FFF;
            background-image: url("{{asset('images/freetrial_light_hexes_v1.svg')}}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: left bottom;
        }

        .login-box-body,
        .register-box-body {
            border: 1px solid #ccc;
            box-shadow: 0px 3px 36px -6px rgba(0, 0, 0, 0.75);
            border-radius: 4px !important;
        }

        .login-box,
        .register-box {
            margin: 1% auto;
        }

        #forgot_password {
            color: #666;
        }

        button[type=submit] {
            border-radius: 4px !important;
        }

        .btn-danger:hover {
            border-color: transparent !important;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{url('/')}}">TENNiSWHIZ</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <h3 class="login-box-msg">Sign in to start your session</h3>
            @if(session('warning'))
            <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning!</strong> {{ session('warning') }}.
            </div>
            @endif
            @if(session('message'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ session('message') }}.
            </div>
            @endif
            <form action="{{ route('login') }}" method="post">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" required="" name="email" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" required="" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-md-8 col-sm-8">
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
                    </div>
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" style="float:right" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>
        </div>
        </form>

    </div>

    <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <div class="login-box">
        <div class="login-box-body">
            <h3 class="login-box-msg">Demo Credentials</h3>
            <div class="list-group">
                <a href="#" class="list-group-item">
                    <h5 class="list-group-item-heading">Admin</h5>
                    <p class="list-group-item-text">Email: admin@gmail.com</p>
                    <p class="list-group-item-text">Password: abc123</p>
                </a>
                <a href="#" class="list-group-item">
                    <h5 class="list-group-item-heading">Coach</h5>
                    <p class="list-group-item-text">Email: dummycoach@gmail.com</p>
                    <p class="list-group-item-text">Password: abc123</p>
                </a>
                <a href="#" class="list-group-item">
                    <h5 class="list-group-item-heading">Player</h5>
                    <p class="list-group-item-text">Email: dummyplayer@gmail.com</p>
                    <p class="list-group-item-text">Password: abc123</p>
                </a>
            </div>
        </div>

    </div>

    <!-- jQuery 2.2.0 -->
    <script src="{{asset('plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
</body>

</html>
