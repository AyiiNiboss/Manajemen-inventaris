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
        <span class="text-muted fw-light">Barang Keluar /</span> ACC Permintaan
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        {{-- <h5 class="card-header">Barang Masuk</h5> --}}
        <div class="container text-end">
        </div>
        <div class="table-responsive text-nowrap mt-5">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>nama</th>
                        <th class="text-center">status</th>
                        <th class="text-center">Catatan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y'); }}</td>
                        <td>{{ $item->userRelasi->name }}</td>
                        {{-- <td>{{ $item->obatRelasi->nama_obat }}</td> --}}
                        {{-- <td class="text-center">{{ $item->jumlah }}</td>
                        <td class="text-center">{{ $item->obatRelasi->satuanRelasi->name }}</td> --}}
                        <td class="text-center">
                            @if ($item->status == 1)
                            <span class="badge bg-label-warning">Menunggu</span>
                            @elseif($item->status == 2)
                            <span class="badge bg-label-success">DIproses</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->catatan ? $item->catatan : '-' }}</td>
                        <td class="text-center">
                            <div>
                                <a href="{{ route('barang-keluar-view', $item->id) }}"
                                    class="btn rounded-pill btn-icon btn-success" aria-label="view"
                                    data-bs-toggle="tooltip" data-bs-original-title="Lihat">
                                    <i class="bx bx-show-alt mx-1"></i>
                                </a>
                                {{-- <a href="{{ route('barang-masuk-delete', $item->id) }}"
                                    class="btn rounded-pill btn-icon btn-danger" data-bs-toggle="tooltip"
                                    aria-label="Delete" data-bs-original-title="Delete">
                                    <i class="bx bx-trash mx-1"></i>
                                </a> --}}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection