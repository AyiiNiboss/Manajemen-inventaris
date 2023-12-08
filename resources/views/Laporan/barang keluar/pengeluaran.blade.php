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
        <span class="text-muted fw-light">Laporan /</span> Barang Keluar
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        {{-- <h5 class="card-header">Barang Masuk</h5> --}}
        <div class="card-body">
            <div class="row mt-5">
                <div class="col-12">
                    <form action="{{ route('filter-barang-keluar') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-4">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control dt-input dt-full-name" name="start_date" required>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control dt-input dt-full-name" name="end_date" required>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 text-center d-flex align-items-end justify-content-start"
                                style="gap: 2px; margin-left: -6px">
                                <button class="dt-button add-new btn btn-info" type="submit"><span><i
                                            class="bx bx-plus me-0 me-sm-1"></i><span
                                            class="d-none d-sm-inline-block">Filter</span></span></button>
                                <a href="{{ route('laporan-pengeluaran') }}" class="btn btn-icon btn-dark"
                                    title="Refresh">
                                    <span class="tf-icons bx bx-refresh"></span>
                                </a>

                                @if(request('start_date') && request('end_date'))
                                <a href="{{ route('pengeluaran-all-pdf-filter', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-icon btn-google-plus"
                                    title="Export PDF" target="_blank">
                                    <span class="tf-icons bx bxs-file-pdf"></span>
                                </a>
                                @else
                                <a href="{{ route('pengeluaran-all-pdf') }}" class="btn btn-icon btn-google-plus"
                                    title="Export PDF" target="_blank">
                                    <span class="tf-icons bx bxs-file-pdf"></span>
                                </a>
                                <a href="{{ route('pengeluaran-excels') }}" class="btn btn-icon"
                                    title="Excel" style="background-color: #5fa9a8">
                                    <span class="tf-icons bx bxs-file-export text-white"></span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <div class="table-responsive text-nowrap mt-4">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>nama</th>
                        <th class="text-center">Catatan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                        <!-- Cek apakah data kosong -->
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @else
                    @foreach ($data as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y'); }}</td>
                        <td>{{ $item->userRelasi->name }}</td>
                        <td class="text-center">{{ $item->catatan ? $item->catatan : '-' }}</td>
                        <td class="text-center">
                            <div>
                                <a href="{{ route('laporan-pengeluaran-view', $item->id) }}"
                                    class="btn rounded-pill btn-icon btn-success" aria-label="view"
                                    data-bs-toggle="tooltip" data-bs-original-title="Lihat">
                                    <i class="bx bx-show-alt mx-1"></i>
                                </a>
                                <a href="{{ route('pengeluaran-pdf', $item->id) }}"
                                    class="btn btn-icon rounded-pill btn-google-plus" aria-label="view"
                                    data-bs-toggle="tooltip" data-bs-original-title="Export PDF" target="_blank">
                                    <i class="tf-icons bx bxs-file-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection