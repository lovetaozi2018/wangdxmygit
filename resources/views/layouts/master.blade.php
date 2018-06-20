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
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{ URL::asset('plugins/parsley/parsley.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/switchery/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/jstree/dist/themes/default/style.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{URL::asset('plugins/iCheck/flat/blue.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{URL::asset('plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{URL::asset('plugins/gritter/css/jquery.gritter.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{URL::asset('plugins/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{URL::asset('plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('plugins/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('plugins/datatables/select/css/select.dataTables.min.css')}}">
    <!-- iCheck-->
    <link rel="stylesheet" href="{{URL::asset('plugins/iCheck/all.css')}}">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{URL::asset('dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('dist/css/AdminLTE.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>分销</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="{{ asset('image/wechat.png') }}" class="pull-left"
                     style="display: block;width: 32px;height: 32px;margin-top: 9px">
                <b>二维码相册</b>
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ url('logout') }}">
                            <span class="hidden-xs">
                                退出登录
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('image/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->realname }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i>{{ Auth::user()->role->name }}</a>
                </div>
            </div>
            <ul class="sidebar-menu">
                {{--<li id="index">--}}
                    {{--<a href="#"><i class="fa fa-comments"></i> <span>主页</span></a>--}}
                {{--</li>--}}
                <li id="grades">
                    <a href="{{url('grades/index')}}"><i class="fa fa-group"></i> <span>年级管理</span></a>
                </li>
                <li id="teachers">
                    <a href="{{url('teachers/index')}}"><i class="fa  fa-street-view"></i> <span>教师管理</span></a>
                </li>
                <li id="students">
                    <a href="{{url('students/index')}}"><i class="fa fa-gear "></i> <span>学生管理</span></a>
                </li>
                <li id="users" class="treeview">
                    <a href="#"><i class="fa  fa-graduation-cap fa-dashboard"></i> <span>学校管理</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('schools/index') }}"><i class="fa fa-circle-o"></i> 学校列表</a></li>
                        <li><a href="{{ url('slides/index') }}"><i class="fa fa-circle-o"></i> 轮播图列表</a></li>
                        {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> 学校介绍</a></li>--}}
                        <li><a href="{{ url('schoolVideos/index') }}"><i class="fa fa-circle-o"></i> 学校视频</a></li>
                    </ul>
                </li>

                <li id="grades" class="treeview">
                    <a href="#"><i class="fa fa-wechat fa-dashboard"></i> <span>班级管理</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('classes/index') }}"><i class="fa fa-circle-o"></i> 班级列表</a></li>
                        <li><a href="{{ url('pictures/index') }}"><i class="fa fa-file-image-o"></i> 班级相册</a></li>
                        <li><a href="{{ url('squadVideos/index') }}"><i class="fa fa-circle-o"></i> 班级视频</a></li>
                    </ul>
                </li>


                <li id="users" class="treeview">
                    <a href="{{url('users/index')}}"><i class="fa fa-plus fa-dashboard"></i> <span>系统设置</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{ url('users/index') }}"><i class="fa fa-circle-o"></i>管理员</a></li>
                    </ul>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{ url('users/reset') }}"><i class="fa fa-circle-o"></i> 修改密码</a></li>
                    </ul>
                </li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
        </section>
        <section class="content clearfix">
            <div class="col-lg-12">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.1
        </div>
        <strong>Copyright &copy; 2017-2020 <a href="http://www.028lk.com">Link Communications</a>.</strong> All rights
        reserved.
    </footer>
</div>
<!-- ./wrapper -->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('plugins/gritter/js/jquery.gritter.min.js')}}"></script>

<script src="{{ URL::asset('plugins/switchery/switchery.min.js') }}"></script>

<script src="{{URL::asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('plugins/select2/select2.full.js')}}"></script>
<script src="{{URL::asset('plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ URL::asset('plugins/parsley/parsley.min.js') }}"></script>
<script src="{{ URL::asset('plugins/parsley/i18n/zh_cn.js') }}"></script>
<script src="{{ URL::asset('plugins/parsley/i18n/zh_cn.extra.js') }}"></script>
<script src="{{URL::asset('js/switcher.init.js')}}"></script>
<script src="{{URL::asset('plugins/iCheck/icheck.min.js')}}"></script>

<script src="{{ URL::asset('plugins/jstree/dist/jstree.min.js') }}"></script>
<script src="{{ URL::asset('plugins/gritter/js/jquery.gritter.min.js') }}"></script>
<script src="{{URL::asset('plugins/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('plugins/datatables/select/js/dataTables.select.min.js')}}"></script>
<script src="{{URL::asset('plugins/datatables/buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('dist/js/app.js')}}"></script>

<script type ="text/javascript" src="{{asset('plugins/kindeditor/kindeditor-all.js')}}"></script>
<script type ="text/javascript" src="{{asset('plugins/kindeditor/zh-CN.js')}}"></script>
{{--<script src="{{URL::asset('js/common.js')}}"></script>--}}
<script src="{{$js}}"></script>
<script>
    $('select').select2({ language: "zh-CN" });
</script>
</body>
</html>
