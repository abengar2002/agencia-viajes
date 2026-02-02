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
        <a href="{{ route('admin.dashboard') }}" class="nav-item">Dashboard</a>
        <div class="menu-label" style="margin-top:20px;">Gestión</div>
        <a href="{{ route('admin.trips.index') }}" class="nav-item">Viajes</a>
        <a href="{{ route('admin.bookings.index') }}" class="nav-item">Reservas</a>
        <a href="{{ route('admin.reviews.index') }}" class="nav-item">Reseñas</a>
        <a href="{{ route('admin.users.index') }}" class="nav-item active">Usuarios</a>
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