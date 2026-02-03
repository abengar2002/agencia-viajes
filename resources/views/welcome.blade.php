<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carmelo's Agency - Agencia de Viajes</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* --- TUS ESTILOS ORIGINALES (Navbar, Paginación, etc.) --- */
        .user-nav-group { display: flex; align-items: center; gap: 20px; }
        .user-profile-link { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--dark); font-weight: bold; padding: 5px 10px; border-radius: 30px; transition: background 0.2s; font-size: 1rem; }
        .user-profile-link:hover { background-color: rgba(0,0,0,0.05); }
        .nav-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
        .nav-avatar-placeholder { width: 35px; height: 35px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }
        .logout-btn { background: none; border: 2px solid var(--primary); color: var(--primary); padding: 6px 15px; border-radius: 20px; font-weight: bold; cursor: pointer; transition: all 0.2s; font-size: 0.9rem; }
        .logout-btn:hover { background: var(--primary); color: white; }
        .btn-nav { font-size: 1rem; }

        /* --- ESTILOS DE PAGINACIÓN --- */
        .custom-pagination { margin-top: 50px; display: flex; justify-content: center; width: 100%; }
        .custom-pagination nav > div:nth-child(2), .custom-pagination nav > div.sm\:flex { display: flex !important; flex-direction: column !important; align-items: center !important; gap: 15px !important; }
        .custom-pagination nav p { display: block !important; font-size: 0.9rem; color: #6b7280; margin: 0 !important; }
        .custom-pagination a span.sr-only, .custom-pagination span span.sr-only { display: none !important; }
        .custom-pagination nav div:last-child > span, .custom-pagination nav > div:last-child > div:last-child { display: flex !important; flex-direction: row !important; gap: 8px !important; box-shadow: none !important; border-radius: 0 !important; }
        .custom-pagination a, .custom-pagination span[aria-current="page"], .custom-pagination span[aria-disabled="true"] { width: 40px !important; height: 40px !important; display: flex !important; align-items: center !important; justify-content: center !important; border: 1px solid #e5e7eb !important; border-radius: 8px !important; text-decoration: none !important; color: #374151 !important; background: white !important; font-size: 1rem !important; font-weight: 600 !important; transition: all 0.2s !important; cursor: pointer !important; margin: 0 !important; position: relative !important; }
        .custom-pagination svg { width: 20px !important; height: 20px !important; }
        .custom-pagination a:hover { border-color: var(--primary) !important; color: var(--primary) !important; background: #fff7ed !important; }
        .custom-pagination span[aria-current="page"] { background-color: var(--primary) !important; color: white !important; border-color: var(--primary) !important; }
        .custom-pagination span[aria-disabled="true"] { opacity: 0.5 !important; cursor: default !important; background: #f9fafb !important; }
        .custom-pagination nav > div:first-child.flex.justify-between { display: none !important; }

        /* --- NUEVO: ESTILO PARA EL BOTÓN DE FAVORITOS --- */
        .fav-form {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 20; /* Debe ser mayor que el enlace de la tarjeta (z-index: 1) */
        }
        .fav-btn {
            background: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .fav-btn:hover {
            transform: scale(1.1);
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
                        
                        <span style="color:var(--primary); font-weight:bold; border-bottom:2px solid var(--primary); font-size:1rem;">Catálogo</span>

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
                            <button type="button" onclick="confirmLogout()" class="logout-btn">
                                Salir
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Entrar</a>
                    <a href="{{ route('register') }}" class="btn-nav btn-register">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero">
        <h1>Explora el mundo <br> <span style="color:var(--primary)">sin límites.</span></h1>
        <p>Experiencias curadas para viajeros exigentes.</p>

        <form action="{{ route('home') }}" method="GET" class="search-box">
            <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Buscar destino (ej: Japón)...">
            <button type="submit" class="search-btn">BUSCAR</button>
        </form>

        <div class="pills">
            <a href="{{ route('home') }}" class="pill {{ !request('category') ? 'active' : '' }}" style="display:inline-flex; align-items:center; gap:6px;">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Todo
            </a>
            
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->slug]) }}" class="pill {{ request('category') == $category->slug ? 'active' : '' }}" style="display:inline-flex; align-items:center; gap:6px;">
                    @switch(strtolower($category->slug))
                        @case('playa')
                        @case('beach')
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            @break
                        @case('montana')
                        @case('montaña')
                        @case('mountain')
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19H3l9-15 9 15z M9.4 14l-2.4 3h10l-2.4-3h-5.2z"></path></svg>
                            @break
                        @case('ciudad')
                        @case('city')
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            @break
                        @case('aventura')
                        @case('adventure')
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            @break
                        @case('lujo')
                        @case('luxury')
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 9l7-6 7 6-7 13-7-13zm0 0h14m-7-6v19"></path></svg>
                            @break
                        @default
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    @endswitch

                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </header>

    <main class="main-container">
        <h2 class="grid-title">Destinos Disponibles</h2>

        <div class="trip-grid">
            @foreach($trips as $trip)
                <article class="card">
                    <a href="{{ route('trips.show', $trip) }}" style="position:absolute; inset:0; z-index:1;"></a>

                    <div class="card-img-box">
                        <img src="{{ Str::startsWith($trip->image, 'http') ? $trip->image : asset($trip->image) }}" alt="{{ $trip->title }}" class="card-img">
                        <div class="price-badge">${{ number_format($trip->price, 0) }}</div>

                        @auth
                            <form action="{{ route('trips.favorite', $trip) }}" method="POST" class="fav-form">
                                @csrf
                                <button type="submit" class="fav-btn" title="Añadir a favoritos">
                                    @if(Auth::user()->favorites->contains($trip->id))
                                        <svg style="width: 20px; height: 20px; color: #ef4444;" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    @else
                                        <svg style="width: 20px; height: 20px; color: #9ca3af;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        @endauth
                        </div>

                    <div class="card-body">
                        @if($trip->category)
                            <div class="card-cat">
                                {{ $trip->category->name }}
                            </div>
                        @endif
                        
                        <h3 class="card-title">{{ $trip->title }}</h3>
                        <p class="card-desc">{{ $trip->description }}</p>

                        <div class="card-footer">
                            <span style="font-size:0.8rem; font-weight:600; color:#a8a29e; display:flex; align-items:center; gap:4px;">
                                <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ Str::limit($trip->destination, 15) }}
                            </span>
                            <span class="card-btn">Ver Detalles</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="custom-pagination">
            {{ $trips->links() }}
        </div>

        @if($trips->isEmpty())
            <div style="text-align:center; padding:60px; color:#999; border:2px dashed #e5e5e5; border-radius:10px;">
                <div style="margin-bottom:15px; color:#d1d5db;">
                    <svg style="width:48px; height:48px; margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <p>No se encontraron resultados para tu búsqueda.</p>
                <a href="{{ route('home') }}" style="color:var(--primary); font-weight:bold; margin-top:10px; display:inline-block; text-decoration:underline;">Ver todos los viajes</a>
            </div>
        @endif
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Carmelo's Agency Inc. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Configuración de la "Tostada" (El aviso chulo)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Si Laravel manda un mensaje de ÉXITO
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        // Si Laravel manda un mensaje de ERROR
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

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