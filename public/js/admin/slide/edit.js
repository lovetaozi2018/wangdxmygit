Switcher.init();

KindEditor.ready(function(K) {
    var editor = K.create('#content', {
        resizeType: 0,
        langType : 'zh-CN',
        allowFileManager: true,
        afterBlur: function () { this.sync(); }

    });
});

function preview(file) {
    var prevDiv = document.getElementById('preview');
    if (file.files && file.files[0]) {
        var reader = new FileReader();
        reader.onload = function (evt) {
            prevDiv.style.display = 'block';
            prevDiv.innerHTML = '<img src="' + evt.target.result + '" style="height: 100px;margin-top: 5px;"/>';
        };
        reader.readAsDataURL(file.files[0]);
    }
    else {
        prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
    }
}

$(document).ready(function() {
    $('.select2').select2();
});

var $form = $('#formSlide');
$('#save').on('click', function (e) {
    e.preventDefault();
    var formData = new FormData();
    var schoolId = $('#school_id').val();
    var enabled = $('#enabled').val();
    var content = $('#content').val();
    if(enabled==='on'){
        enabled = 1;
    }else{
        enabled = 0;
    }

    var img = $('#fileImg')[0].files[0];
    // console.log(img);return false;
    if (!img) {
        img= '';

    }

    formData.append("fileImg", img);
    formData.append("school_id", schoolId);
    formData.append('enabled',enabled);
    formData.append('content',content);
    formData.append("_token", $('#csrf_token').attr('content'));
    formData.append("fileImg",img);

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../update/' + $('#id').val(),
        processData:false,
        contentType:false,
        data:formData,
        success: function (result) {
            if (result.statusCode === 200) {
                $.gritter.add({title: '操作结果', text: '添加成功', image:'../../image/confirm.png'});
            } else {
                $.gritter.add({title: '操作结果', text: '添加失败', image:'../../image/failure.jpg'});
            }
        },
        error: function (result) {

        }
    });
});
