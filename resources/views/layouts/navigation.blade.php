<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="logo">Carmelo's Agency</a>

        <div class="nav-links">
            @auth
                @php
                    $dashboardRoute = Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard');
                @endphp

                @if(Auth::user()->is_admin)
                     <a href="{{ route('admin.dashboard') }}" style="color:var(--primary); font-weight:bold; border:1px solid var(--primary); padding:5px 15px; border-radius:20px; font-size:0.8rem; margin-right:10px;">
                        Panel Admin
                     </a>
                @else
                     <a href="{{ route('dashboard') }}" class="btn-nav" style="margin-right:10px;">Mis Viajes</a>
                @endif
                
                <a href="{{ $dashboardRoute }}" style="color:var(--gray); font-size:0.9rem; font-weight:bold; text-decoration:none; display:flex; align-items:center; gap:8px;">
                    <div style="width:32px; height:32px; border-radius:50%; background:#e5e5e5; overflow:hidden;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="width:100%; height:100%; background:var(--dark); color:white; display:flex; align-items:center; justify-content:center; font-size:0.8rem;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <span>Hola, {{ Auth::user()->name }}</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; cursor:pointer; color:#ef4444; font-weight:bold; font-size:0.9rem; margin-left:15px;">
                        Salir
                    </button>
                </form>

            @else
                <a href="{{ route('login') }}" class="btn-nav">Entrar</a>
                <a href="{{ route('register') }}" class="btn-nav btn-register">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>