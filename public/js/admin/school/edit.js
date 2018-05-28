Switcher.init();

var $form = $('#formSchool');

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
            error: function(e) {

            }
        });
    }
}).on('form:submit', function() { return false; });
