<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reseñas - Carmelo's Agency Admin</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
        /* --- TUS ESTILOS --- */
        .nav-item { display: flex !important; align-items: center !important; gap: 10px !important; }
        .nav-item svg { display: block; margin-right: 0 !important; width: 20px; height: 20px; }
        .sidebar { background-color: rgba(0,0,0, .85); }
        .sidebar-brand{ font-weight: 600; letter-spacing: .5px; }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">Carmelo's Agency Admin</a>
        
        <div class="menu-label">Principal</div>
        
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        
        <div class="menu-label" style="margin-top:20px;">Gestión</div>
        
        <a href="{{ route('admin.trips.index') }}" class="nav-item">
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            Viajes
        </a>
        
        <a href="{{ route('admin.bookings.index') }}" class="nav-item">
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            Reservas
        </a>
        
        <a href="{{ route('admin.reviews.index') }}" class="nav-item active">
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            Reseñas
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="nav-item">
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Usuarios
        </a>

        <div style="margin-top:auto; padding-top:20px; border-top:1px solid #444;">
            <strong style="color:#d6d3d1;">{{ Auth::user()->name }}</strong>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:5px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-weight:bold; font-size:0.8rem;">Salir</button>
            </form>
        </div>
    </aside>

    <main class="admin-content">
        <h1 class="page-title" style="margin-bottom:30px;">Moderación de Comentarios</h1>

        @if(session('success'))
            <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Viaje</th>
                        <th>Puntuación</th>
                        <th>Comentario</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td style="font-weight:bold;">{{ $review->user->name }}</td>
                            <td>{{ Str::limit($review->trip->title, 20) }}</td>
                            <td style="color:#f59e0b; display:flex; align-items:center; gap:5px;">
                                {{ $review->rating }} 
                                <svg style="width:16px; height:16px;" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </td>
                            <td style="font-style:italic; color:#666;">"{{ Str::limit($review->comment, 40) }}"</td>
                            <td>
                                <form id="delete-review-{{ $review->id }}" action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDeleteReview({{ $review->id }})" class="action-btn btn-delete">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:20px; color:#999;">No hay reseñas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteReview(reviewId) {
        Swal.fire({
            title: '¿Borrar comentario?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, borrar',
            cancelButtonText: 'Cancelar',
            background: '#1f2937', // Fondo oscuro "Pro"
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-review-' + reviewId).submit();
            }
        })
    }
</script>

</body>
</html>