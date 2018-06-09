<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">年级管理/创建年级</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('grades/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($grade['id']))
                {{ Form::hidden('id', $grade['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('name', '年级名称', [
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
                        'placeholder' => '(请填写用户名)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('school_id', '所属学校', [
                    'class' => 'col-sm-3 control-label',
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-star-half-empty"></i>
                        </div>
                        {!! Form::select('school_id', $schools, null, [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%;'
                        ]) !!}
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
                        'placeholder' => '(可填)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>

            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($grade['enabled']) ? $grade['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>