<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">年级管理/创建年级</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('classes/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($classes['id']))
                {{ Form::hidden('id', $classes['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('name', '班级名称', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-weixin"></i>
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
                {!! Form::label('grade_id', '所属年级', [
                    'class' => 'col-sm-3 control-label',
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-object-group "></i>
                        </div>
                        {!! Form::select('grade_id', $grades, null, [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%;'
                        ]) !!}
                    </div>
                </div>
            </div>
            @include('layouts.multiple_select', [
                   'label' => '科任老师',
                   'id' => 'teacher_ids',
                   'items' => $teachers,
                   'icon' => 'fa fa-object-group',
                   'selectedItems' => $selectedTeachers ?? null
               ])

            <div class="form-group">
                {{ Form::label('remark', '备注', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    {{ Form::text('remark', null, [
                    'class' => 'form-control',
                    'required' => 'true',
                    'placeholder' => '(可填)',
                    'data-parsley-length' => '[2, 255]'
                ]) }}
                </div>
            </div>

            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($classes['enabled']) ? $classes['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>