<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">学校管理/创建学校</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('schools/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($school['id']))
                {{ Form::hidden('id', $school['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('name', '学校名称', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-heart-o"></i>
                        </div>
                        {{ Form::text('name', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写名称)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('address', '地址', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-location-arrow"></i>
                        </div>
                        {{ Form::text('address', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写地址)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('realname', '管理员姓名', [
                'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                    {{ Form::text('realname', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写真实姓名)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
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
            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($school['enabled']) ? $school['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>