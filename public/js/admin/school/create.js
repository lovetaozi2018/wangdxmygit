Switcher.init();

var $form = $('#formSchool');
var $mobile = $('#mobile');
$form.parsley().on('form:validated', function () {
    if($('.parsley-error').length === 0) {
        if (
            $mobile.val() === '' || $mobile.val().length === 0 ||
            !(/^1[3|4|5|7|8]\d{9}$/.test($mobile.val()))
        ) {
            alert('输入错误');
            return false;
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../schools/store',
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

