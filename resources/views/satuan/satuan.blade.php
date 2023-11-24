@extends('layout.main')
@section('content')

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
        <span class="text-muted fw-light">Data /</span> Satuan Barang
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Satuan Barang</h5>
        <div class="container text-end">
            <button type="button" class="btn btn-icon btn-twitter" data-bs-toggle="modal" data-bs-target="#smallModal"
                title="Tambah satuan Barang" fdprocessedid="fn7wkf"><i class="tf-icons bx bx-plus"></i></button>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No</th>
                        <th>Nama</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->nama_satuan }}</td>
                        <td class="text-center">
                            <div>
                                <a href="" class="btn rounded-pill btn-icon btn-primary" aria-label="Edit" data-bs-toggle="modal"
                                    data-bs-target="#smallModal{{ $item->id }}" data-bs-original-title="Edit">
                                    <i class="bx bx-edit mx-1"></i>
                                </a>
                                <a href="{{ route('satuan-delete', $item->id) }}"
                                    class="btn rounded-pill btn-icon btn-warning" data-bs-toggle="tooltip"
                                    aria-label="Delete" data-bs-original-title="Tolak">
                                    <i class="bx bx-trash mx-1"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- modal edit start --}}
                    <div class="modal fade" id="smallModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <form action="{{ route('satuan-edit-proses', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel2">Satuan Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameSmall" class="form-label">Nama</label>
                                                <input type="text" id="nameSmall" name="nama_satuan"
                                                    value="{{ $item->nama_satuan }}" class="form-control"
                                                    placeholder="Enter Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- modal edit end --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

{{-- modal tambah --}}
<div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <form action="{{ route('satuan-add') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Satuan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Nama</label>
                            <input type="text" id="nameSmall" name="nama_satuan" class="form-control"
                                placeholder="Enter Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection