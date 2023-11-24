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
        <span class="text-muted fw-light">Data /</span> Barang
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Data Barang</h5>
        <div class="container text-end mb-2">
            <button type="button" class="btn btn-icon btn-twitter" data-bs-toggle="modal" data-bs-target="#basicModal"
                title="Tambah data obat" fdprocessedid="fn7wkf"><i class="tf-icons bx bx-plus"></i></button>
        </div>
        <div class="container">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Harga / satuan</th>
                            <th>Deskripsi Barang</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->satuanRelasi->nama_satuan }}</td>
                            <td> @money($item->harga_satuan)</td>
                            <td>{{ $item->deskripsi ? $item->deskripsi : '-' }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="" class="btn rounded-pill btn-icon btn-primary" aria-label="Edit" data-bs-toggle="modal"
                                        data-bs-target="#basicModal{{ $item->id }}" data-bs-original-title="Edit" title="Edit">
                                        <i class="bx bx-edit mx-1"></i>
                                    </a>
                                    {{-- <a href="{{ route('obat-delete', $item->id) }}" class="text-body"
                                        data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                        <i class="bx bx-trash mx-1"></i>
                                    </a> --}}
                                    <a href="{{ route('barang-delete', $item->id) }}" class="btn rounded-pill btn-icon btn-danger" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                        <i class="bx bx-trash mx-1"></i>
                                      </a>
                                </div>
                            </td>
                        </tr>

                        {{-- modal edit start--}}
                        <div class="modal fade" id="basicModal{{ $item->id }}" tabindex="-1" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form action="{{ route('barang-edit-proses', $item->id) }}" method="POST">
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
                                                    <label for="nameBasic" class="form-label">kode barang</label>
                                                    <input type="text" id="nameBasic" name="kode_barang"
                                                        class="form-control" value="{{ $item->kode_barang }}"
                                                        placeholder="Masukan kode barang">
                                                    @error('kode_barang')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="emailBasic" class="form-label">nama barang</label>
                                                    <input type="text" id="emailBasic" name="nama_barang"
                                                        class="form-control" value="{{ $item->nama_barang }}"
                                                        placeholder="Masukan nama barang">
                                                    @error('nama_barang')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col mb-3">
                                                    <label for="exampleFormControlSelect1"
                                                        class="form-label">Satuan</label>
                                                    <select class="form-select" name="satuan_id"
                                                        id="exampleFormControlSelect1"
                                                        aria-label="Default select example">
                                                        @foreach ($data_satuan as $item_satuan)
                                                        <option value="{{ $item_satuan->id }}" {{ $item_satuan->id ==
                                                            $item->satuan_id ? 'selected' : '' }} title="">{{
                                                            $item_satuan->nama_satuan }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('satuan_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="emailBasic" class="form-label">Harga satuan</label>
                                                    <input type="text" id="emailBasic" name="harga_satuan"
                                                        class="form-control" value="{{ $item->harga_satuan }}"
                                                        placeholder="Masukan harga barang">
                                                    @error('harga_satuan')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="exampleFormControlTextarea1" class="form-label">deskripsi barang</label>
                                                    <textarea class="form-control" name="deskripsi" id="exampleFormControlTextarea1"
                                                        rows="3">{{ $item->deskripsi }}</textarea>
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
        <form action="{{ route('barang-add') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">kode Barang</label>
                            <input type="text" id="nameBasic" name="kode_barang" class="form-control"
                                placeholder="Masukan kode barang" required>
                            @error('kode_obat')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label">nama barang</label>
                            <input type="text" id="emailBasic" name="nama_barang" class="form-control"
                                placeholder="Masukan nama barang" required>
                            @error('nama_obat')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Satuan barang</label>
                            <select class="form-select" name="satuan_id" id="exampleFormControlSelect1"
                                aria-label="Default select example">
                                <option selected disabled>-- Silahkan Pilih --</option>
                                @foreach ($data_satuan as $item)
                                <option value="{{ $item->id }}" title="">{{ $item->nama_satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label">Harga satuan</label>
                            <input type="text" id="emailBasic" name="harga_satuan" class="form-control"
                                placeholder="Masukan harga barang">
                            @error('harga_satuan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">deskripsi Obat</label>
                            <textarea class="form-control" name="deskripsi" id="exampleFormControlTextarea1"
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

<!-- Pastikan Anda sudah memasukkan library jQuery dan Select2 sebelum script ini -->
@endsection