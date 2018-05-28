Switcher.init();
var $form = $('#formRate');
$form.parsley().on('form:validated', function () {
    if($('.parsley-error').length === 0) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../rates/store',
            data: $form.serialize(),
            success: function (result) {
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '添加成功', image:'../image/confirm.png'});
                } else {
                    $.gritter.add({title: '操作结果', text: '添加失败', image:'../image/failure.png'});
                }
            }
        });
    }
}).on('form:submit', function () {
    return false;
});
