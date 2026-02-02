<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear Viaje - Carmelo's Agency Admin</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
        /* --- SOLO ALINEACIÓN (Sin tocar colores) --- */
        .nav-item {
            display: flex !important;       /* Pone icono y texto en fila */
            align-items: center !important; /* Centra verticalmente */
            gap: 10px !important;           /* Espacio exacto entre icono y texto */
        }

        /* Asegura que el icono no se deforme ni descuadre */
        .nav-item svg {
            width: 20px;
            height: 20px;
            display: block; /* Elimina espacios extra fantasma */
        }

        /* --- ESTILOS NECESARIOS PARA EL FORMULARIO (Drag & Drop) --- */
        .admin-form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .admin-form-col {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .drop-zone {
            border: 2px dashed #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .drop-zone:hover, .drop-zone.active {
            border-color: #ea580c; /* Solo el borde naranja al pasar el ratón */
            background-color: #fff7ed;
        }

        .preview-img {
            max-width: 100%;
            max-height: 200px;
            margin-top: 15px;
            border-radius: 8px;
            display: none;
            object-fit: cover;
            margin-left: auto;
            margin-right: auto;
        }

        .sidebar {
            background-color: rgba(0,0,0, .85);
        }

        .sidebar-brand{
            font-weight: 600;
            letter-spacing: .5px;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">Carmelo's Agency Admin</a>
        
        <div class="menu-label">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        
        <div class="menu-label" style="margin-top:20px;">Gestión</div>
        <a href="{{ route('admin.trips.index') }}" class="nav-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            Viajes
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            Reservas
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            Reseñas
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
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
        <div class="admin-header">
            <h1 class="page-title">Crear Nuevo Viaje</h1>
            <a href="{{ route('admin.trips.index') }}" class="action-btn" style="background:#ddd; text-decoration:none; color:#333; display:flex; align-items:center; gap:5px; padding: 8px 15px; border-radius: 5px;">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>

        <div class="table-container" style="padding: 40px; max-width: 900px;">
            
            <form action="{{ route('admin.trips.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">Título del Viaje</label>
                    <input type="text" name="title" class="form-input" placeholder="Ej: Escapada a Bali" value="{{ old('title') }}" required>
                    @error('title') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-col">
                        <label class="form-label">Ubicación / Destino</label>
                        <input type="text" name="destination" class="form-input" placeholder="Ej: Bali, Indonesia" value="{{ old('destination') }}" required>
                    </div>
                    <div class="admin-form-col">
                        <label class="form-label">Precio ($)</label>
                        <input type="number" name="price" class="form-input" placeholder="0" value="{{ old('price') }}" required>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-col">
                        <label class="form-label">Fecha de Ida</label>
                        <input type="date" name="start_date" class="form-input" value="{{ old('start_date') }}" required>
                    </div>
                    <div class="admin-form-col">
                        <label class="form-label">Fecha de Vuelta</label>
                        <input type="date" name="end_date" class="form-input" value="{{ old('end_date') }}" required>
                    </div>
                    <div class="admin-form-col">
                        <label class="form-label">Categoría</label>
                        <select name="category_id" class="form-input" required>
                            <option value="">-- Selecciona --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ str_replace(['🏖️', '🏔️', '🏙️', '🎒', '💎', '🏝️', '🏕️'], '', $category->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span style="color:red; font-size:0.8rem;">Elige una categoría</span> @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">Imagen de Portada</label>
                    
                    <div id="drop-area" class="drop-zone">
                        <svg style="width:40px; height:40px; color:#9ca3af; margin-bottom:5px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p>Arrastra la imagen aquí o haz clic para subir</p>
                        <small style="color:#999; display:block; margin-top:5px;">JPG, PNG. Máx 2MB.</small>
                        <input type="file" name="image" id="file-input" accept="image/*" style="display:none;" required>
                        <img id="preview-image" class="preview-img" src="#" alt="Vista previa">
                    </div>
                    
                    @error('image') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Descripción Detallada</label>
                    <textarea name="description" rows="5" class="form-input" placeholder="Describe la experiencia..." required>{{ old('description') }}</textarea>
                </div>

                <div style="margin-top:30px;">
                    <button type="submit" class="btn-create" style="width:100%; font-size:1.1rem; padding: 15px; cursor: pointer;">Guardar Viaje</button>
                </div>

            </form>
        </div>
    </main>
</div>

<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-input');
    const previewImage = document.getElementById('preview-image');

    dropArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
        if (this.files.length) showPreview(this.files[0]);
    });

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    ['dragenter', 'dragover'].forEach(() => dropArea.classList.add('active'));
    ['dragleave', 'drop'].forEach(() => dropArea.classList.remove('active'));

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        showPreview(files[0]);
    });

    function showPreview(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>