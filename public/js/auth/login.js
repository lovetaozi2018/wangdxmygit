$('#signin').on('click', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'login',
        data: {
            input: $('#input').val(),
            password: $('#password').val(),
            rememberMe: $('#remember').iCheck('update')[0].checked,
            _token: $('input[name="_token"]').val()
        },
        success: function (result) {
            if (result.statusCode === 200) {
                window.location = 'users/index';
            } else {
                $.gritter.add({
                    title: '登录',
                    text: '用户名/密码错误',
                    image: 'image/error.png'
                });
            }
        }
    })
});
