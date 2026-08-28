<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | {{ config('app.name', 'Sistem HR') }}</title>

    @vite(['resources/js/adminlte.js'])
</head>
<body class="login-page bg-body-secondary">

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <b>Sistem</b> Manajemen HR
            </a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silakan masuk untuk memulai sesi Anda</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="email">
                        <div class="input-group-text">
                            <span class="fa-solid fa-envelope"></span>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password"
                               required
                               autocomplete="current-password">
                        <div class="input-group-text">
                            <span class="fa-solid fa-lock"></span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       value="1"
                                       name="remember"
                                       id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </div>
                    </div>
                </form>

                <div class="mt-4 text-center text-muted small">
                    Contoh login: <code>admin@example.com</code> / <code>password</code>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
