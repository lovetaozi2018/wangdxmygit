@extends('layouts.master')
<link rel="stylesheet" href="{{ URL::asset('css/admin/picture/detail.css?t=1') }}">
@section('content')
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
        <div class="page-photo-list demo">
            <div class="blog">
                @if(sizeof($pictures) !=0)
                    @foreach($pictures as $p)
                        <figure>
                            <div class="photos-item">
                                <input type="hidden" value="{{$p->id}}" id="picture-id">
                                <img src='{{asset("{$p->path}")}}' class="img" style="margin:0; width: 100%;">
                                <span class="photos-item-delete"></span>
                            </div>
                            <p>{{$p->id}}</p>
                        </figure>
                    @endforeach
                @endif
            </div>

        </div>
        <div class="photo-mask"></div>
        <div class="photo-panel">
            <div class="photo-div">
                <div class="photo-left">
                    <div class="arrow-prv"></div>
                </div>
                <div class="photo-img">
                    <div class="photo-bar">
                        <div class="photo-close"></div>
                    </div>
                    <div class="photo-view-h">
                        <img src="http://b.zol-img.com.cn/sjbizhi/images/9/800x1280/1471524533521.jpg" />
                    </div>

                </div>
                <div class="photo-right">
                    <div class="arrow-next"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

<script src="{{URL::asset('js/jquery.min.js')}}"></script>

