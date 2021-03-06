@extends('layouts.master')
@section('content')
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">学校/学校列表</span>
        <div class="box-tools pull-right">
            @if( Auth::user()->role_id == 1)
            <button id="add-record" type="button" class="btn btn-box-tool">
                <a href="{{url('schools/create')}}"><i class="fa fa-plus text-blue"> 新增</i></a>
            </button>
            @endif
        </div>
    </div>
    <div class="box-body">
        <table id="data-table" style="width: 100%"
               class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr class="bg-info">
                <th>#</th>
                <th>名称</th>
                <th>地址</th>
                <th>创建时间</th>
                <th>更新时间</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection