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
        if(img_index >= $(".demo figure img").length) {
            img_index = 0;
        }
        img_src = $(".demo figure img").eq(img_index).attr("src");
        photoView($(".demo figure img"));
    });
    //上一张
    $(".photo-panel .photo-div .arrow-prv").click(function() {
        img_index--;
        if(img_index < 0) {
            img_index = $(".demo figure img").length - 1;
        }
        img_src = $(".demo figure img").eq(img_index).attr("src");
        photoView($(".demo figure img"));
    });
    //如何调用？
    $(".demo figure img").click(function() {
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

$('.photos-item-delete').click(function () {

    var result = confirm("是否确认删除该图片?");
    var inputElem = $(this).siblings('input');
    var id = inputElem.val();
    console.log(id);

    if(result){
        $.ajax({
            type:'DELETE',
            dataType:'json',
            data:{ _token: $('#csrf_token').attr('content')},
            url:'../pictures/delete/'+id,
            success:function (result) {
                if(result.statusCode === 200){
                    $.gritter.add({title: '操作结果', text: '删除成功', image:'../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();

                }else{
                    $.gritter.add({title: '操作结果', text: '删除失败', image:'../image/error.png'});
                }
            }
        })
    }
});
