<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('storage/Logo.png') }}" style="margin-left: -8px" width="30%" alt="">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        {{-- Menu Karyawan start --}}
        @if (Auth::user()->roleRelasi->nama_role == 'Karyawan')
        <li class="menu-item {{ Request::is('barang-keluar-add') ? 'active' : '' }}">
            <a href="{{ route('barang-keluar-add') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Buat Permintaan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('barang-keluar') ? 'active' : '' }}">
            <a href="{{ route('barang-keluar') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Daftar Barang Keluar</div>
            </a>
        </li>
        @endif
        {{-- Menu Karyawan end --}}

        {{-- Menu admin start --}}
        @if (Auth::user()->roleRelasi->nama_role == 'Admin')
        <li class="menu-item {{ Request::is(['barang-masuk-add','barang-mmasuk']) ? 'active' : '' }}">
            <a href="/layout" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Layouts">Barang Masuk</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is(['barang-masuk-add']) ? 'active' : '' }}">
                    <a href="{{ route('barang-masuk-add') }}" class="menu-link">
                        <div data-i18n="Without menu">Buat Barang Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['barang-masuk']) ? 'active' : '' }}">
                    <a href="{{ route('barang-masuk') }}" class="menu-link">
                        <div data-i18n="Without menu">Daftar Barang Masuk</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::is(['barang-keluar-acc','barang-keluar']) ? 'active' : '' }}">
            <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Layouts">Barang keluar</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is(['barang-keluar-acc']) ? 'active' : '' }}">
                    <a href="{{ route('barang-keluar-acc-tampil') }}" class="menu-link">
                        <div data-i18n="Without menu">ACC Barang Keluar</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['barang-keluar']) ? 'active' : '' }}">
                    <a href="{{ route('barang-keluar') }}" class="menu-link">
                        <div data-i18n="Without menu">Daftar Barang Keluar</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::is('stok-barang') ? 'active' : '' }}">
            <a href="{{ route('stok-barang') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Analytics">Stok Barang</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is(['barang','satuan','supplier']) ? 'active' : '' }}">
            <a href="/layout" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Layouts">Data</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is(['barang']) ? 'active' : '' }}">
                    <a href="{{ route('barang') }}" class="menu-link">
                        <div data-i18n="Without menu">Barang</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['satuan']) ? 'active' : '' }}">
                    <a href="{{ route('satuan') }}" class="menu-link">
                        <div data-i18n="Without menu">Satuan Barang</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('supplier') ? 'active' : '' }}">
                    <a href="{{ route('supplier') }}" class="menu-link">
                        <div data-i18n="Without navbar">Supplier Barang</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li
            class="menu-item {{ Request::is(['laporan-barang-masuk','laporan-barang-keluar','laporan-stok-barang']) ? 'active' : '' }}">
            <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Layouts">Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is(['laporan-barang-masuk']) ? 'active' : '' }}">
                    <a href="{{ route('laporan-pembelian') }}" class="menu-link">
                        <div data-i18n="Without menu">Laporan Barang Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['laporan-barang-keluar']) ? 'active' : '' }}">
                    <a href="{{ route('laporan-pengeluaran') }}" class="menu-link">
                        <div data-i18n="Without menu">Laporan Barang Keluar</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['laporan-stok-barang']) ? 'active' : '' }}">
                    <a href="{{ route('laporan-stok-barang') }}" class="menu-link">
                        <div data-i18n="Without menu">Laporan Stok Barang</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::is('pengguna-sistem') ? 'active' : '' }}">
            <a href="{{ Route('pengguna-sistem') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Pengguna Sistem</div>
            </a>
        </li>
        @endif
        {{-- Menu admin end --}}

        {{-- Menu Pimpinan start --}}
        @if (Auth::user()->roleRelasi->nama_role == 'Pimpinan')
        <li
            class="menu-item {{ Request::is(['laporan-barang-masuk','laporan-barang-keluar','laporan-stok-barang']) ? 'active' : '' }}">
            <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Layouts">Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is(['laporan-barang-masuk']) ? 'active' : '' }}">
                    <a href="{{ route('laporan-pembelian') }}" class="menu-link">
                        <div data-i18n="Without menu">Laporan Barang Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['laporan-barang-keluar']) ? 'active' : '' }}">
                    <a href="{{ route('laporan-pengeluaran') }}" class="menu-link">
                        <div data-i18n="Without menu">Laporan Barang Keluar</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is(['laporan-stok-barang']) ? 'active' : '' }}">
                    <a href="{{ route('laporan-stok-barang') }}" class="menu-link">
                        <div data-i18n="Without menu">Laporan Stok Barang</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        {{-- Menu Pimpinan end --}}
    </ul>
</aside>
<!-- / Menu -->

