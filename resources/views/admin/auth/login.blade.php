<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户登录 | 管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/libs/font-awesome/4.5.0/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/libs/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/libs/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
    <script src="{{ asset('/libs/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        管理后台
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录</p>

        <form action="{{ url('/admin/login') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" class="form-control" placeholder="登录邮箱名"  name="email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{ $errors->first('email') }}</label>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" class="form-control"  name="password" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{ $errors->first('password') }}</label>
                @endif
            </div>
            <div class="row">
{{--                 <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox">&nbsp;&nbsp;记&nbsp;住&nbsp;
                        </label>
                    </div>
                </div> --}}
                <!-- /.col -->
                <div class="col-xs-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <!-- /.social-auth-links -->

        {{--<a href="#">我忘了密码</a><br>--}}
        {{--<a href="#" class="text-center">新注册用户</a>--}}

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
