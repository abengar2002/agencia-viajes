<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Reservas - Carmelo's Agency</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
        /* --- ESTILOS GENERALES (RESET) --- */
        body {
            background-color: var(--light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding-top: 0 !important; 
            overflow-y: auto !important; 
        }

        /* --- 1. MENÚ (NAVBAR) --- */
        .navbar {
            position: relative !important; 
            top: auto !important;
            width: 100%;
            z-index: 50;
            background: white; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            padding: 0 20px;
        }

        /* --- 2. CONTENIDO PRINCIPAL --- */
        main {
            flex: 1;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            position: static !important;
        }

        /* --- 3. LISTA DE TARJETAS (CONTENEDOR) --- */
        .bookings-list {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
            position: static !important; 
            height: auto !important;
            overflow: visible !important;
        }

        /* --- 4. LA TARJETA (CARD) --- */
        .booking-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            width: 100%;
            max-width: 850px; 
            transition: transform 0.2s;
            position: relative !important; 
            top: auto !important;
            bottom: auto !important;
        }

        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* --- RESTO DE ESTILOS --- */
        .dashboard-header { text-align: center; margin-bottom: 40px; }
        .dashboard-title { font-size: 2.5rem; color: var(--dark); margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 15px; }
        .dashboard-subtitle { color: var(--gray); font-size: 1.1rem; }

        .user-nav-group { display: flex; align-items: center; gap: 20px; }
        .user-profile-link { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--dark); font-weight: bold; padding: 5px 10px; border-radius: 30px; transition: background 0.2s; }
        .user-profile-link:hover { background-color: rgba(0,0,0,0.05); }
        .nav-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
        .nav-avatar-placeholder { width: 35px; height: 35px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }
        
        .logout-btn { background: none; border: 2px solid var(--primary); color: var(--primary); padding: 6px 15px; border-radius: 20px; font-weight: bold; cursor: pointer; transition: all 0.2s; }
        .logout-btn:hover { background: var(--primary); color: white; }

        .booking-img { width: 250px; object-fit: cover; }
        .booking-details { padding: 25px; flex: 1; display: flex; flex-direction: column; }
        .booking-status { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; }
        .status-confirmed { background: #dcfce7; color: #166534; }
        .booking-title { font-size: 1.5rem; margin: 0 0 10px 0; color: var(--dark); }
        .booking-meta { display: flex; gap: 20px; color: var(--gray); font-size: 0.95rem; margin-bottom: 20px; }
        .meta-item { display: flex; align-items: center; gap: 5px; }
        
        .booking-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; }
        .booking-price { font-size: 1.1rem; color: var(--dark); }
        .cancel-btn { color: #ef4444; font-weight: bold; background: none; border: none; cursor: pointer; padding: 0; font-size: 0.95rem; transition: color 0.2s; text-decoration: underline; }
        .cancel-btn:hover { color: #dc2626; }
        .empty-state { text-align: center; padding: 60px 20px; color: var(--gray); }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Carmelo's Agency</a>
            
            <div class="user-nav-group">
                <a href="{{ route('home') }}" style="text-decoration:none; color:var(--gray); font-weight:bold;">Catálogo</a>
                <span style="color:var(--primary); font-weight:bold; border-bottom:2px solid var(--primary);">Mis Viajes</span>
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
        </div>
    </nav>

    <main>
        <header class="dashboard-header">
            <h1 class="dashboard-title">
                <svg style="width:40px; height:40px; color:var(--primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                Mis Reservas
            </h1>
            <p class="dashboard-subtitle">Gestiona tus próximas aventuras aquí.</p>
        </header>

        <div class="bookings-list">
            @forelse($bookings as $booking)
                <div class="booking-card">
                    <img 
                        src="{{ Str::startsWith($booking->trip->image, 'http') ? $booking->trip->image : asset($booking->trip->image) }}" 
                        alt="{{ $booking->trip->title }}" 
                        class="booking-img"
                    >
                    <div class="booking-details">
                        <div>
                            <span class="booking-status status-confirmed">Confirmada</span>
                            <h3 class="booking-title">
                                <a href="{{ route('trips.show', $booking->trip) }}" style="text-decoration:none; color:inherit;">
                                    {{ $booking->trip->title }}
                                </a>
                            </h3>
                            <div class="booking-meta">
                                <div class="meta-item">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($booking->trip->start_date)->format('d M Y') }}
                                </div>
                                <div class="meta-item">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $booking->trip->destination }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="booking-footer">
                            <div class="booking-price">
                                Pagado: <strong>${{ number_format($booking->trip->price, 0) }}</strong>
                            </div>
                            
                            <form id="cancel-form-{{ $booking->id }}" action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmCancel({{ $booking->id }})" class="cancel-btn">
                                    Cancelar Reserva
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg style="width:64px;height:64px;color:#d1d5db;margin-bottom:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 00-2-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h3>Aún no tienes reservas</h3>
                    <p>¿Listo para tu próxima escapada? ¡Explora nuestro catálogo!</p>
                    <a href="{{ route('home') }}" style="display:inline-block; margin-top:20px; background:var(--primary); color:white; padding:12px 24px; border-radius:30px; text-decoration:none; font-weight:bold;">Ver Viajes</a>
                </div>
            @endforelse
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Carmelo's Agency Inc.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- 1. CONFIGURACIÓN DEL TOAST (La cajita elegante) ---
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

        // Si Laravel envía un mensaje de ÉXITO
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        // Si Laravel envía un mensaje de ERROR
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        // --- 2. TUS FUNCIONES DE SIEMPRE ---
        function confirmCancel(bookingId) {
            Swal.fire({
                title: '¿Cancelar esta reserva?',
                text: "Esta acción no se puede deshacer. ¿Estás seguro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'Volver',
                background: '#fff',
                backdrop: `rgba(0,0,0,0.5)`
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-form-' + bookingId).submit();
                }
            })
        }

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