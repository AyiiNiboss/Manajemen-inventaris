@extends('layout.main')
@section('content')
<style>
    .form-select {
    display: block;
    width: 100%;
    padding: 0.4375rem 1.875rem 0.4375rem 0.875rem;
    -moz-padding-start: calc(0.875rem - 3px);
    font-size: 0.9375rem;
    font-weight: 400;
    line-height: 1.53;
    color: #697a8d;
    background-color: #fff;
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%2867, 89, 113, 0.6%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e);
    background-repeat: no-repeat;
    background-position: right 0.875rem center;
    background-size: 17px 12px;
    border: 1px solid #d9dee3;
    border-radius: 0.375rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    appearance: none;
    }
    .form-control {
    display: block;
    width: 100%;
    padding: 0.4375rem 0.875rem;
    font-size: 0.9375rem;
    font-weight: 400;
    line-height: 1.53;
    color: #697a8d;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d9dee3;
    appearance: none;
    border-radius: 0.375rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
div.dataTables_wrapper div.dataTables_paginate ul.pagination .page-link {
    padding: 0.625rem;
    min-width: calc( 2rem + 0px );
    font-size: .75rem;
    line-height: 1;
}
.page-item.active .page-link, .page-item.active .page-link:hover, .page-item.active .page-link:focus, .pagination li.active>a:not(.page-link), .pagination li.active>a:not(.page-link):hover, .pagination li.active>a:not(.page-link):focus {
    border-color: #cacbdc;
    background-color: #696cff;
    color: #fff;
    box-shadow: 0 0.125rem 0.25rem rgba(105,108,255,.4);
}
.page-item.active .page-link {
    margin: 0 0.1rem 0 0.3rem;
}
div.card-datatable {
    padding-bottom: 1rem;
}
.negative-stock {
        color: red;
    }
</style>
@if(Session::has('status'))
<div class="bs-toast toast toast-ex animate__animated my-2 fade bg-{{ Session::get('status') === 'error' ? 'danger' : 'success text-white' }} animate__flash hide"
    role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header">
        @if(Session::get('status') === 'error')
        <i class="bx bx-error-circle me-2"></i>
        <div class="me-auto fw-semibold">Error</div>
        @else
        <i class="bx bx-check-circle me-2"></i>
        <div class="me-auto fw-semibold">Success</div>
        @endif
        {{-- <small>11 mins ago</small> --}}
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ Session::get('pesan') }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var toastElement = document.querySelector('.toast');
      var toast = new bootstrap.Toast(toastElement);
      
      toast.show();
  
      setTimeout(function() {
          toast.hide();
      }, 5000);
  });
</script>
@endif
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Data /</span> Stok Barang
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Stok Barang</h5>
        <div class="container">
            <div class="card-datatable table-responsive text-nowrap">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal masuk</th>
                            <th class="text-center">stok tersisa</th>
                            {{-- <th class="text-center">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function () {
   
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
                    url: '{{ route('stok-barang') }}',
                    type: 'GET',
                },
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'barang_relasi.nama_barang', name: 'barang_id'},
              {data: 'tgl_masuk_formatted', name: 'tgl_masuk'},
              {data: 'sisa_stok', name: 'sisa_stok', className: 'text-center'},
              
          ]
          
      });
         
    });
  </script>
@endsection