<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100" style="background: url('{{ asset('asset/img/login/login.png') }}')">

    <div class="card shadow-lg border-0" style="max-width: 800px; width:100%;">
        <div class="row g-0">
            {{-- Kiri --}}
            <div class="col-md-5 d-flex flex-column justify-content-center text-white text-center p-5" style="background: #9B2244; height:400px;">
                <div class="login-logo">
                    <img src="{{ asset('asset/img/logo.svg') }}" style= "width:100%;">
                </div>
            </div>

            {{-- Kanan --}}
            <div class="col-md-7 p-5 bg-white" style="height:400px;">
                <h5 class="text-center mb-4">Buat Password Baru</h5>

                {{-- Error message --}}
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password baru" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Ubah Password</button>
                </form>
                
                {{-- Notifikasi Sukses / Error --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
