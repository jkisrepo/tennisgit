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
            <a href="#">TENNiSWHIZ</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Reset Password</p>
            @if(session('warning'))
            <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning!</strong> {{ session('warning') }}.
            </div>
            @endif
            <form action="{{ route('password.email') }}" method="post">
                <div class="form-group has-feedback">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required="" name="email" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit"
                            class="btn btn-primary btn-block btn-flat">{{ __('Send Password Reset Link') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


            <!-- /.social-auth-links -->



        </div>
        <!-- /.login-box-body -->
    </div>
</body>

</html>
