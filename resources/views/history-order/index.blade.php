@extends('layouts.app')

@section('content')
    <h1 class="px-4 pt-1 pb-3 text-3xl font-bold">
        <div class="flex flex-row flex-1">
            <span class="mr-5 self-center"> History Transaksi Pelanggan</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 self-center" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
    </h1>

    <div class="container">
        <table id="users-table" class="display w-100">
            <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Type</th>
                <th>Alamat</th>
                <th>Total</th>
            </tr>
            </thead>
        </table>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        $(document).ready(function () {
            function formatDetails(rowData) {
                let details = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>Items:</strong></td>' +
                    '<td>';

                if (rowData.food && rowData.food.length > 0) {
                    details += '<ul>';
                    rowData.food.forEach(function (item) {
                        details += '<li>' + item.name + ' (Price: ' + item.price + ')</li>';
                    });
                    details += '</ul>';
                } else {
                    details += 'No food items available.';
                }

                details += '</td></tr></table>';
                return details;
            }

            let dataTable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[2, 'desc']],
                ajax: "{{ url()->current()}}",
                columns: [
                    {
                        className: 'details-control',
                        orderable: false,
                        searchable: false,
                        data: null,
                        defaultContent: '',
                        render: function () {
                            return '<i class="fas fa-plus-circle text-green-500 cursor-pointer"></i>';
                        }
                    },
                    {data: 'user.name', name: 'user.name'},
                    {data: 'date', name: 'date'},
                    {data: 'type', name: 'type'},
                    {data: 'deliveryAddress', name: 'deliveryAddress'},
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-right',
                        render: $.fn.dataTable.render.number(',', '.', 0),
                    },
                ]
            });

            $('#users-table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dataTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').removeClass('fa-minus-circle text-red-500').addClass('fa-plus-circle text-green-500');
                } else {
                    // Open this row
                    row.child(formatDetails(row.data())).show();
                    tr.addClass('shown');
                    $(this).find('i').removeClass('fa-plus-circle text-green-500').addClass('fa-minus-circle text-red-500');
                }
            });
        });
    </script>
@endsection
