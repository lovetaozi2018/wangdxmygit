Switcher.init();
var $form = $('#formUser');
$form.parsley().on('form:validated', function () {
    if($('.parsley-error').length === 0) {

        $.ajax({
            type: 'put',
            dataType: 'json',
            url: '../update/' + $('#id').val(),
            data: $form.serialize(),
            success: function (result) {
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '更新成功', image:'../../image/confirm.png'});
                }else if(result.statusCode === 201)
                {
                    $.gritter.add({title: '操作结果', text: '手机号码已经存在', image:'../../image/failure.jpg'});
                } else {
                    $.gritter.add({title: '操作结果', text: '更新失败', image:'../../image/failure.jpg'});
                }
            }
        });
    }
}).on('form:submit', function () {
    return false;
});