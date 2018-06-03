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
            type: 'POST',
            dataType: 'json',

            url: '../admins/store',
            data: $form.serialize(),
            success: function (result) {
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '添加成功', image:'../image/confirm.png'});
                } else if(result.statusCode === 400){
                    $.gritter.add({title: '操作结果', text: '该用户名已经存在,请重新注册!', image:'../image/error.png'});
                }else {
                    $.gritter.add({title: '操作结果', text: '添加失败', image:'../image/failure.png'});
                }
            }
        });
    }
}).on('form:submit', function () {
    return false;
});