<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                {{-- lonceng start --}}
                @if (Auth::user()->role_id == 1)
                    @if (($notif_sisa_stok + $notif_barang_keluar + $notif_acc_akun) > 0)
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">
                                <i class="bx bx-bell bx-sm"></i>
                                <span class="badge bg-danger rounded-pill badge-notifications">{{ $notif_sisa_stok +
                                    $notif_barang_keluar + $notif_acc_akun }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                        <h5 class="text-body mb-0 me-auto">Pemberitahuan‼️</h5>
                                        <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                            data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read"
                                            data-bs-original-title="Mark all as read"></a>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container ps">
                                    <ul class="list-group list-group-flush">
                                        @if ($notif_acc_akun > 0)
                                        <a href="{{ route('pengguna-sistem') }}" style="width: 100%;color: #6c7d8f">
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Pengguna Sistem 🧑‍💻</h6>
                                                        <p class="mb-0">Ada {{ $notif_acc_akun }} akun yang butuh di verifikasi
                                                        </p>
                                                        {{-- <small class="text-muted">1h ago</small> --}}
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="{{ route('pengguna-sistem') }}"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </a>
                                        @endif
                                        @if($notif_barang_keluar > 0)
                                        <a href="{{ route('barang-keluar') }}" style="width: 100%;color: #6c7d8f">
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Permintaan Barang ✉️</h6>
                                                        <p class="mb-0">Kamu memiliki {{ $notif_barang_keluar }} request
                                                            permintaan barang</p>
                                                        {{-- <small class="text-muted">1h ago</small> --}}
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </a>
                                        @endif
                                        @if ($notif_sisa_stok > 0)
                                        <a href="{{ route('stok-barang') }}" style="width: 100%;color: #6c7d8f">
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Stok Habis ❌</h6>
                                                        <p class="mb-0">Kamu memiliki {{ $notif_sisa_stok }} barang yang stoknya
                                                            habis</p>
                                                        {{-- <small class="text-muted">1h ago</small> --}}
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </a>
                                        @endif
                                    </ul>
                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                    </div>
                                </li>
                                <li class="dropdown-menu-footer border-top">
                                    <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">

                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- lonceng end --}}
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            @if (!Auth::user()->foto_profil)
                            <img src="{{ asset('assets/img/avatars/1.png')}}" alt class="w-px-40 rounded-circle" />
                            @else
                            <img src="{{ asset('storage/foto profil/'.Auth::user()->foto_profil)}}" alt
                                class="w-px-40 rounded-circle" />
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#basicModal12">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            @if (!Auth::user()->foto_profil)
                                            <img src="{{ asset('assets/img/avatars/1.png')}}" alt
                                                class="w-px-40 rounded-circle" />
                                            @else
                                            <img src="{{ asset('storage/foto profil/'.Auth::user()->foto_profil)}}" alt
                                                class="w-px-40 rounded-circle" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block" style="text-transform: capitalize;">
                                            {{ Auth::user()->username }}</span>
                                        <small class="text-muted">{{ Auth::user()->roleRelasi->nama_role }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#basicModal12">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/logout">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>
    @if (request()->route()->getName() !== 'pengguna-sistem-edit')
    {{-- modal setting start --}}
    <div class="modal fade" id="basicModal12" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('setting-user', Auth::user()->id) }}" id="formAccountSettings" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
                            @if (Auth::user()->foto_profil != '')
                            <img src="{{ asset('storage/foto profil/'.Auth::user()->foto_profil) }}" alt="user-avatar"
                                class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            @else
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block rounded"
                                height="100" width="100" id="uploadedAvatar" />
                            @endif
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="image" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0" style="margin-top: -15px">Allowed JPG or PNG. Max size of
                                    800KB</p>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="nameBasic" class="form-label">Nama</label>
                                <input type="text" id="nameBasic" name="name" value="{{ Auth::user()->name }}"
                                    class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="col mb-0">
                                <label for="emailBasic" class="form-label">Email</label>
                                <input type="text" id="emailBasic" name="email" value="{{ Auth::user()->email }}"
                                    class="form-control" placeholder="xxxx@xxx.xx">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">Username</label>
                                <input type="text" id="dobBasic" name="username" value="{{ Auth::user()->username }}"
                                    class="form-control" placeholder="DD / MM / YY">
                            </div>
                            <div class="col mb-0">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="basic-default-password32">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" id="basic-default-password32"
                                            name="password" placeholder="············"
                                            aria-describedby="basic-default-password" fdprocessedid="2kvxc">
                                        <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- modal setting end --}}
    @endif

    <script>
        $(document).ready(function() {
          // Menandai submenu yang aktif
          $('.menu-sub .menu-item').each(function() {
              if ($(this).hasClass('active')) {
                  $(this).parents('.menu-item').addClass('active');
                  $(this).parents('.menu-sub').show();
              }
          });

          // Mengatur perilaku klik pada menu sub
          $('.menu-sub .menu-item').click(function(e) {
              e.stopPropagation();
              $(this).siblings().removeClass('active');
              $(this).addClass('active');
              $(this).parents('.menu-item').addClass('active');
              $(this).parents('.menu-sub').show();
          });

          // Menutup menu sub yang tidak aktif saat membuka submenu lainnya
          $('.menu-sub').on('show.bs.collapse', function() {
              $('.menu-sub').not(this).collapse('hide');
          });
      });
    </script>

    <!-- / Navbar -->