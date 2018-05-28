<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">首页/创建管理员</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('admins/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($admin['id']))
                {{ Form::hidden('id', $admin['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('username', '用户名', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    {{ Form::text('username', null, [
                    'class' => 'form-control',
                    'required' => 'true',
                    'placeholder' => '(请填写用户名)',
                    'data-parsley-length' => '[2, 255]'
                ]) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('realname', '真实姓名', [
                'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    {{ Form::text('realname', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写真实姓名)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="col-sm-3 control-label">性别</label>
                <div class="col-sm-6">
                    <label id="gender">
                        <input id="gender" type="radio" name="gender" class="minimal" checked value="1"/>
                    </label> 男
                    <label id="gender">
                        <input id="gender" type="radio" name="gender" class="minimal" value="0"/>
                    </label> 女
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">密码</label>

                <div class="col-sm-6">
                    <input type="password" name="password" id="pwd1" class="form-control"
                           required placeholder="(请填写密码)"
                           data-parsley-length="[2,16]"
                           data-parsley-type="alphanum"

                    >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">确认密码</label>

                <div class="col-sm-6">
                    <input type="password" name="password" id="pwd2" class="form-control"
                           required placeholder="(请填写密码)"
                           data-parsley-length="[2,16]"
                           data-parsley-type="alphanum"
                    >
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('mobile', '手机号码', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    {{ Form::text('mobile', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'data-parsley-length'=> '[11,11]',
                        'data-parsley-type' => 'integer',
                        'placeholder' => '(请输入手机号码)',
                    ]) }}
                </div>
            </div>
            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>