<div class="box box-widget">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">轮播图管理/创建轮播图</span>
        <div class="box-tools pull-right">
            <button id="record-list" type="button" class="btn btn-box-tool">
                <a href="{{url('slides/index')}}"><i class="fa fa-mail-reply text-blue"> 返回列表</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            {{ csrf_field() }}
            @if(isset($classes['id']))
                {{ Form::hidden('id', $classes['id'], ['id' => 'id']) }}
            @endif
            {{--<div class="form-group">--}}
                {{--{{ Form::label('name', '班级名称', [--}}
                    {{--'class' => 'col-sm-3 control-label'--}}
                {{--]) }}--}}
                {{--<div class="col-sm-6">--}}
                    {{--<div class="input-group">--}}
                        {{--<div class="input-group-addon">--}}
                            {{--<i class="fa fa-weixin"></i>--}}
                        {{--</div>--}}
                        {{--{{ Form::text('name', null, [--}}
                        {{--'class' => 'form-control',--}}
                        {{--'required' => 'true',--}}
                        {{--'placeholder' => '(请填写用户名)',--}}
                        {{--'data-parsley-length' => '[2, 255]'--}}
                    {{--]) }}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
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
                <label for="fileImg" class="col-sm-3 control-label">轮播图：</label>
                <div class="col-sm-6">
                    <input type="file" name="fileImg[]" id="fileImg" accept="image/gif, image/jpeg,image/png,image/jpg" multiple/>
                </div>
            </div>

            {{--<div class="form-group">--}}
                {{--{{ Form::label('remark', '备注', [--}}
                    {{--'class' => 'col-sm-3 control-label'--}}
                {{--]) }}--}}
                {{--<div class="col-sm-6">--}}
                    {{--{{ Form::text('remark', null, [--}}
                    {{--'class' => 'form-control',--}}
                    {{--'required' => 'true',--}}
                    {{--'placeholder' => '(可填)',--}}
                    {{--'data-parsley-length' => '[2, 255]'--}}
                {{--]) }}--}}
                {{--</div>--}}
            {{--</div>--}}

            @include('layouts.enabled', [
                'label' => '是否启用',
                'id' => 'enabled',
                'value' => isset($classes['enabled']) ? $classes['enabled'] : NULL,
            ])
        </div>
    </div>
    @include('layouts.form_buttons')
</div>
