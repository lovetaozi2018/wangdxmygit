var table;
function initDatatable() {
   table = $('#data-table').dataTable({
       processing: true,
       serverSide: true,
       ajax: 'index',
       order: [[0, 'desc']],
       stateSave: true,
       autoWidth: true,
       columnDefs: [
           { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6, 7] },
           { className: 'text-right', targets: [8] }
       ],
       scrollX: true,
       language: {url: '../files/ch.json'},
       lengthMenu: [[15, 25, 50, -1], [15, 25, 50, '所有']]
   });
}
initDatatable();
// 新增记录
$('#add-record').on('click', function () {
    window.location = '../admins/create';
});

$(document).on('click', '.fa-trash', function () {
    var result = confirm("是否确认删除该管理员?");
    var id = $(this).parents().eq(0).attr('id');
    if(result){
        $.ajax({
            type:'DELETE',
            dataType:'json',
            data:{ _token: $('#csrf_token').attr('content')},
            url:'../admins/delete/'+id,
            success:function (result) {
                if(result.statusCode === 200){
                    $.gritter.add({title: '操作结果', text: '删除成功', image:'../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();
                }else{
                    $.gritter.add({title: '操作结果', text: '删除失败', image:'../../image/confirm.png'});
                }
            }
        })
    }
});