<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Favoritos - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Reutilizamos tus estilos base */
        .user-nav-group { display: flex; align-items: center; gap: 20px; }
        .user-profile-link { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--dark); font-weight: bold; padding: 5px 10px; border-radius: 30px; transition: background 0.2s; font-size: 1rem; }
        .user-profile-link:hover { background-color: rgba(0,0,0,0.05); }
        .nav-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
        .nav-avatar-placeholder { width: 35px; height: 35px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }
        .logout-btn { background: none; border: 2px solid var(--primary); color: var(--primary); padding: 6px 15px; border-radius: 20px; font-weight: bold; cursor: pointer; transition: all 0.2s; font-size: 0.9rem; }
        .logout-btn:hover { background: var(--primary); color: white; }

        /* Estilos específicos de esta página */
        .page-header {
            text-align: center;
            margin: 40px 0;
        }
        .page-title {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        /* GRID Y CARDS */
        .trip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            position: relative;
        }
        .card:hover { transform: translateY(-5px); }
        .card-img-box { position: relative; height: 220px; overflow: hidden; }
        .card-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .card:hover .card-img { transform: scale(1.1); }
        
        .price-badge {
            position: absolute; bottom: 15px; right: 15px;
            background: var(--dark); color: white;
            padding: 5px 15px; border-radius: 20px;
            font-weight: 800; font-size: 1.1rem;
            z-index: 10;
        }

        .fav-form { position: absolute; top: 10px; right: 10px; z-index: 20; }
        .fav-btn {
            background: white; border: none; border-radius: 50%;
            width: 35px; height: 35px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .fav-btn:hover { transform: scale(1.1); }

        .card-body { padding: 20px; }
        .card-title { font-size: 1.25rem; font-weight: 800; color: var(--dark); margin: 0 0 10px 0; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
        .card-btn { background: var(--light); color: var(--dark); padding: 8px 15px; border-radius: 10px; font-size: 0.9rem; font-weight: bold; text-decoration: none; }
        .card-btn:hover { background: var(--dark); color: white; }

        .empty-state {
            text-align: center;
            padding: 60px;
            color: #9ca3af;
        }
    </style>
</head>
<body style="background-color: #f9fafb; min-height:100vh; display:flex; flex-direction:column;">

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Carmelo's Agency</a>
            
            <div class="nav-links">
                <div class="user-nav-group">
                    <a href="{{ route('home') }}" style="text-decoration:none; color:var(--gray); font-weight:bold; font-size:1rem;">Catálogo</a>
                    
                    <a href="{{ route('dashboard') }}" style="text-decoration:none; color:var(--gray); font-weight:bold; font-size:1rem;">Mis Viajes</a>

                    <span style="color:var(--primary); font-weight:bold; border-bottom:2px solid var(--primary); font-size:1rem;">Favoritos</span>
                    
                    <a href="{{ route('profile.edit') }}" class="user-profile-link">
                        <span>{{ Auth::user()->name }}</span>
                        @if(Auth::user()->avatar)
                            <img src="{{ Str::startsWith(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}" class="nav-avatar">
                        @else
                            <div class="nav-avatar-placeholder">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        @endif
                    </a>

                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="button" onclick="confirmLogout()" class="logout-btn">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main style="flex:1;">
        <div class="page-header">
            <h1 class="page-title">
                <svg style="width: 40px; height: 40px; color: #ef4444;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                Tu Lista de Deseos
            </h1>
            <p style="color:var(--gray);">Guarda ahora, viaja cuando quieras.</p>
        </div>

        <div class="trip-grid">
            @forelse($favorites as $trip)
                <article class="card">
                    <a href="{{ route('trips.show', $trip) }}" style="position:absolute; inset:0; z-index:1;"></a>

                    <div class="card-img-box">
                        <img src="{{ Str::startsWith($trip->image, 'http') ? $trip->image : asset($trip->image) }}" alt="{{ $trip->title }}" class="card-img">
                        <div class="price-badge">${{ number_format($trip->price, 0) }}</div>

                        <form action="{{ route('trips.favorite', $trip) }}" method="POST" class="fav-form">
                            @csrf
                            <button type="submit" class="fav-btn" title="Quitar de favoritos">
                                <svg style="width: 20px; height: 20px; color: #ef4444;" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        @if($trip->category)
                            <div style="font-size:0.8rem; color:var(--primary); font-weight:bold; margin-bottom:5px;">
                                {{ strtoupper($trip->category->name) }}
                            </div>
                        @endif
                        
                        <h3 class="card-title">{{ $trip->title }}</h3>
                        
                        <div class="card-footer">
                            <span style="font-size:0.8rem; font-weight:600; color:#a8a29e; display:flex; align-items:center; gap:4px;">
                                <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ Str::limit($trip->destination, 15) }}
                            </span>
                            <span class="card-btn">Ver Detalles</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div style="margin-bottom:15px;">
                        <svg style="width:64px; height:64px; color:#d1d5db; margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3>Aún no tienes favoritos</h3>
                    <p>Explora el catálogo y dale amor a los viajes que te gusten.</p>
                    <a href="{{ route('home') }}" style="display:inline-block; margin-top:20px; background:var(--primary); color:white; padding:12px 24px; border-radius:30px; text-decoration:none; font-weight:bold;">Ir al Catálogo</a>
                </div>
            @endforelse
        </div>
    </main>

    <footer style="background:var(--dark); color:white; text-align:center; padding:30px; margin-top:50px;">
        <p>&copy; {{ date('Y') }} Carmelo's Agency Inc.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: "¡Hasta pronto!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Salir',
                background: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>

</body>
</html>