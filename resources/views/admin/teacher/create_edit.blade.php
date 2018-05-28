<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">教师管理/创建教师</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('teachers/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($teacher['id']))
                {{ Form::hidden('id', $teacher['id'], ['id' => 'id']) }}
            @endif
            @if(isset($teacher['user_id']))
                {{ Form::hidden('user_id', $teacher['user_id'], ['id' => 'user_id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('realname', '姓名', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-child"></i>
                        </div>
                        {{ Form::text('realname', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写姓名)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            @include('layouts.checkbox', [
           'id' => 'gender',
           'label' => '性别',
           'value' => $user['gender'] ?? null,
           'options' => ['男', '女']
       ])
            <div class="form-group">
                {!! Form::label('school_id', '所属学校', [
                    'class' => 'col-sm-3 control-label',
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-university"></i>
                        </div>
                        {!! Form::select('school_id', $schools, null, [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%;'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('mobile', '手机号码', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        {{ Form::text('mobile', null, [
                            'class' => 'form-control',
                            'required' => 'true',
                            'data-parsley-length'=> '[11,11]',
                            'data-parsley-type' => 'integer',
                            'placeholder' => '(请输入手机号码)',
                        ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('remark', '备注', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-book"></i>
                        </div>
                        {{ Form::text('remark', null, [
                        'class' => 'form-control',
                        'placeholder' => '(请填写地址)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            @include('layouts.enabled', [
                'label' => '是否是班主任',
                'id' => 'status',
                'value' => isset($teacher['status']) ? $teacher['status'] : NULL,
            ])

            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($teacher['enabled']) ? $teacher['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>