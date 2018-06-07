@extends('layouts.master')
{{--@isset($reset)--}}
    {{--<script src="{{ URL::asset($reset) }}"></script>--}}
{{--@endisset--}}
@section('content')
{!! Form::open([
    'method' => 'post',
    'id' => 'formUser',
    'class' => 'form-horizontal form-bordered',
    'data-parsley-validate' => 'true'
]) !!}
<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">系统设置/更改密码</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('users/index')}}"><i class="fa fa-mail-reply text-blue"> 返回主页</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            @if (isset($user['id']))
                {{ Form::hidden('user_id', $user['id'], ['id' => 'user_id']) }}
            @endif
            <div class="form-group">
                {!! Form::label('password', '请输入原密码', [
                    'class' => 'col-sm-3 control-label'
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </div>
                        {!! Form::password('password', [
                            'class' => 'form-control',
                            'placeholder' => '(请输入密码)',
                            'required' => 'true',
                            'minlength' => '6',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password', '请输入新密码', [
                    'class' => 'col-sm-3 control-label'
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </div>
                        {!! Form::password('pwd1', [
                            'class' => 'form-control',
                            'placeholder' => '(请输入密码)',
                            'required' => 'true',
                            'minlength' => '6',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('confirm_password', '请确认新密码', [
                    'class' => 'col-sm-3 control-label'
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </div>
                        {!! Form::password('pwd2', [
                            'class' => 'form-control',
                            'placeholder' => '(请确认密码)',
                            'required' => 'true',
                            'minlength' => '6',

                        ]) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="overlay" style="display: none;">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <div class="box-footer">
        {{--button--}}
        <div class="form-group">
            <div class="col-sm-3 col-sm-offset-3">
                {!! Form::submit('保存', ['class' => 'btn btn-primary pull-left', 'id' => 'reset']) !!}
                {!! Form::reset('重置', ['class' => 'btn btn-default pull-right', 'id' => 'cancel']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection


