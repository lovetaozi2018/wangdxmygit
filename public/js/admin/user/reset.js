$('#reset').on('click', function (e) {
    e.preventDefault();
    var password = document.getElementsByName("password")[0];
    var pwd1 = document.getElementsByName('pwd1')[0];
    var pwd2 = document.getElementsByName('pwd2')[0];

    if (password.value === '') {
        $.gritter.add({title: '操作结果', text: '原密码不能为空', image:'../image/error.png'});

        password.focus();
        return false;
    }
    // else if (pwd1.replace(/^\s*|\s*$/g, "") === '') {
    //     $.gritter.add({title: '操作结果', text: '新密码不正确，请勿使用空格!', image:'../image/error.png'});
    //     pwd1.focus();
    //     return false;
    // }
    else if (pwd1.value === '') {
        $.gritter.add({title: '操作结果', text: '新密码不能为空!', image:'../image/error.png'});
        pwd1.focus();
        return false;
    } else if (password.value === pwd1.value) {
        $.gritter.add({title: '操作结果', text: '新密码不能不能和原密码相同!', image:'../image/error.png'});
        pwd1.focus();
        return false;
    } else if (pwd2.value === '') {
        $.gritter.add({title: '操作结果', text: '确认密码不能为空!', image:'../image/error.png'});
        pwd2.focus();
        return false;
    } else if (pwd1.value !== pwd2.value) {
        $.gritter.add({title: '操作结果', text: '两次密码不一致!', image:'../image/error.png'});
        pwd2.focus();
        return false;
    }

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'reset',
        data: {
            password: password.value,
            pwd: pwd1.value,
            _token: $('#csrf_token').attr('content')
        },
        success: function (result) {
            if (result.statusCode === 400) {
                $.gritter.add({title: '操作结果', text: '原密码输入不正确,请重新输入!', image:'../image/error.png'});

            }if(result.statusCode === 401) {
                $.gritter.add({title: '操作结果', text: '请填写正确的密码!', image:'../image/error.png'});
            } else if (result.statusCode === 200) {
                $.gritter.add({title: '操作结果', text: '修改成功!', image:'../image/confirm.png'});
                window.location = '../logout';
            }
        }
    }).on('form:submit', function () {
        return false;
    });
});