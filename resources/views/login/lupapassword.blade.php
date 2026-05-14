<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lupa Password</title>
        {{-- Bootstrap CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex justify-content-center align-items-center min-vh-100" style="background: url('{{ asset('asset/img/login/login.png') }}')">

        <div class="card shadow-lg border-0" style="max-width: 800px; width:100%;">
            <div class="row g-0">
                
                {{-- Bagian Kiri --}}
                <div class="col-md-5 d-flex flex-column justify-content-center text-white text-center p-5" style="background: url('{{ asset('asset/img/lifemedia.jpg') }}'); background-size: cover;">
                    <img src="{{ asset('asset/img/login/logo-login.png') }}" style="width: 100%;">
                </div>

                {{-- Bagian Kanan --}}
                <div class="col-md-7 p-5 bg-white" style="height:400px; ">
                    <h5 class="justify-content-center text-center">Lupa Password Anda?</h5>

                    @if(session('success'))
                        <div class="alert alert-success"
                        style="padding:6px 10px; font-size:13px; border-radius:6px; margin-bottom:8px;">
                        {{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger"
                         style="padding:6px 10px; font-size:13px; border-radius:6px; margin-bottom:8px;">
                         {{ session('error') }}</div>
                    @endif

                   <form method="POST" action="{{ route('lupapassword.kirim') }}">
                        @csrf
                        <div class="mb-3" style="margin-top:15px;">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Isikan Email Anda">
                        </div>
                        <button type="submit" class="btn btn-danger w-100" style="margin-top:15px;">Kirim Link Pemulihan</button>
                    </form>
                    
                    <div class="mb-3 mt-4 justify-content-center text-center">
                        <a href="{{ url('') }}" class="text-danger" style="font-size: 14px;">
                            kembali ke login?
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>