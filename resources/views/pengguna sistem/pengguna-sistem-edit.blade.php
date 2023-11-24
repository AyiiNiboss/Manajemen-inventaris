@extends('layout.main')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <form action="/pengguna-sistem-edit/proses/{{ $data->id }}" id="formAccountSettings" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @if ($data->foto_profil != '')
                            <img src="{{ asset('storage/foto profil/'.$data->foto_profil) }}" alt="user-avatar"
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

                                <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 800KB</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="firstName" class="form-label">Nama</label>
                                <input class="form-control" type="text" id="firstName" name="name"
                                    value="{{ $data->name }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">username</label>
                                <input class="form-control" type="text" name="username" id="lastName"
                                    value="{{ $data->username }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    value="{{ $data->email }}" placeholder="john.doe@example.com" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="language" class="form-label">Role</label>
                                <select id="language" name="role_id" class="select2 form-select">
                                    @foreach ($role as $item_satuan)
                                    <option value="{{ $item_satuan->id }}" {{ $item_satuan->id == $data->role_id ? 'selected' : '' }} title="">{{ $item_satuan->nama_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="language" class="form-label">Reset Password</label>
                                <div>
                                    <a href="{{ route('pengguna-sistem-reset', $data->id) }}"
                                        class="btn btn-danger deactivate-account">Reset</a>

                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <a href="{{ route('pengguna-sistem') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>
</div>
@endsection