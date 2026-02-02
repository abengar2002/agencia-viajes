<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificar Email - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="auth-page">

    <div class="auth-card">
        <div class="auth-header">
            <a href="{{ route('home') }}" style="display:block; margin-bottom:20px; font-size:1.5rem; font-weight:800; color:var(--primary); text-decoration:none;">Carmelo's Agency</a>
            
            <svg style="width:50px; height:50px; color:#ea580c; margin-bottom:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            
            <h2>Verifica tu correo</h2>
            <p>Gracias por registrarte. Antes de empezar, por favor confirma tu cuenta haciendo clic en el enlace que te acabamos de enviar.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; display:flex; align-items:center; gap:10px;">
                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Se ha enviado un nuevo enlace a tu correo.
            </div>
        @endif

        <div style="display:flex; flex-direction:column; gap:15px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary">REENVIAR CORREO</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none; border:none; color:var(--gray); text-decoration:underline; cursor:pointer; font-size:0.9rem; display:flex; align-items:center; justify-content:center; gap:5px; width:100%;">
                    <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

</body>
</html>