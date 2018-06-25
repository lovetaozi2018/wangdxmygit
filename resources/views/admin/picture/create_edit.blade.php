<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">相册管理/创建相册</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('pictures/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($picture['id']))
                {{ Form::hidden('id', $picture['id'], ['id' => 'id']) }}
            @endif
            <div class="form-group">
                {{ Form::label('name', '相册名称', [
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
                        'placeholder' => '(请填写相册名称)',
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

            @if(isset($picture))
                <div class="form-group">
                    <label for="fileImg" class="col-sm-3 control-label">图片</label>
                    <div class="col-sm-6">
                        <input type="file" name="fileImg" id="fileImg" onchange="preview(this)" accept="image/gif, image/jpeg,image/png,image/jpg"/>
                        <div id="preview">
                            @if(isset($picture))
                                <img src='{{asset("{$picture->path}")}}' style="height: 100px;margin-top: 5px;"/>
                            @endif
                        </div>
                    </div>
                </div>
            @else
            <div class="form-group">
                <label for="fileImg" class="col-sm-3 control-label">图片</label>
                <div class="col-sm-6">
                    <input type="file" name="fileImg[]" id="fileImg" onchange="preview(this)"
                           accept="image/gif, image/jpeg,image/png,image/jpg" multiple/>
                    <div id="preview">
                    </div>
                </div>
            </div>
            @endif
            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($picture['enabled']) ? $picture['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>