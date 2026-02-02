<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página no encontrada - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Estilos específicos para la página de error */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--light);
        }
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
            background: white;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .error-code {
            font-size: 6rem;
            font-weight: 900;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 10px;
        }
        .error-title {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 15px;
            font-weight: 800;
        }
        .error-text {
            color: var(--gray);
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: var(--primary);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-home:hover {
            background-color: #ea580c; /* Un tono más oscuro */
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -10px rgba(234, 88, 12, 0.5);
        }
        
        /* Navbar Styles (Copia reducida para mantener consistencia) */
        .user-nav-group { display: flex; align-items: center; gap: 20px; }
        .user-profile-link { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--dark); font-weight: bold; }
        .nav-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
        .nav-avatar-placeholder { width: 35px; height: 35px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }
        .logout-btn { background: none; border: 2px solid var(--primary); color: var(--primary); padding: 6px 15px; border-radius: 20px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Carmelo's Agency</a>
            
            <div class="nav-links">
                @auth
                    <div class="user-nav-group">
                        <a href="{{ route('home') }}" style="text-decoration:none; color:var(--gray); font-weight:bold;">Catálogo</a>
                        <a href="{{ route('dashboard') }}" style="text-decoration:none; color:var(--gray); font-weight:bold;">Mis Viajes</a>
                        
                        <a href="{{ route('profile.edit') }}" class="user-profile-link">
                            <span>{{ Auth::user()->name }}</span>
                            @if(Auth::user()->avatar)
                                <img src="{{ Str::startsWith(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}" class="nav-avatar">
                            @else
                                <div class="nav-avatar-placeholder">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            @endif
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Entrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <div class="error-container">
            <div style="margin-bottom: 20px;">
                <svg style="width: 100px; height: 100px; color: #d1d5db; margin: 0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" style="stroke:var(--primary);"></path>
                </svg>
            </div>
            
            <div class="error-code">404</div>
            <h1 class="error-title">¡Vaya! Te has salido del mapa.</h1>
            <p class="error-text">
                Parece que el destino que buscas no existe o ha sido movido. <br>
                No te preocupes, hasta los mejores exploradores se pierden a veces.
            </p>

            <a href="{{ route('home') }}" class="btn-home">
                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Volver al Inicio
            </a>
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Carmelo's Agency Inc. Todos los derechos reservados.</p>
    </footer>

</body>
</html>