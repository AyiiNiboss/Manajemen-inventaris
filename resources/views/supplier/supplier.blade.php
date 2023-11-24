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
        <span class="text-muted fw-light">Data /</span> Supplier Barang
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Supplier Barang</h5>
        <div class="container text-end mb-2">
            <button type="button" class="btn btn-icon btn-twitter" data-bs-toggle="modal" data-bs-target="#basicModal"
                title="Tambah data Barang" fdprocessedid="fn7wkf"><i class="tf-icons bx bx-plus"></i></button>
        </div>
        <div class="container">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>No</th>
                            <th>Nama</th>
                            <th>alamat</th>
                            <th>no telpon</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="text-capitalize">{{ $item->nama_supplier }}</td>
                            <td>{{ $item->alamat ? $item->alamat : '-' }}</td>
                            <td>{{ $item->no_telpon ? $item->no_telpon : '-' }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="" class="btn rounded-pill btn-icon btn-primary" aria-label="Edit" data-bs-toggle="modal"
                                        data-bs-target="#basicModal{{ $item->id }}" data-bs-original-title="Edit">
                                        <i class="bx bx-edit mx-1"></i>
                                    </a>
                                    <a href="{{ route('supplier-delete', $item->id) }}" class="btn rounded-pill btn-icon btn-warning" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Tolak">
                                        <i class="bx bx-trash mx-1"></i>
                                      </a>
                                </div>
                            </td>
                        </tr>

                        {{-- modal edit start--}}
                        <div class="modal fade" id="basicModal{{ $item->id }}" tabindex="-1" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form action="{{ route('supplier-edit', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Edit data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="col mb-3">
                                                    <label for="nameBasic" class="form-label">NAMA</label>
                                                    <input type="text" id="nameBasic" name="nama_supplier" value="{{ $item->nama_supplier }}" class="form-control"
                                                        placeholder="Masukan nama supplier" required>
                                                    @error('nama')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="emailBasic" class="form-label">NOMOR TELPON</label>
                                                    <input type="text" id="emailBasic" name="no_telpon" value="{{ $item->no_telpon }}"
                                                        class="form-control"
                                                        placeholder="Masukan nomor telepon supplier">
                                                    @error('no_telpon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="exampleFormControlTextarea1"
                                                        class="form-label">Alamat</label>
                                                    <textarea class="form-control" name="alamat"
                                                        id="exampleFormControlTextarea1" rows="3">{{ $item->alamat }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- modal edit end--}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

{{-- modal tambah start--}}
<div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('supplier-add') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">NAMA</label>
                            <input type="text" id="nameBasic" name="nama_supplier" class="form-control"
                                placeholder="Masukan nama supplier" required>
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label">NOMOR TELPON</label>
                            <input type="text" id="emailBasic" name="no_telpon" class="form-control"
                                placeholder="Masukan nomor telepon supplier">
                            @error('no_telpon')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- modal tambah end--}}

@endsection