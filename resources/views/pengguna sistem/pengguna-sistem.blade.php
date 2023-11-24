@extends('layout.main')

@section('content')

@if(Session::has('status'))

    
  <div class="bs-toast toast toast-ex animate__animated my-2 fade bg-{{ Session::get('status') === 'error' ? 'danger' : 'success text-white' }} animate__flash hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
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
        <span class="text-muted fw-light">Pengguna Sistem
    </h4>
    <!-- Responsive Table -->
    @if (!$user_aktivasi->isEmpty())
    <div class="card mb-5">
        <h5 class="card-header">Aktivasi Akun</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No</th>
                        <th>Nama</th>
                        <th>email</th>
                        <th>username</th>
                        <th>role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_aktivasi as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->username }}</td>
                        <td>
                            <span class="text-truncate d-flex align-items-center">
                                <span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">
                                    <i class="bx {{ ($item->role_id == 1) ? 'bx-pie-chart-alt' : (($item->role_id == 2) ? 'bx-mobile-alt' : 'bx-user') }} bx-xs"></i>
                                </span> {{ $item->roleRelasi->nama_role }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div>
                                <a href="{{ route('acc-user', $item->id) }}" class="btn rounded-pill btn-icon btn-primary" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Setuju">
                                    <span class="tf-icons bx bxs-user-check"></span>
                                  </a>
                                <a href="{{ route('tolak-user', $item->id) }}" class="btn rounded-pill btn-icon btn-warning" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Tolak">
                                    <span class="tf-icons bx bxs-user-x"></span>
                                  </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <div class="card">
        <h5 class="card-header">Daftar Pengguna Sistem</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No</th>
                        <th>Nama</th>
                        <th>email</th>
                        <th>username</th>
                        <th>role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->username }}</td>
                        <td>
                            <span class="text-truncate d-flex align-items-center">
                                <span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">
                                    <i class="bx {{ ($item->role_id == 1) ? 'bx-pie-chart-alt' : (($item->role_id == 2) ? 'bx-mobile-alt' : 'bx-user') }} bx-xs"></i>
                                </span> {{ $item->roleRelasi->nama_role }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div>
                                <a href="{{ route('pengguna-sistem-edit', $item->id) }}" class="btn rounded-pill btn-icon btn-secondary" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                    <span class="tf-icons bx bx-edit"></span>
                                  </a>
                                <a href="{{ route('pengguna-sistem-delete', $item->id) }}" class="btn rounded-pill btn-icon btn-danger" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                    <span class="tf-icons bx bx-trash"></span>
                                  </a>
                                {{-- <a href="{{ route('account-detail', $item->id) }}" class="text-body" data-bs-toggle="tooltip"
                                    aria-label="Preview" data-bs-original-title="Preview">
                                    <i class="bx bx-show-alt mx-1"></i>
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

@endsection