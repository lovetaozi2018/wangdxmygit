@extends('layouts.master')
@section('content')
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">班级管理/班级列表</span>
        <div class="box-tools pull-right">
            <button id="add-record" type="button" class="btn btn-box-tool">
                <a href="{{url('classes/create')}}"><i class="fa fa-plus text-blue"> 新增</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <table id="data-table" style="width: 100%"
               class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr class="bg-info">
                <th>#</th>
                <th>名称</th>
                <th>年级</th>
                <th>所属学校</th>
                <th>二维码</th>
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
<style>
    tbody td{
        height: 130px;
        line-height: 130px!important;
        vertical-align: middle!important;
    }
</style>