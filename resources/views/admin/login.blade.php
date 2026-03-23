<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — PT Mitra Abadi Metalindo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-login-body">

<div class="login-bg">
    <div class="login-grid-lines"></div>
    <div class="login-glow"></div>
</div>

<div class="login-wrap">
    <div class="login-card">

        <div class="login-header">
            <div class="login-logo">
                <span class="login-logo__mark">⬡</span>
                <div>
                    <div class="login-logo__name">MITRA ABADI METALINDO</div>
                    <div class="login-logo__sub">Admin Panel</div>
                </div>
            </div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Masuk untuk mengelola konten website</p>
        </div>

        @if($errors->any())
        <div class="alert alert--error" style="margin-bottom:1.5rem;">
            <span>✕</span> {{ $errors->first() }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert--error" style="margin-bottom:1.5rem;">
            <span>✕</span> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="admin@mitraabadimetalindo.com"
                       required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-password-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="••••••••" required>
                    <button type="button" class="password-toggle" id="passwordToggle" tabindex="-1">
                        <span id="passwordEye">👁</span>
                    </button>
                </div>
            </div>
            <div class="form-group form-group--checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
            </div>
            <button type="submit" class="btn-login">
                Masuk ke Admin Panel →
            </button>
        </form>

        <div class="login-footer">
            <a href="{{ url('/') }}">← Kembali ke Website</a>
        </div>

    </div>
</div>

<script>
const toggle = document.getElementById('passwordToggle');
const input  = document.getElementById('password');
const eye    = document.getElementById('passwordEye');
if (toggle) {
    toggle.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        eye.textContent = show ? '🙈' : '👁';
    });
}
</script>
</body>
</html>