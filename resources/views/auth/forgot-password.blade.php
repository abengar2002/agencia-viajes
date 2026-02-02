<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Contraseña - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="auth-page">

    <div class="auth-card">
        <div class="auth-header">
            <a href="{{ route('home') }}" style="display:block; margin-bottom:20px; font-size:1.5rem; font-weight:800; color:var(--primary); text-decoration:none;">Carmelo's Agency</a>
            
            <svg style="width:50px; height:50px; color:#ea580c; margin-bottom:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            
            <h2>¿Olvidaste tu contraseña?</h2>
            <p>No pasa nada. Indícanos tu email y te enviaremos un enlace para recuperarla.</p>
        </div>

        @if (session('status'))
            <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; display:flex; align-items:center; gap:10px;">
                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="tu@email.com">
                @error('email') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-primary">ENVIAR ENLACE</button>

            <div class="auth-footer">
                <a href="{{ route('login') }}" class="auth-link" style="display:flex; align-items:center; justify-content:center; gap:5px;">
                    <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>

</body>
</html>