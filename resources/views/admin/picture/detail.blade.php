@extends('layouts.master')
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
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('uploads/image/20180611125401_Y6guU.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('uploads/image/20180611125401_Y6guU.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('uploads/image/20180611125401_Y6guU.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('uploads/image/20180611125401_Y6guU.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>
            <span><img src="{{asset('image/002008151116108868.jpg')}}" class="img"></span>

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
<style>
    .page-photo-list{
        display: block;

        margin-left: auto;
        margin-right: auto;
    }
    .img{
        height: 127px;
        width: 173px;
        display: block;
        float: left;
        margin: 10px 10px;

    }
    .photo-mask {
        position: fixed;
        z-index: 10;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.8);
        filter: alpha(opacity=20);
        -moz-opacity: 0.8;
        opacity: 0.8;
        display: none;
    }

    .photo-panel {
        position: absolute;
        display: none;
        clear: both;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 10;
    }

    .photo-panel .photo-div,
    .photo-panel .photo-bar {
        width: 100%;
    }

    .photo-panel .photo-div {
        width: 960px;
        height: 560px;
        z-index: 11;
        margin: auto;
        position: relative;
    }

    .photo-panel .photo-close {
        background: url(../../image/close.png);
        width: 56px;
        height: 56px;
        position: absolute;
        margin-left: 664px;
    }

    .photo-panel .photo-close:hover {
        background: url(../../image/close_ch.png);
        width: 56px;
        height: 56px;
        position: absolute;
        margin-left: 664px;
    }

    .photo-panel .photo-bar-tip {
        width: 700px;
        height: 44px;
        position: absolute;
        margin-top: -64px;
        padding: 10px;
    }

    .photo-panel .photo-bar-tip:hover {
        width: 700px;
        height: 44px;
        position: absolute;
        margin-top: -64px;
        background: #000;
        filter: alpha(opacity=20);
        -moz-opacity: 0.8;
        opacity: 0.8;
        color: #fff;
        padding: 10px;
    }

    .photo-panel .photo-img {
        width: 720px;
        float: left;
        height: 560px;
        background: #fff;
    }

    .photo-panel .photo-view-w {
        width: 720px;
        height: 560px;
        text-align: center;
        vertical-align: middle;
        display: table-cell;
    }

    .photo-panel .photo-view-h {
        width: 720px;
        height: 560px;
        text-align: center;
        vertical-align: middle;
    }

    .photo-panel .photo-view-w img {
        max-width: 700px;
        height: auto;
        vertical-align: middle;
        text-align: center;
        max-height: 540px;
        margin: 10px;
        -moz-box-shadow: 5px 5px 5px #a6a6a6;
        /* 老的 Firefox */
        box-shadow: 5px 5px 5px #a6a6a6;
        -webkit-animation: swing 1s .2s ease both;
        -moz-animation: swing 1s .2s ease both;
    }

    .photo-panel .photo-view-h img {
        max-width: 700px;
        height: 540px;
        margin: 10px;
        -moz-box-shadow: 5px 5px 5px #a6a6a6;
        /* 老的 Firefox */
        box-shadow: 5px 5px 5px #a6a6a6;
        -webkit-animation: swing 1s .2s ease both;
        -moz-animation: swing 1s .2s ease both;
    }

    @-webkit-keyframes swing {
        20%,
        40%,
        60%,
        80%,
        100% {
            -webkit-transform-origin: top center
        }
        20% {
            -webkit-transform: rotate(15deg)
        }
        40% {
            -webkit-transform: rotate(-10deg)
        }
        60% {
            -webkit-transform: rotate(5deg)
        }
        80% {
            -webkit-transform: rotate(-5deg)
        }
        100% {
            -webkit-transform: rotate(0deg)
        }
    }

    @-moz-keyframes swing {
        20%,
        40%,
        60%,
        80%,
        100% {
            -moz-transform-origin: top center
        }
        20% {
            -moz-transform: rotate(15deg)
        }
        40% {
            -moz-transform: rotate(-10deg)
        }
        60% {
            -moz-transform: rotate(5deg)
        }
        80% {
            -moz-transform: rotate(-5deg)
        }
        100% {
            -moz-transform: rotate(0deg)
        }
    }


    .photo-panel .photo-left,
    .photo-panel .photo-right {
        width: 120px;
        float: left;
        margin-top: 220px;
    }

    .photo-panel .arrow-prv {
        background: url(../../image/l.png);
        width: 120px;
        height: 120px;
    }

    .photo-panel .arrow-prv:hover {
        width: 120px;
        height: 120px;
        cursor: pointer;
    }

    .photo-panel .arrow-next {
        background: url(../../image/r.png);
        width: 120px;
        height: 120px;
    }

    .photo-panel .arrow-next:hover {
        width: 120px;
        height: 120px;
        cursor: pointer;
    }

</style>
<script src="{{URL::asset('js/jquery.min.js')}}"></script>

<script>
    var img_index = 0;
    var img_src = "";

    $(function() {
        //计算居中位置
        var mg_top = ((parseInt($(window).height()) - parseInt($(".photo-div").height())) / 2);

        $(".photo-div").css({
            "margin-top": "" + mg_top + "px"
        });
        //关闭
        $(".photo-close").click(function() {
            $(".photo-mask").hide();
            $(".photo-panel").hide();
        });
        //下一张
        $(".photo-panel .photo-div .arrow-next").click(function() {
            img_index++;
            if(img_index >= $(".demo span img").length) {
                img_index = 0;
            }
            img_src = $(".demo span img").eq(img_index).attr("src");
            photoView($(".demo span img"));
        });
        //上一张
        $(".photo-panel .photo-div .arrow-prv").click(function() {
            img_index--;
            if(img_index < 0) {
                img_index = $(".demo span img").length - 1;
            }
            img_src = $(".demo span img").eq(img_index).attr("src");
            photoView($(".demo span img"));
        });
        //如何调用？
        $(".demo span img").click(function() {
            $(".photo-mask").show();
            $(".photo-panel").show();
            img_src = $(this).attr("src");
            img_index = $(this).index();
            photoView($(this));
        });

    });
    //自适应预览
    function photoView(obj) {
        if($(obj).width() >= $(obj).height()) {
            $(".photo-panel .photo-div .photo-img .photo-view-h").attr("class", "photo-view-w");
            $(".photo-panel .photo-div .photo-img .photo-view-w img").attr("src", img_src);
        } else {
            $(".photo-panel .photo-div .photo-img .photo-view-w").attr("class", "photo-view-h");
            $(".photo-panel .photo-div .photo-img .photo-view-h img").attr("src", img_src);
        }
        //此处写调试日志
        console.log(img_index);
    }
</script>