$('#data-table').dataTable({
    processing: true,
    serverSide: true,
    ajax: 'index',
    order: [[0, 'desc']],
    stateSave: true,
    columnDefs: [
        { className: 'text-right', targets: [2, 6, 7, 8] },
        { className: 'text-center', targets: [0, 1, 3, 4, 5, 9] }
    ],
    autoWidth: true,
    scrollX: true,
    language: {url: '../files/ch.json'},
    lengthMenu: [[15, 25, 50, -1], [15, 25, 50, '所有']]
});