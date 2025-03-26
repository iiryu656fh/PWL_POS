<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register Pengguna</title>
  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="{{ url('/') }}"><b>Admin</b>LTE</a>
    </div>
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register Pengguna Baru</p>

        <form action="{{ url('postRegister') }}" method="post" id="form-register">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
            <small id="error-username" class="error-text text-danger"></small>
          </div>

          <div class="input-group mb-3">
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
            <small id="error-nama" class="error-text text-danger"></small>
          </div>

          <div class="input-group mb-3">
            <select name="level_id" id="level_id" class="form-control">
              <option value="">Pilih Level</option>
              @foreach ($levels as $item)
          <option value="{{ $item->level_id }}">{{ $item->level_nama}}</option>
        @endforeach
            </select>
            <small id="error-level_id" class="error-text text-danger"></small>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            <small id="error-password" class="error-text text-danger"></small>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
              placeholder="Ulangi Password">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            <small id="error-password_confirmation" class="error-text text-danger"></small>
          </div>

          <div class="row">
            <div class="col-10">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </div>
        </form>

        <p class="mt-3 mb-1 text-center">Sudah punya akun? <a href="{{ url('login') }}">Login Sekarang</a></p>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- jQuery Validation -->
  <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- AdminLTE -->
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

  <script>
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $(document).ready(function () {
      $('#form-register').validate({
        rules: {
          username: { required: true, minlength: 3, maxlength:50 },
          nama: { required: true, minlength: 3, maxlength:100 },
          level_id: { required: true },
          password: { required: true, minlength: 6 },
          password_confirmation: { required: true, equalTo: '#password' }
        },
        messages: {
          username: { required: "Username wajib diisi!", minlength: "Minimal 3 karakter!" },
          nama: { required: "Nama wajib diisi!", minlength: "Minimal 3 karakter!" },
          level_id: { required: "Silakan pilih level!" },
          password: { required: "Password wajib diisi!", minlength: "Minimal 6 karakter!" },
          password_confirmation: { required: "Konfirmasi password wajib diisi!", equalTo: "Password tidak cocok!" }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
          error.addClass('text-danger');
          $('#error-' + element.attr('name')).html(error);
        },
        highlight: function (element) { $(element).addClass('is-invalid'); },
        unhighlight: function (element) { $(element).removeClass('is-invalid'); },
        submitHandler: function (form) {
          $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function (response) {
              if (response.status) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: response.message,
                }).then(function () {
                  if (response.redirect) {
                    window.location = response.redirect;
                  }
                });
              } else {
                $('.error-text').text('');
                $.each(response.errors, function (prefix, val) {
                  $('#error-' + prefix).text(val[0]);
                });
                Swal.fire({
                  icon: 'error',
                  title: 'Terjadi Kesalahan',
                  text: response.message
                });
              }
            },
            error: function (xhr) {
              $('.error-text').text('');
              if (xhr.responseJSON && xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function (prefix, val) {
                  $('#error-' + prefix).text(val[0]);
                });
              }
              Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal melakukan registrasi'
              });
            }
          });
          return false;
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
</body>

</html>