Switcher.init();
$(document).ready(function() {
    $('.select2').select2();
});
var $form = $('#formSquad');
$form.parsley().on('form:validated', function () {
    if($('.parsley-error').length === 0) {

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../classes/store',
            data: $form.serialize(),
            success: function (result) {
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '添加成功', image:'../image/confirm.png'});
                } else {
                    $.gritter.add({title: '操作结果', text: '添加失败', image:'../image/failure.jpg'});
                }
            },
            error: function (result) {
               // var name = JSON.parse(result.responseText).errors.name;
               // if(name =='The name has already been taken.'){
               //     $.gritter.add({title: '操作结果', text: '该学校下的年级已经存在', image:'../image/failure.jpg'});
               // }
            }
        });
    }
}).on('form:submit', function () {
    return false;
});

