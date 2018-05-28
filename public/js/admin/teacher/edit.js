Switcher.init();

var $form = $('#formTeacher');
var $mobile = $('#mobile');

$form.parsley().on('form:validated', function() {

    if ($('.parsley-error').length === 0) {
        $.ajax({
            type: 'PUT',
            dataType: 'json',
            url: '../update/' + $('#id').val(),
            data:  $form.serialize(),
            success: function(result) {
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '更新成功', image:'../../image/confirm.png'});
                } else {
                    $.gritter.add({title: '操作结果', text: '更新失败', image:'../../image/failure.png'});
                }
            },
            error: function (e) {
                var name = JSON.parse(e.responseText).errors.name;
                if(name =='The name has already been taken.'){
                    $.gritter.add({title: '操作结果', text: '该学校下的年级已经存在', image:'../../image/failure.jpg'});
                }
            }
        });
    }
}).on('form:submit', function() { return false; });
