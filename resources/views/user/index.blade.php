@extends('layouts.master')
@section('content')
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <span id="breadcrumb" style="color: #999; font-size: 13px;">管理员/管理员列表</span>
        <div class="box-tools pull-right">
            <button id="add-record" type="button" class="btn btn-box-tool">
                <a href="{{url('admins/create')}}"><i class="fa fa-plus text-blue"> 新增</i></a>
            </button>
        </div>
    </div>
    <div class="box-body">
        <table id="data-table" style="width: 100%"
               class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr class="bg-info">
                <th>#</th>
                <th>用户名</th>
                <th>真实姓名</th>
                {{--<th>性别</th>--}}
                {{--<th>角色</th>--}}
                {{--<th>手机号码</th>--}}
                {{--<th>创建时间</th>--}}
                {{--<th>更新时间</th>--}}
                {{--<th>状态</th>--}}
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection