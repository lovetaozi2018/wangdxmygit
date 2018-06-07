<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" id="csrf_token">
    <title>二维码相册</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/gritter/css/jquery.gritter.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>二维码相册</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">请登录</p>
        <form  method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input  class="form-control" placeholder="(用户名/手机号码)" name="input" id="input">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="密码" name="password" id="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" id="remember">&nbsp;&nbsp;记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button onclick="void(0)" class="btn btn-primary btn-block btn-flat" id="signin">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        {{--<!-- /.social-auth-links -->--}}
        {{--<a href="{{Url('password/reset')}}">忘记密码</a><br>--}}
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.3 -->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script  src="{{ asset('js/bootstrap.min.js')  }}"></script>
<script  src="{{ asset('js/auth/login.js')  }}"></script>
<!-- iCheck -->

<script src="{{URL::asset('plugins/gritter/js/jquery.gritter.min.js')}}"></script>
<script src="{{URL::asset('plugins/iCheck/icheck.min.js')}}"></script>
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
