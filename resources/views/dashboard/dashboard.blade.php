@extends('layout.main')

@section('content')

@if(Session::has('status'))


<div
  class="bs-toast toast toast-ex animate__animated my-2 fade bg-{{ Session::get('status') === 'error' ? 'danger' : 'success text-white' }} animate__flash hide"
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
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-center row">
          <div class="col-sm-12">
            <div class="card-body text-center align-middle">
              <img src="{{ asset('storage/Logo.png') }}" width="20%" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (Auth::user()->role_id == 1)
  <div class="row">
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-primary h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-store"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_pembelian }}</h4>
          </div>
          <p class="mb-1 fw-bold text-uppercase">Barang Masuk</p>
          <p class="mb-0">
            <a href="{{ route('barang-masuk') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-warning h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-store"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_pengeluaran }}</h4>
          </div>
          <p class="mb-1 text-uppercase fw-bold">barang keluar</p>
          <p class="mb-0">
            <a href="{{ route('barang-keluar') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-danger h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-box"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_stok }}</h4>
          </div>
          <p class="mb-1 fw-bold text-uppercase">STok barang</p>
          <p class="mb-0">
            <a href="{{ route('stok-barang') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-info h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-info"><i class="bx bx-cog"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_user }}</h4>
          </div>
          <p class="mb-1 text-uppercase fw-bold">PENgguna sistem</p>
          <p class="mb-0">
            <a href="{{ route('pengguna-sistem') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->role_id == 3)
  <div class="row">
    <div class="col-sm-6 col-lg-4 mb-4">
      <div class="card card-border-shadow-primary h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-file"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_pembelian }}</h4>
          </div>
          <p class="mb-1 fw-bold text-uppercase">Laporan Barang Masuk</p>
          <p class="mb-0">
            <a href="{{ route('laporan-pembelian') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4">
      <div class="card card-border-shadow-warning h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-file"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_pengeluaran }}</h4>
          </div>
          <p class="mb-1 text-uppercase fw-bold"> laporan barang keluar</p>
          <p class="mb-0">
            <a href="{{ route('laporan-pengeluaran') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4">
      <div class="card card-border-shadow-danger h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-file"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $data_stok }}</h4>
          </div>
          <p class="mb-1 fw-bold text-uppercase">laporan STok barang</p>
          <p class="mb-0">
            <a href="{{ route('laporan-stok-barang') }}"><small class="text-muted">SELENGKAPNYA</small></a>
          </p>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->role_id == 2)
  <div class="row mt-5">
    <div class="col-lg-12 text-center">
      <h4 class="fw-bold">Galeri</h4> <hr>
    </div>
    <div class="col-lg-4 mb-3">
      <img class="card-img-top" src="{{ asset('assets/img/backgrounds/gambar_1.jpg') }}" alt="Card image cap">
    </div>
    <div class="col-lg-4">
      <img class="card-img-top" src="{{ asset('assets/img/backgrounds/gambar_2.jpg') }}" alt="Card image cap">
    </div>
    <div class="col-lg-4">
      <img class="card-img-top" src="{{ asset('assets/img/backgrounds/gambar_3.jpg') }}" alt="Card image cap">
    </div>
    <div class="col-lg-4">
      <img class="card-img-top" src="{{ asset('assets/img/backgrounds/gambar_4.jpg') }}" alt="Card image cap">
    </div>
    <div class="col-lg-4">
      <img class="card-img-top" src="{{ asset('assets/img/backgrounds/gambar_5.jpg') }}" alt="Card image cap">
    </div>
    <div class="col-lg-4">
      <img class="card-img-top" src="{{ asset('assets/img/backgrounds/gambar_6.jpg') }}" alt="Card image cap">
    </div>
  </div>
  @endif
</div>
@endsection