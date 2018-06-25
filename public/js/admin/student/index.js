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
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] },
            { className: 'text-right', targets: [11] }
        ],
        scrollX: true,
        language: {url: '../files/ch.json'},
        lengthMenu: [[15, 25, 50, -1], [15, 25, 50, '所有']]
    });
}
initDatatable();

$(document).on('click', '.fa-trash', function () {
    var result = confirm("是否确认删除该学生?");
    var id = $(this).parents().eq(0).attr('id');
    if(result){
        $.ajax({
            type:'DELETE',
            dataType:'json',
            data:{ _token: $('#csrf_token').attr('content')},
            url:'../students/delete/'+id,
            success:function (result) {
                if(result.statusCode === 200){
                    $.gritter.add({title: '操作结果', text: '删除成功', image:'../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();

                }else{
                    $.gritter.add({title: '操作结果', text: '删除失败', image:'../image/error.png'});
                }
            }
        })
    }
});

var $import = $('#import');
var $importPupils = $('#import-pupils');
var $file = $('#confirm-import');
$import.on('click', function () {
    $importPupils.modal({backdrop: true});
    $file.off('click');
    $file.on('click', function () {
        var formData = new FormData();

        formData.append('file', $('#fileupload')[0].files[0]);

        formData.append('_token', $('#csrf_token').attr('content'));
        $.ajax({
            url: "../students/import",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (result) {
                console.log(result);
                if (result.statusCode === 200) {
                    $.gritter.add({title: '操作结果', text: '导入成功', image:'../image/confirm.png'});
                    table.fnDestroy();
                    initDatatable();
                } else {
                    $.gritter.add({title: '操作结果', text: '导入失败', image:'../image/failure.jpg'});
                }
            },
            // error: function (result) {
            //     console.log(result);
            //     $.gritter.add({title: '操作结果', text: '删除失败', image:'../image/error.png'});
            //
            // }
        });
    })
});