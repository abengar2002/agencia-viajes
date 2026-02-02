<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard - Carmelo's Agency Admin</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
        /* --- SOLO CORRECCIÓN DE ALINEACIÓN --- */
        .nav-item {
            display: flex !important;       
            align-items: center !important; 
            gap: 10px !important;           
        }

        .nav-item svg {
            display: block;
            margin-right: 0 !important;
            width: 20px;
            height: 20px;
        }

        .sidebar {
            background-color: rgba(0,0,0, .85);
        }

        .sidebar-brand{
            font-weight: 600;
            letter-spacing: .5px;
        }

        /* AJUSTE PARA LAS CARTITAS (Estilo opcional para que se vean mejor) */
        .stat-card {
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">Carmelo's Agency Admin</a>
        
        <div class="menu-label">Principal</div>
        
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
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
        <h1 class="page-title">Panel de Control</h1>

        <div class="stats-grid">
            
            <div class="stat-card">
                <div class="stat-icon">
                    <svg style="width:32px; height:32px; color: black;;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <div class="stat-value">{{ $stats['trips'] }}</div>
                <div class="stat-label">Viajes Totales</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg style="width:32px; height:32px; color: black;;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <div class="stat-value">{{ $stats['bookings'] }}</div>
                <div class="stat-label">Reservas</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg style="width:32px; height:32px; color: black;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="stat-value">{{ $stats['users'] }}</div>
                <div class="stat-label">Usuarios</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg style="width:32px; height:32px; color: black;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                </div>
                <div class="stat-value">{{ $stats['reviews'] }}</div>
                <div class="stat-label">Reseñas</div>
            </div>

            <div class="stat-card" style="border-color:var(--primary);">
                <div class="stat-icon">
                    <svg style="width:32px; height:32px; color: var(--primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="stat-value" style="color:var(--primary);">
                    ${{ number_format($stats['income'], 0) }}
                </div>
                <div class="stat-label">Ingresos Totales</div>
            </div>

        </div>
    </main>
</div>

</body>
</html>