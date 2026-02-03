<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $trip->title }} - Carmelo's Agency</title>
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

        /* --- ESTILOS DE LA PÁGINA --- */
        .book-btn-large {
            display: block;
            width: 100%;
            background: var(--dark);
            color: white;
            padding: 18px;
            text-align: center;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1.1rem;
            text-decoration: none;
            transition: transform 0.2s, background 0.2s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .book-btn-large:hover {
            transform: translateY(-2px);
            background: #000;
            box-shadow: 0 10px 15px rgba(0,0,0,0.15);
        }
        
        .review-locked {
            background: #f3f4f6;
            border: 1px dashed #9ca3af;
            padding: 30px; 
            text-align: center;
            border-radius: 12px;
            color: #4b5563;
            margin-top: 20px;
        }

        .sidebar-fix {
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
        }

        /* Animación para el avión de papel SVG */
        @keyframes fly {
            0% { transform: translateY(0) translateX(0); }
            100% { transform: translateY(-3px) translateX(3px); }
        }
        .animate-fly {
            animation: fly 1s infinite alternate ease-in-out;
        }

        .btn-nav { font-size: 1rem; }
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

    <header class="trip-hero">
        <img 
            src="{{ Str::startsWith($trip->image, 'http') ? $trip->image : asset($trip->image) }}" 
            alt="{{ $trip->title }}" 
            class="trip-hero-img"
        >

        <div class="trip-hero-content">
            <div class="trip-hero-inner">
                @if($trip->category)
                    <span class="pill" style="background:var(--primary); color:white; border:none; margin-bottom:10px; display:inline-block;">
                        {{ $trip->category->name }}
                    </span>
                @endif
                <h1 class="trip-title">{{ $trip->title }}</h1>
                <p class="trip-location" style="display:flex; align-items:center; gap:5px;">
                    <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $trip->destination }}
                </p>
            </div>
        </div>
    </header>

    <main class="trip-layout">
        
        @php 
            $hasBooked = false;
            if(auth()->check()) {
                $hasBooked = auth()->user()->bookings()->where('trip_id', $trip->id)->exists();
            }
        @endphp

        <div class="content-col">
            
            <div class="trip-desc">
                {{ $trip->description }}
            </div>

            <div class="reviews-section">
                <h3 style="font-size:1.5rem; margin-bottom:30px;">
                    Opiniones de viajeros ({{ $trip->reviews->count() }})
                </h3>

                @forelse($trip->reviews as $review)
                    <div class="review-item">
                        @if($review->user->avatar)
                            <img src="{{ Str::startsWith($review->user->avatar, 'http') ? $review->user->avatar : asset('storage/' . $review->user->avatar) }}" class="avatar">
                        @else
                            <div class="avatar-placeholder" style="width:40px; height:40px; background:#e5e7eb; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; margin-right:15px;">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                        @endif

                        <div class="review-content">
                            <div class="review-header">
                                <span class="review-author">{{ $review->user->name }}</span>
                                <span class="review-stars" style="display:flex; align-items:center; gap:2px;">
                                    @for($i=1; $i<=5; $i++) 
                                        @if($i <= $review->rating)
                                            <svg style="width:16px; height:16px; color:#fbbf24;" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @else
                                            <svg style="width:16px; height:16px; color:#d1d5db;" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endif
                                    @endfor
                                </span>
                            </div>
                            <p class="review-text">"{{ $review->comment }}"</p>

                            @if(auth()->id() === $review->user_id)
                                <div style="margin-top:10px; font-size:0.8rem; display:flex; gap:15px;">
                                    <a href="{{ route('reviews.edit', $review) }}" style="color:var(--gray); font-weight:bold;">Editar</a>
                                    
                                    <form id="delete-review-{{ $review->id }}" action="{{ route('reviews.delete', $review) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteReview({{ $review->id }})" style="background:none; border:none; color:red; cursor:pointer; font-weight:bold;">Borrar</button>
                                    </form>

                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray); font-style:italic;">No hay reseñas todavía. ¡Sé el primero!</p>
                @endforelse

                @auth
                    @if($hasBooked)
                        @if(!$trip->reviews->where('user_id', auth()->id())->count())
                            <div class="review-form-box">
                                <h4 style="margin-bottom:15px;">Escribe tu opinión</h4>
                                <form action="{{ route('trips.review', $trip) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Puntuación</label>
                                        <select name="rating" class="form-control" style="width:150px;">
                                            <option value="5">5 - Excelente</option>
                                            <option value="4">4 - Muy bueno</option>
                                            <option value="3">3 - Normal</option>
                                            <option value="2">2 - Regular</option>
                                            <option value="1">1 - Malo</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Comentario</label>
                                        <textarea name="comment" rows="3" class="form-control" placeholder="Cuéntanos tu experiencia..." required></textarea>
                                    </div>
                                    <button type="submit" style="background:var(--dark); color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer; font-weight:bold;">Publicar</button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="review-locked">
                            <div style="margin-bottom:10px;">
                                <svg style="width:48px; height:48px; color:#9ca3af; margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <strong>Esta sección es exclusiva para viajeros.</strong>
                            <p style="margin:5px 0 0 0; font-size:0.9rem;">Debes reservar este viaje para poder compartir tu experiencia.</p>
                        </div>
                    @endif
                @else
                    <div style="background:#f5f5f4; padding:20px; text-align:center; border-radius:8px; margin-top:30px;">
                        <a href="{{ route('login') }}" style="color:var(--primary); font-weight:bold;">Inicia sesión</a> para dejar una reseña.
                    </div>
                @endauth
            </div>
        </div>

        <aside class="sidebar-col" style="position: sticky; top: 20px; height: fit-content;">
            
            <div class="booking-card sidebar-fix" style="border: 1px solid #e5e5e5; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding:25px;">
                
                <div class="price-display" style="border-bottom: 1px solid #f3f4f6; padding-bottom: 15px;">
                    <div class="price-label" style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; color: #6b7280;">Precio total</div>
                    <div class="price-amount" style="font-size: 2.5rem; color: var(--dark); line-height:1;">${{ number_format($trip->price, 0) }}</div>
                </div>

                <div class="dates-grid">
                    <div class="date-box" style="background: #f9fafb; border: 1px solid #e5e7eb;">
                        <span class="date-title">Llegada</span>
                        <div class="date-val">{{ \Carbon\Carbon::parse($trip->start_date)->format('d M') }}</div>
                    </div>
                    <div class="date-box" style="background: #f9fafb; border: 1px solid #e5e7eb;">
                        <span class="date-title">Salida</span>
                        <div class="date-val">{{ \Carbon\Carbon::parse($trip->end_date)->format('d M') }}</div>
                    </div>
                </div>

                @auth
                    @if($hasBooked)
                        <div class="booked-alert" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 15px; border-radius: 8px; text-align: center; font-weight: bold; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                            <div style="display:flex; align-items:center; gap:5px;">
                                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>¡Ya tienes tu plaza!</span>
                            </div>
                            <a href="{{ route('dashboard') }}" style="font-size:0.9rem; color:var(--primary); text-decoration:underline;">Ver en Mis Viajes</a>
                        </div>
                    @else
                        
                        <form id="booking-form" action="{{ route('trips.book', $trip) }}" method="POST" style="width:100%;">
                            @csrf
                            <button type="button" 
                                    onclick="confirmBooking('{{ number_format($trip->price, 2) }}')"
                                    class="book-btn-large">
                                RESERVAR AHORA
                            </button>
                        </form>

                        <p style="text-align:center; font-size:0.85rem; color:#6b7280; margin-top:0; display:flex; align-items:center; justify-content:center; gap:5px;">
                            <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Pago seguro 100% garantizado
                        </p>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="book-btn-large" style="background: white; color: var(--dark); border: 2px solid var(--dark);">
                        Inicia Sesión para Reservar
                    </a>
                @endauth
            </div>
        </aside>

    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Carmelo's Agency Inc.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Función Reservar
        function confirmBooking(price) {
            Swal.fire({
                title: '¿Confirmar Reserva?',
                text: "El total estimado es de $" + price,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '¡Sí, vámonos!',
                cancelButtonText: 'Cancelar',
                background: '#fff',
                backdrop: `rgba(0,0,0,0.5)`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                      title: 'Procesando...',
                      html: 'Estamos preparando tu billete <svg class="animate-fly" style="width:24px; height:24px; vertical-align:middle; color:#4f46e5; display:inline-block; margin-left:5px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>',
                      timer: 2000,
                      timerProgressBar: true,
                      didOpen: () => { Swal.showLoading() },
                      willClose: () => {
                        document.getElementById('booking-form').submit();
                      }
                    })
                }
            })
        }

        // Función Borrar Reseña
        function confirmDeleteReview(reviewId) {
            Swal.fire({
                title: '¿Borrar reseña?',
                text: "No podrás deshacer esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar',
                background: '#fff',
                backdrop: `rgba(0,0,0,0.5)`
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-review-' + reviewId).submit();
                }
            })
        }

        // --- NUEVA FUNCIÓN: CONFIRMAR LOGOUT ---
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

        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: '{{ str_replace(['🧳', '✈️'], '', session('success')) }}'
            });
        @endif
    </script>

</body>
</html>