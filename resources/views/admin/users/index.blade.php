<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Usuarios - Carmelo's Agency Admin</title>
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
        
        <a href="{{ route('admin.reviews.index') }}" class="nav-item">
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            Reseñas
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="nav-item active">
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
        <h1 class="page-title" style="margin-bottom:30px;">Usuarios Registrados</h1>

        @if(session('success'))
            <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Avatar</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Reservas</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                     style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                            </td>
                            <td style="font-weight:bold;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span style="background:#e0e7ff; color:#3730a3; padding:3px 8px; border-radius:4px; font-size:0.8rem; font-weight:bold;">ADMIN</span>
                                @else
                                    <span style="color:#666;">USUARIO</span>
                                @endif
                            </td>
                            <td style="text-align:center;">{{ $user->bookings_count }}</td>
                            <td>
                                @if(Auth::id() !== $user->id)
                                    <form id="ban-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmBanUser({{ $user->id }})" class="action-btn btn-delete" style="display:inline-flex; align-items:center; gap:5px;">
                                            <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            Expulsar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmBanUser(userId) {
        Swal.fire({
            title: '¿Expulsar usuario?',
            text: "El usuario perderá acceso y sus reservas podrían verse afectadas.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, expulsar',
            cancelButtonText: 'Cancelar',
            background: '#1f2937', // Fondo oscuro "Pro"
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('ban-user-' + userId).submit();
            }
        })
    }
</script>

</body>
</html>