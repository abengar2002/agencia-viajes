<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Reseña - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
        /* --- ESTILOS DE BARRA DE NAVEGACIÓN --- */
        .user-nav-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user-profile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--dark);
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 30px;
            transition: background 0.2s;
            font-size: 1rem;
        }
        .user-profile-link:hover {
            background-color: rgba(0,0,0,0.05);
        }
        .nav-avatar {
            width: 35px; height: 35px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 2px solid #e5e7eb;
        }
        .nav-avatar-placeholder {
            width: 35px; height: 35px; 
            background: #3b82f6; color: white;
            border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-weight: bold; font-size: 14px;
        }
        .logout-btn {
            background: none;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .logout-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* --- ESTILOS GENERALES --- */
        body {
            background-color: var(--light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            height: fit-content;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--dark);
        }
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }

        /* --- BOTONES PERSONALIZADOS --- */
        .btn-primary {
            background: var(--dark);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background: #ea580c;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -10px rgba(234, 88, 12, 0.6);
        }

        .btn-cancel {
            padding: 11px 20px;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            color: #4b5563; 
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
        }
        .btn-cancel:hover {
            background-color: #ef4444;
            color: white;
            border-color: #ef4444;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -10px rgba(239, 68, 68, 0.5);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Carmelo's Agency</a>
            
            <div class="nav-links">
                @auth
                    <div class="user-nav-group">
                        <a href="{{ route('home') }}" style="text-decoration:none; color:var(--gray); font-weight:bold; font-size:1rem;">Catálogo</a>
                        <a href="{{ route('dashboard') }}" style="text-decoration:none; color:var(--gray); font-weight:bold; font-size:1rem;">Mis Viajes</a>
                        <a href="{{ route('favorites.index') }}" style="text-decoration:none; color:var(--gray); font-weight:bold; font-size:1rem;">Favoritos</a>
                        
                        <a href="{{ route('profile.edit') }}" class="user-profile-link" title="Mi Perfil">
                            <span>{{ Auth::user()->name }}</span>
                            @if(Auth::user()->avatar)
                                <img src="{{ Str::startsWith(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}" alt="Perfil" class="nav-avatar">
                            @else
                                <div class="nav-avatar-placeholder">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="logout-btn">Salir</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Entrar</a>
                    <a href="{{ route('register') }}" class="btn-nav btn-register">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <div class="auth-card">
            
            <header style="margin-bottom: 30px; border-bottom: 1px solid #f3f4f6; padding-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <svg style="width:32px; height:32px; color:var(--primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h1 style="font-size: 1.8rem; font-weight: 800; margin: 0; color: var(--dark);">Editar Reseña</h1>
                </div>
                <p style="color: var(--gray);">
                    Cambiando tu opinión sobre: 
                    <strong style="color: var(--primary);">{{ $review->trip->title }}</strong>
                </p>
            </header>

            <form action="{{ route('reviews.update', $review) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Puntuación</label>
                    <select name="rating" class="form-input" style="cursor: pointer;">
                        <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>★★★★★ Excelente (5)</option>
                        <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>★★★★ Muy bueno (4)</option>
                        <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>★★★ Normal (3)</option>
                        <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>★★ Regular (2)</option>
                        <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>★ Malo (1)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tu comentario</label>
                    <textarea name="comment" rows="6" class="form-input" placeholder="Cuéntanos qué te pareció..." required>{{ old('comment', $review->comment) }}</textarea>
                    @error('comment') <span style="color: #ef4444; font-size: 0.8rem; font-weight:bold;">{{ $message }}</span> @enderror
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px; align-items: center;">
                    <button type="submit" class="btn-primary">
                        <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Guardar Cambios
                    </button>
                    
                    <a href="{{ route('trips.show', $review->trip) }}" class="btn-cancel">
                        <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Carmelo's Agency Inc. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: "¡Esperamos verte pronto de vuelta!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar',
                background: '#fff',
                backdrop: `rgba(0,0,0,0.5)`
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>

</body>
</html>