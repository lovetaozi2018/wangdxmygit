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
            { className: 'text-center', targets: [0, 1, 2, 3, 4] },
            { className: 'text-right', targets: [5] }
        ],
        scrollX: true,
        language: {url: '../files/ch.json'},
        lengthMenu: [[15, 25, 50, -1], [15, 25, 50, '所有']]
    });
}
initDatatable();

$(document).on('click', '.fa-trash', function () {
    var result = confirm("是否确认删除该年级?");
    var id = $(this).parents().eq(0).attr('id');
    if(result){
        $.ajax({
            type:'DELETE',
            dataType:'json',
            data:{ _token: $('#csrf_token').attr('content')},
            url:'../grades/delete/'+id,
            success:function (result) {
                if(result.statusCode === 200){
                    $.gritter.add({title: '操作结果', text: '删除成功', image:'../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();

                }else if(result.statusCode === 201){
                    $.gritter.add({title: '操作结果', text: '该年级下面还有班级,删除失败', image:'../image/failure.jpg'});
                }else if(result.statusCode === 404){
                    $.gritter.add({title: '操作结果', text: '你没有权限进行此操作', image:'../image/error.png'});
                }else{
                    $.gritter.add({title: '操作结果', text: '删除失败', image:'../image/failure.jpg'});
                }
            }
        })
    }
});