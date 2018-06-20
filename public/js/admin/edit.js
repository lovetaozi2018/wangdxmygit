Switcher.init();
var $form = $('#formAdmin');

$form.parsley().on('form:validated', function () {
    if($('.parsley-error').length === 0) {
        var pwd1 = $('#pwd1').val();
        var pwd2 = $('#pwd2').val();
        if(pwd2 !== pwd1){
            alert('两次输入密码不一致');
            return false;
        }
        $.ajax({
            type: 'put',
            dataType: 'json',
            url: '../update/' + $('#id').val(),
            data: $form.serialize(),
            success: function (result) {
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '更新成功', image:'../../image/confirm.png'});
                } else {
                    $.gritter.add({title: '操作结果', text: '更新失败', image:'../../image/failure.jpg'});
                }
            }
        });
    }
}).on('form:submit', function () {
    return false;
});