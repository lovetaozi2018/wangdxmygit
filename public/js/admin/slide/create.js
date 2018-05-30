Switcher.init();

KindEditor.ready(function(K) {
    var editor = K.create('#content', {
        resizeType: 0,
        langType : 'zh-CN',
        allowFileManager: true,
        afterBlur: function () { this.sync(); }

    });
});

function preview(file) {
    var prevDiv = document.getElementById('preview');
    if (!file.files) {
        prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        return;
    }
    [].forEach.call(file.files, function (item) {
        var reader = new FileReader();
        reader.onload = function (evt) {
            prevDiv.style.display = 'block';
            prevDiv.innerHTML = prevDiv.innerHTML + '<img src="' + evt.target.result + '" style="height: 100px;margin-top: 5px;margin-right:5px"/>';
        };
        reader.readAsDataURL(item);
    });
    // if (file.files && file.files[0]) {
    //     var reader = new FileReader();
    //     reader.onload = function (evt) {
    //         prevDiv.style.display = 'block';
    //         prevDiv.innerHTML = '<img src="' + evt.target.result + '" style="height: 100px;margin-top: 5px;"/>';
    //     };
    //     reader.readAsDataURL(file.files[0]);
    // }
    // else {
    //     prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
    // }
}

$(document).ready(function() {
    $('.select2').select2();
});

var $form = $('#formSlide');
$('#save').on('click', function (e) {
    e.preventDefault();
    var formData = new FormData();
    var schoolId = $('#school_id').val();
    var enabled = $('#enabled').val();
    var content = $('#content').val();
    if(enabled==='on'){
        enabled = 1;
    }else{
        enabled = 0;
    }

    var img = $('#fileImg')[0];
    if(img.files.length === 0){
        $.gritter.add({title: '操作结果', text: '请上传图片', image:'../image/failure.jpg'});
        return false;
    }
    if(!content){
        $.gritter.add({title: '操作结果', text: '内容不能为空', image:'../image/failure.jpg'});
        return false;
    }
    for(var i =0; i<img.files.length;i++){
        // console.log(img.files[i]);
        formData.append("fileImg[]", img.files[i]);
    }

    formData.append("school_id", schoolId);
    formData.append('enabled',enabled);
    formData.append('content',content);
    formData.append("_token", $('#csrf_token').attr('content'));
    formData.append("fileImg",img);

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../slides/store',
        processData:false,
        contentType:false,
        data:formData,
        success: function (result) {
            if (result.statusCode === 200) {
                $.gritter.add({title: '操作结果', text: '添加成功', image:'../image/confirm.png'});
            } else {
                $.gritter.add({title: '操作结果', text: '添加失败', image:'../image/failure.jpg'});
            }
        },
        error: function (result) {
            var name = JSON.parse(result.responseText).errors.name;
            if(name =='The name has already been taken.'){
                $.gritter.add({title: '操作结果', text: '该学校下的年级已经存在', image:'../image/failure.jpg'});
            }
        }
    });
});
// $form.parsley().on('form:validated', function () {
//     if($('.parsley-error').length === 0) {
// //
//         $.ajax({
//             type: 'POST',
//             dataType: 'json',
//             url: '../slides/store',
//             data: $form.serialize(),
//             success: function (result) {
//                 if (result.statusCode === 200) {
//                     $.gritter.add({title: '操作结果', text: '添加成功', image:'../image/confirm.png'});
//                 } else {
//                     $.gritter.add({title: '操作结果', text: '添加失败', image:'../image/failure.jpg'});
//                 }
//             },
//             error: function (result) {
//                 var name = JSON.parse(result.responseText).errors.name;
//                 if(name =='The name has already been taken.'){
//                     $.gritter.add({title: '操作结果', text: '该学校下的年级已经存在', image:'../image/failure.jpg'});
//                 }
//             }
//         });
    // }
// }).on('form:submit', function () {
//     return false;
// });


