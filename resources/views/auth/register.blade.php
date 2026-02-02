<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Cuenta - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-page">

    <div class="auth-card" style="max-width: 500px;">
        <div class="auth-header">
            <a href="{{ route('home') }}" style="display:block; margin-bottom:20px; font-size:1.5rem; font-weight:800; color:var(--primary); text-decoration:none;">Carmelo's Agency</a>
            
            <svg style="width:50px; height:50px; color:#ea580c; margin-bottom:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            
            <h2>Únete a la aventura</h2>
            <p>Crea tu cuenta en segundos y empieza a reservar.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nombre Completo</label>
                <input type="text" name="name" class="form-input" required autofocus placeholder="Ej: Juan Pérez" value="{{ old('name') }}">
                @error('name') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-input" required placeholder="tu@email.com" value="{{ old('email') }}">
                @error('email') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" x-data="{ show: false }">
                <label class="form-label">Contraseña</label>
                <div style="position:relative;">
                    <input :type="show ? 'text' : 'password'" name="password" class="form-input" required placeholder="Mínimo 8 caracteres" style="padding-right: 40px;">
                    
                    <button type="button" @click="show = !show" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#666; display:flex; align-items:center;">
                        <svg x-show="!show" style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" style="width:20px; height:20px; display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                @error('password') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" x-data="{ show: false }">
                <label class="form-label">Confirmar Contraseña</label>
                <div style="position:relative;">
                    <input :type="show ? 'text' : 'password'" name="password_confirmation" class="form-input" required placeholder="Repite la contraseña" style="padding-right: 40px;">
                    
                    <button type="button" @click="show = !show" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#666; display:flex; align-items:center;">
                        <svg x-show="!show" style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" style="width:20px; height:20px; display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary">CREAR CUENTA</button>

            <div class="auth-footer">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="auth-link">Inicia Sesión</a>
            </div>
        </form>
    </div>

</body>
</html>