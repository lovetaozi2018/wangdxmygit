<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">年级管理/创建年级</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('pictures/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($video['id']))
                {{ Form::hidden('id', $video['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('title', '视频名称', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-weixin"></i>
                        </div>
                        {{ Form::text('title', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写用户名)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('class_id', '班级', [
                    'class' => 'col-sm-3 control-label',
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-object-group "></i>
                        </div>
                        {!! Form::select('class_id', $classes, null, [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%;'
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="video" class="col-sm-3 control-label">视频：</label>
                <div class="col-sm-6">
                    <input type="file" class='fileVideo' id="video" name="video">
                    <div style="margin-top: 20px;display: none" id="progressBox">
                        上传进度：
                        <progress></progress>
                        <span id="progress">0 bytes</span>
                    </div>
                </div>
            </div>
            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($video['enabled']) ? $video['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>