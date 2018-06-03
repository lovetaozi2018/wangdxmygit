<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>视频详情</title>
    <link rel="stylesheet" href="{{asset('static/css/weui.min.css')}}">
    <link rel="stylesheet" href="{{asset('static/css/jquery-weui.min.css')}}">
    <link rel="stylesheet" href="{{asset('static/css/main.css')}}">
    <!--video-->
    <link rel="stylesheet" href="{{asset('static/css/video-js.css')}}">
</head>
<body>
<div>
    <div class="wrapper">
        <div class="page weui-article">
            <article class="weui_article">
                <section>

                <h1 style="font-weight:600">{{isset($news->title) ? $news->title : NULL}}</h1>
                <div class="articleInfo">
                    <em>{{isset($news->create_time) ? $news->create_time :NULL}}</em>
                    <em>{{isset($news->founder) ? $news->founder : NULL}}</em>
                </div>
                    @if(array_key_exists('videourl',$news))
                    @if(strlen($news->videourl)!=0)
                    <section>

                        <video id="video" class="video-js vjs-default-skin vjs-big-play-centered" controls
                               preload="none" width="640" height="250"
                               poster="https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=2751573775,4260236656&fm=26&gp=0.jpg"
                               data-setup="{}">
                            <source src='{{asset("static/uploads/$news->videourl")}}' type='video/mp4'/>
                        </video>
                    </section>
                    @else
                        <section>

                        </section>
                        @endif
                    @else
                        @endif
                    <section>
                        {!! isset($news->content) ? $news->content : NULL !!}
                        {{--<h3>有图的</h3>--}}
                        {{--<p>--}}
                            {{--<img src="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=830520405,3187379697&fm=26&gp=0.jpg"--}}
                                 {{--alt="星空">--}}
                        {{--</p>--}}
                    </section>

                </section>
            </article>
        </div>
    </div>
</div>
<!--video-->
<script src="{{asset('static/js/video.min.js')}}"></script>
<script>
    videojs("video").ready(function () {
        var myPlayer = this;
        myPlayer.play();
    });
</script>
</body>
</html>