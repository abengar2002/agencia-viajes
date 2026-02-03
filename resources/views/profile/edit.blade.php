<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil - Carmelo's Agency</title>
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* --- ESTILOS DE BARRA DE NAVEGACIÓN (CONSISTENTES) --- */
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

        /* --- ESTILOS DE LA PÁGINA DE PERFIL --- */
        
        /* El Fondo Naranja Grande */
        .orange-header-bg {
            height: 250px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        }

        /* La Tarjeta Flotante */
        .profile-card-container {
            max-width: 500px;
            margin: -100px auto 50px;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            padding: 0 40px 40px;
            position: relative;
            text-align: center;
        }

        /* La Foto Circular que sobresale */
        .avatar-wrapper-top {
            width: 140px;
            height: 140px;
            margin: 0 auto;
            position: relative;
            top: -70px;
            margin-bottom: -50px;
        }

        .avatar-img-top {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--white);
            background-color: var(--light);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Zona de Arrastrar (Drop Zone) */
        .drop-zone {
            border: 2px dashed #fdba74;
            background-color: #fff7ed;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .drop-zone:hover, .drop-zone.active {
            background-color: #ffedd5;
            border-color: var(--primary);
        }

        .drop-zone p {
            color: var(--primary);
            font-weight: 700;
            margin: 10px 0 0;
            font-size: 0.9rem;
        }
        
        .drop-zone .icon {
            color: #9ca3af;
            margin-bottom: 5px;
        }

        /* Inputs específicos */
        .form-input-profile {
            background-color: #f5f5f4;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            margin-top: 5px;
        }

        /* Botón Naranja Ancho */
        .btn-orange-block {
            width: 100%;
            background: var(--primary);
            color: white;
            font-weight: 800;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.3);
        }
        
        .btn-orange-block:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
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

    <div class="orange-header-bg">
    </div>

    <div class="profile-card-container">
        
        <div class="avatar-wrapper-top">
            @if($user->avatar)
                <img id="avatar-preview-top" src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img-top" alt="Avatar">
            @else
                <img id="avatar-preview-top" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ea580c&color=fff&size=200" class="avatar-img-top" alt="Avatar">
            @endif
        </div>

        <h2 style="font-size:1.5rem; margin-top:10px; color:var(--dark);">{{ $user->name }}</h2>
        <p style="color:var(--gray); font-size:0.9rem; margin-bottom:30px;">{{ $user->email }}</p>

        @if (session('status') === 'profile-updated')
            <div style="background:#dcfce7; color:#166534; padding:10px; border-radius:8px; margin-bottom:20px; font-weight:bold; font-size:0.9rem; display:flex; align-items:center; justify-content:center; gap:8px;">
                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Perfil actualizado correctamente.
            </div>
        @endif

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="text-align:left;">
            @csrf
            @method('patch')

            <div style="margin-bottom:20px;">
                <label style="font-weight:700; font-size:0.9rem; color:var(--gray);">Nombre completo</label>
                <input type="text" name="name" class="form-input-profile" value="{{ old('name', $user->name) }}" required>
                @error('name') <p style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-weight:700; font-size:0.9rem; color:var(--gray);">Correo electrónico</label>
                <input type="email" name="email" class="form-input-profile" value="{{ old('email', $user->email) }}" required>
                @error('email') <p style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-weight:700; font-size:0.9rem; color:var(--gray);">Cambiar Foto</label>
                
                <div id="drop-area" class="drop-zone">
                    <div class="icon">
                        <svg style="width:40px; height:40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <p>Arrastra tu foto aquí o haz clic</p>
                    
                    <input type="file" name="avatar" id="file-input" accept="image/*" style="display:none;">
                </div>
                @error('avatar') <p style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-orange-block">GUARDAR CAMBIOS</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Función de confirmación de Logout
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

        // Lógica de Drag & Drop de Avatar
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file-input');
        const topAvatar = document.getElementById('avatar-preview-top');

        dropArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                updateImage(this.files[0]);
            }
        });

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(() => {
            dropArea.classList.add('active');
        });

        ['dragleave', 'drop'].forEach(() => {
            dropArea.classList.remove('active');
        });

        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            updateImage(files[0]);
        });

        function updateImage(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    topAvatar.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
</html>