<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">班级视频/添加视频</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('schoolVideos/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($schoolVideo['id']))
                {{ Form::hidden('id', $schoolVideo['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('title', '视频名称', [
                    'class' => 'col-sm-3 control-label'
                ]) }}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-group"></i>
                        </div>
                        {{ Form::text('title', null, [
                        'class' => 'form-control',
                        'required' => 'true',
                        'placeholder' => '(请填写视频名称)',
                        'data-parsley-length' => '[2, 255]'
                    ]) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('school_id', '学校', [
                    'class' => 'col-sm-3 control-label',
                ]) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-object-group "></i>
                        </div>
                        {!! Form::select('school_id', $schools, null, [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%;'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="fileImg" class="col-sm-3 control-label">视频背景图</label>
                <div class="col-sm-6">
                    <input type="file" name="fileImg" id="fileImg" onchange="preview(this)" accept="image/gif, image/jpeg,image/png,image/jpg"/>
                    <div id="preview">
                        @if(isset($schoolVideo) && !empty($schoolVideo->image && is_file(public_path().$schoolVideo->image )))
                            <img src='{{asset("{$schoolVideo->image}")}}' style="height: 100px;margin-top: 5px;"/>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="video" class="col-sm-3 control-label">视频：</label>
                <div class="col-sm-6">
                    <input type="file" class='fileVideo' id="video" name="video" accept="video/mp4,video/mpeg,video/mpeg4-generic">
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
                'value' => isset($schoolVideo['enabled']) ? $schoolVideo['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>