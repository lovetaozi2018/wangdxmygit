Switcher.init();

$(document).ready(function() {
    $('.select2').select2();
});

function preview(file) {
    var prevDiv = document.getElementById('preview');
    if (file.files && file.files[0]) {
        var reader = new FileReader();
        reader.onload = function (evt) {
            prevDiv.style.display = 'block';
            prevDiv.innerHTML = '<img src="' + evt.target.result + '" style="height: 100px;margin-top: 5px;"/>';
        };
        reader.readAsDataURL(file.files[0]);
    }
    else {
        prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
    }
}

$(document).ready(function() {
    $('.select2').select2();
});

var $form = $('#formSlide');
$('#save').on('click', function (e) {
    if($('#video').val()!==''){
        $('#progressBox').show();
    }
    e.preventDefault();
    var formData = new FormData();
    var title = $('#title').val();
    var classId = $('#class_id').val();

    var img = $('#fileImg')[0].files[0];
    // console.log(img);return false;
    if (!img) {
        img= '';

    }
    var video = $('.fileVideo')[0].files[0];

    var enabled = $('#enabled').val();
    if(enabled==='on'){
        enabled = 1;
    }else{
        enabled = 0;
    }

    // console.log(img);return false;
    if (!video) {
        video= '';

    }

    formData.append("title", title);
    formData.append("fileImg", img);
    formData.append("fileVideo", video);
    formData.append("class_id", classId);
    formData.append('enabled',enabled);
    formData.append("_token", $('#csrf_token').attr('content'));

    $.ajax({
        type: 'POST',
        dataType: 'json',
        xhr: function(){ //获取ajaxSettings中的xhr对象，为它的upload属性绑定progress事件的处理函数
            myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ //检查upload属性是否存在
//绑定progress事件的回调函数
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
            }
            return myXhr; //xhr对象返回给jQuery使用
        },
        url: '../update/' + $('#id').val(),
        processData:false,
        contentType:false,
        data:formData,
        success: function (result) {
            if (result.statusCode === 200) {
                $.gritter.add({title: '操作结果', text: '更新成功', image:'../../image/confirm.png'});
            } else {
                $.gritter.add({title: '操作结果', text: '更新失败', image:'../../image/failure.jpg'});
            }
        },
        error: function (result) {

        }
    });
});

//上传进度回调函数：
function progressHandlingFunction(e) {
    if (e.lengthComputable) {
        $('progress').attr({value : e.loaded, max : e.total}); //更新数据到进度条
        var percent = e.loaded/e.total*100;
        $('#progress').html(e.loaded + "/" + e.total+" bytes. " + percent.toFixed(2) + "%");
    }
}
// $form.parsley().on('form:validated', function() {
//
//     if ($('.parsley-error').length === 0) {
//         $.ajax({
//             type: 'PUT',
//             dataType: 'json',
//             url: '../update/' + $('#id').val(),
//             data:  $form.serialize(),
//             success: function(result) {
//                 if (result.statusCode === 200) {
//                     $.gritter.add({title: '操作结果', text: '更新成功', image:'../../image/confirm.png'});
//                 } else {
//                     $.gritter.add({title: '操作结果', text: '更新失败', image:'../../image/failure.jpg'});
//                 }
//             },
//             error: function (e) {
//                 var name = JSON.parse(e.responseText).errors.name;
//                 if(name =='The name has already been taken.'){
//                     $.gritter.add({title: '操作结果', text: '该学校下的年级已经存在', image:'../../image/failure.jpg'});
//                 }
//             }
//         });
//     }
// }).on('form:submit', function() { return false; });
