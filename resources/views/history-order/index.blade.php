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
    <div class="table-responsive">
      <table id="users-table" class="table table-striped">
        <thead>
        <tr>
          <th></th>
          <th>ID</th>
          <th>Tanggal</th>
          <th>Type</th>
          <th>Status</th>
          <th>Status Pembayaran</th>
          <th>Alamat</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
  {{--  Modal --}}
  <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">Select Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="formUpdate" action="#">
          <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" name="status" id="status">
                <option value="selesai">Selesai</option>
                <option value="proses">Proses</option>
                <option value="batal">Batal</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      let modalEdit = document.getElementById('modalEdit');
      const bsEdit = new bootstrap.Modal(modalEdit);

      modalEdit.addEventListener('show.bs.modal', function (event) {
        let status = event.relatedTarget.getAttribute('data-bs-status');
        this.querySelector('select[name=status]').value = status;
        this.querySelector('.formUpdate').setAttribute('action', '{{ url()->current() }}/' + event.relatedTarget.getAttribute('data-bs-id'));
      });

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
        responsive: true,
        scrollX: false,
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
          {
            data: 'type',
            name: 'type',
            className: 'text-center',
            render: function (data, type) {
              if (type === 'display') {
                return data === 'pickup'
                  ? '<span class="badge bg-primary">Pickup</span>'
                  : '<span class="badge bg-dark">Delivery</span>';
              }
              return data;
            }
          },
          {
            data: 'status',
            name: 'status',
            className: 'text-center',
            render: function (data, type) {
              if (type !== 'display') return data;
              const badges = {
                sukses: 'bg-success',
                proses: 'bg-warning',
                batal: 'bg-danger'
              };
              return `<span class="badge ${badges[data] || 'bg-secondary'}">${data}</span>`;
            }
          },
          {data: 'status_pembayaran', name: 'status_pembayaran'},
          {data: 'deliveryAddress', name: 'deliveryAddress'},
          {
            data: 'total',
            name: 'total',
            className: 'text-right',
            render: $.fn.dataTable.render.number(',', '.', 0),
          },
          {data: 'action', name: 'action', className: 'text-center', width: '50px'},
        ], rowCallback: function (row, data) {
          let api = this.api();
          $(row).find('.btn-delete').click(function () {
            let pk = $(this).data('id'),
              url = `{{ url()->current() }}/` + pk;
            Swal.fire({
              title: "Anda Yakin ?",
              text: "Data tidak dapat dikembalikan setelah di hapus!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Hapus!",
              cancelButtonText: "Tidak, Batalkan",
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  url: url,
                  type: "DELETE",
                  data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                  },
                  error: function (response) {
                    toastr.error(response, 'Failed !');
                  },
                  success: function (response) {
                    if (response.status === "success") {
                      toastr.success(response.message, 'Success !');
                      api.draw();
                    } else {
                      toastr.error((response.message ? response.message : "Please complete your form"), 'Failed !');
                    }
                  }
                });
              }
            });
          });
        },
        footerCallback: function (row, data, start, end, display) {
          let api = this.api();
          let intVal = function (i) {
            return typeof i === 'string' ?
              i.replace(/[\$,]/g, '') * 1 :
              typeof i === 'number' ?
                i : 0;
          };

          let totalPengajuan = api
            .column(4)
            .data()
            .reduce(function (a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          $(api.column(4).footer()).html(`${$.fn.dataTable.render.number(',', '.', 0).display(totalPengajuan)}`);
        },
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

      $(".formUpdate").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find("[type='submit']");
        let btnSubmitHtml = btnSubmit.html();
        let url = form.attr("action");
        let data = new FormData(this);
        $.ajax({
          beforeSend: function () {
            btnSubmit.addClass("disabled").html("<span aria-hidden='true' class='spinner-border spinner-border-sm' role='status'></span> Loading ...").prop("disabled", "disabled");
          },
          cache: false,
          processData: false,
          contentType: false,
          type: "POST",
          url: url,
          data: data,
          success: function (response) {
            let errorCreate = $('#errorCreate');
            errorCreate.css('display', 'none');
            errorCreate.find('.alert-text').html('');
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            if (response.status === "success") {
              toastr.success(response.message, 'Success !');
              dataTable.draw();
              bsEdit.hide();
            } else {
              toastr.error((response.message ? response.message : "Please complete your form"), 'Failed !');
              if (response.error !== undefined) {
                errorCreate.removeAttr('style');
                $.each(response.error, function (key, value) {
                  errorCreate.find('.alert-text').append('<span style="display: block">' + value + '</span>');
                });
              }
            }
          },
          error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });

    });
  </script>
@endsection
