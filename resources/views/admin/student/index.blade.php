@extends('layouts.master')
@section('content')
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">学生管理/学生列表</span>
        <div class="box-tools pull-right">
            <button id="add-record" type="button" class="btn btn-box-tool">
                <a href="{{url('students/create')}}"><i class="fa fa-plus text-blue"> 新增</i></a>
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
                <th>班级</th>
                <th>QQ</th>
                <th>电话</th>
                <th>职务</th>
                <th>星座</th>
                <th>地址</th>
                <th>创建于</th>
                <th>更新于</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection