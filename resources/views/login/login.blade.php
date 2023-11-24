<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Manajemen-Inventaris</title>

    <meta name="description" content="" />
    @include('layout.partial.link')
  </head>
  <body>
    <!-- Content -->
    @if(Session::has('status'))

    
  <div class="bs-toast toast toast-ex animate__animated my-2 fade bg-{{ Session::get('status') === 'failed' ? 'danger' : 'success text-white' }} animate__flash hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header">
        @if(Session::get('status') === 'failed')
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
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-text demo text-body fw-bolder">
                    <img src="{{ asset('storage/logo2.png') }}" width="120" alt="">
                  </span>
                </a>
              </div>
              <!-- /Logo -->
                  <h4 class="mb-4 text-center">Manajemen Inventaris</h4>
                  {{-- <p class="mb-4 text-center">Silahkan Masukkan Username dan Password Anda</p> --}}
              
              

              <form id="formAuthentication" class="mb-3" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username anda" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-info d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>
              <p class="text-center">
                <span>Belum Punya Akun?</span>
                <a href="{{ route('register') }}">
                  <span>Buat Kuyy</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
   @include('layout.partial.script')

  </body>
</html>
