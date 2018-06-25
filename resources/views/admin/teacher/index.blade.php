@extends('layouts.master')
@section('content')
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">教师/教师列表</span>
        <div class="box-tools pull-right">
            <button id="import" type="button" class="btn btn-box-tool">
                <i class="fa fa-arrow-circle-up text-blue"> 批量导入</i>
            </button>
            <button id="add-record" type="button" class="btn btn-box-tool">
                <a href="{{url('teachers/create')}}"><i class="fa fa-plus text-blue"> 新增</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <table id="data-table" style="width: 100%"
               class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr class="bg-info">
                <th>#</th>
                <th>姓名</th>
                <th>学校</th>
                <th>性别</th>
                <th>手机</th>
                <th>QQ</th>
                <th>是否是班主任</th>
                <th>创建于</th>
                <th>更新于</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- 导入excel -->
<form class='import' method='post' enctype='multipart/form-data' id="form-import">
    {{csrf_field()}}
    <div class="modal fade" id="import-pupils">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">批量导入</h4>
                </div>
                <div class="modal-body with-border">
                    <div class="form-horizontal">
                        <div class="form-group">
                            {{ Form::label('import', '选择导入文件', [
                                'class' => 'control-label col-sm-3'
                            ]) }}

                            <div class="col-sm-6">
                                <input type="file" id="fileupload" accept=".xls,.xlsx" name="file">
                                <p class="help-block">下载<a href="{{URL::asset('files/students.xlsx')}}">模板</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">取消</a>
                    <a id="confirm-import" href="#" class="btn btn-sm btn-success" data-dismiss="modal">确定</a>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

