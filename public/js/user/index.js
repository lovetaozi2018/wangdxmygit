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
            { className: 'text-center', targets: [0, 1, 2] },
        ],
        scrollX: true,
        language: {url: '../files/ch.json'},
        lengthMenu: [[15, 25, 50, -1], [15, 25, 50, '所有']]
    });
}
initDatatable();