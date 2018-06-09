<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">学生管理/创建年级</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('students/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($student['student']['id']))
                {{ Form::hidden('id', $student['student']['id'], ['id' => 'id']) }}
            @endif
            @if(isset($student['student']['user_id']))
                {{ Form::hidden('user_id', $student['student']['user_id'], ['id' => 'user_id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('user[realname]', '姓名', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                        {{ Form::text('user[realname]', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写姓名)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('user[username]', '账号', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-child"></i>
                        </div>
                        {{ Form::text('user[username]', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写账号,只能是数字或者字母)',
                        'data-parsley-type' => 'alphanum',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            @include('layouts.checkbox', [
            'id' => 'user[gender]',
            'label' => '性别',
            'value' => $user['gender'] ?? null,
            'options' => ['男', '女']
            ])
            <div class="form-group">
                {!! Form::label('student[class_id]', '所属班级', [
                    'class' => 'col-sm-3 control-label',
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-object-group "></i>
                        </div>
                        {!! Form::select('student[class_id]', $classes, null, [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%;'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('duty', '职务', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-cog"></i>
                        </div>
                        {{ Form::text('student[duty]', null, [
                        'class' => 'form-control',
                        'placeholder' => '(请填写班级职务)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('student[star]', '星座', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-star"></i>
                        </div>
                        {{ Form::text('student[star]', null, [
                        'class' => 'form-control',
                        'placeholder' => '(请填写星座)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('student[address]', '住址', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-book"></i>
                        </div>
                        {{ Form::text('student[address]', null, [
                        'class' => 'form-control',
                        'placeholder' => '(请填写住址)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('student[hobby]', '爱好', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-bicycle"></i>
                        </div>
                        {{ Form::text('student[hobby]', null, [
                        'class' => 'form-control',
                        'placeholder' => '(请填写爱好)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('student[specialty]', '特长', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-heart"></i>
                        </div>
                        {{ Form::text('student[specialty]', null, [
                        'class' => 'form-control',
                        'placeholder' => '(请填写特长)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('user[mobile]', '手机号码', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        {{ Form::text('user[mobile]', null, [
                            'class' => 'form-control',
                            'data-parsley-length'=> '[11,11]',
                            'data-parsley-type' => 'integer',
                            'placeholder' => '(请输入手机号码)',
                        ]) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('user[qq]', 'QQ', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-qq"></i>
                        </div>
                        {{ Form::text('user[qq]', null, [
                            'class' => 'form-control',
                            'data-parsley-length'=> '[5,10]',
                            'data-parsley-type' => 'integer',
                            'placeholder' => '(请输入qq号码)',
                        ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('user[wechat]', '微信号', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-wechat"></i>
                        </div>
                        {{ Form::text('user[wechat]', null, [
                            'class' => 'form-control',
                            'data-parsley-length'=> '[2,16]',
                            'data-parsley-type' => 'integer',
                            'placeholder' => '(请输入微信号)',
                        ]) }}
                    </div>
                </div>
            </div>

            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'student[enabled]',
                'value' => isset($student['student']['enabled']) ? $student['student']['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>