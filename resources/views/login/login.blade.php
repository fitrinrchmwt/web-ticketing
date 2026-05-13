<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        },
    </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100" style="background: url('{{ asset('asset/img/login/login.png') }}')">

    <div class="card shadow-lg border-0" style="max-width: 800px; width:100%; max-height:450px;">
        <div class="row g-0">
            {{-- Kiri --}}
            <div class="col-md-5 d-flex flex-column justify-content-center text-white text-center p-5" style="background: url('{{ asset('asset/img/lifemedia.jpg') }}'); background-size: cover;">
                <div class="login-logo">
                    <img src="{{ asset('asset/img/login/logo-login.png') }}" style="width: 100%;">
                </div>
            </div>

            {{-- Kanan --}}
            <div class="col-md-7 p-5 bg-white" >
                <h5 class="text-center mb-4">Login ke akun Anda</h5>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <div id="alert-success" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                <span id="alert-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                Swal.fire({
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#9B2244'
                });
            </script>
        @endif
        
        @if (session('error'))
            <div id="alert-danger" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#9B2244'

                });
            </script>
        @endif 
                

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Isikan Username Anda" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Isikan Password Anda" required>

                            <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3 text-end">
                        <a href="{{ url('lupapassword') }}" class="text-danger" style="font-size: 14px;">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">LOG IN</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        setTimeout(function() {
        $('#alert-box').fadeOut('slow');
        }, 3000); // 3000 ms = 3 detik
    });

     document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
</script>
</body>
</html>
