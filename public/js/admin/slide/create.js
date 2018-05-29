Switcher.init();

$(document).ready(function() {
    $('.select2').select2();
});

var $form = $('#formSlide');
$('#save').on('click', function (e) {
    e.preventDefault();
    var formData = new FormData();
    var schoolId = $('#school_id').val();
    var enabled = $('#enabled').val();
    if(enabled==='on'){
        enabled = 1;
    }else{
        enabled = 0;
    }


    var img = $('#fileImg')[0];
    for(var i =0; i<img.files.length;i++){
        // console.log(img.files[i]);
        formData.append("fileImg[]", img.files[i]);
    }

    formData.append("school_id", schoolId);
    formData.append('enabled',enabled);
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


