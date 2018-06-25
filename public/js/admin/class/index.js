var table;
function initDatatable() {
    table = $('#data-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: 'index',
        order: [[0, 'asc']],
        stateSave: true,
        autoWidth: true,
        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6] },
            { className: 'text-right', targets: [7] }
        ],
        scrollX: true,
        language: {url: '../files/ch.json'},
        lengthMenu: [[5, 10, 15, -1], [5, 10, 15, '所有']]
    });
}
initDatatable();

$(document).on('click', '.fa-trash', function () {
    var result = confirm("是否确认删除该班级?");
    var id = $(this).parents().eq(0).attr('id');
    if(result){
        $.ajax({
            type:'DELETE',
            dataType:'json',
            data:{ _token: $('#csrf_token').attr('content')},
            url:'../classes/delete/'+id,
            success:function (result) {
                if(result.statusCode === 200){
                    $.gritter.add({title: '操作结果', text: '删除成功', image:'../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();

                }else if(result.statusCode === 201){
                    $.gritter.add({title: '操作结果', text: '该班级下面有学生,不能删除', image:'../image/failure.jpg'});
                }else if(result.statusCode === 202){
                    $.gritter.add({title: '操作结果', text: '该班级下面有视频,不能删除', image:'../image/failure.jpg'});
                }else if(result.statusCode === 404){
                    $.gritter.add({title: '操作结果', text: '你没有权限进行此操作', image:'../image/error.png'});
                }else{
                    $.gritter.add({title: '操作结果', text: '删除失败', image:'../image/failure.jpg'});
                }
            }
        })
    }
});

$(document).on('click', '.fa-qrcode', function () {
    var id = $(this).parents().eq(0).attr('id');
    var result = confirm("是否确认要生成二维码?");
    if(result) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {'id': id, _token: $('#csrf_token').attr('content')},
            url: '../classes/makeCode',
            success: function (result) {
                console.log(result);
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '二维码创建成功', image: '../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();

                } else {
                    $.gritter.add({title: '操作结果', text: '创建失败', image: '../image/error.png'});
                }
            }
        })
    }
});