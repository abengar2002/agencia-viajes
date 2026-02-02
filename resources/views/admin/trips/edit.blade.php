<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Viaje - Carmelo's Agency Admin</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <style>
        /* --- 1. ALINEACIÓN DEL SIDEBAR (Solo geometría, sin colores) --- */
        .nav-item {
            display: flex !important;
            align-items: center !important;
        }
        .nav-item svg {
            display: block; 
            margin-right: 10px;
            margin-bottom: 0 !important;
        }

        /* --- 2. CLASES PARA ALINEAR EL FORMULARIO (NUEVO) --- */
        /* Esto hace que los campos se "centren" y estiren igual que en Create */
        .form-row {
            display: flex;
            gap: 20px; /* Espacio entre columnas */
            margin-bottom: 15px;
        }
        
        .form-col {
            flex: 1; /* Esto obliga a que todos midan lo mismo */
            display: flex;
            flex-direction: column;
        }

        /* --- 3. ESTILOS DE LA ZONA DE ARRASTRAR (Drag & Drop) --- */
        .drop-zone {
            border: 2px dashed #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .drop-zone:hover, .drop-zone.active {
            border-color: #ea580c;
            background-color: #fff7ed;
        }

        .drop-zone p {
            margin: 10px 0 0;
            color: #666;
            font-weight: 600;
        }

        .preview-img {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: block;
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
            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        
        <div class="menu-label" style="margin-top:20px;">Gestión</div>
        <a href="{{ route('admin.trips.index') }}" class="nav-item active">
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
        <div class="admin-header">
            <h1 class="page-title">Editar Viaje</h1>
            <a href="{{ route('admin.trips.index') }}" class="action-btn" style="background:#ddd; text-decoration:none; color:#333; display:flex; align-items:center; gap:5px;">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Cancelar
            </a>
        </div>

        <div class="table-container" style="padding: 40px; max-width: 800px;">
            
            <form action="{{ route('admin.trips.update', $trip) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Título del Viaje</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $trip->title) }}" required>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label">Ubicación</label>
                        <input type="text" name="destination" class="form-input" value="{{ old('destination', $trip->destination) }}" required>
                    </div>
                    <div class="form-col">
                        <label class="form-label">Precio ($)</label>
                        <input type="number" name="price" class="form-input" value="{{ old('price', $trip->price) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label">Fecha de Ida</label>
                        <input type="date" name="start_date" class="form-input" value="{{ old('start_date', $trip->start_date) }}" required>
                    </div>
                    <div class="form-col">
                        <label class="form-label">Fecha de Vuelta</label>
                        <input type="date" name="end_date" class="form-input" value="{{ old('end_date', $trip->end_date) }}" required>
                    </div>
                    <div class="form-col">
                        <label class="form-label">Categoría</label>
                        <select name="category_id" class="form-input" required style="background: white;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $trip->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ str_replace(['🏖️', '🏔️', '🏙️', '🎒', '💎', '🏝️', '🏕️'], '', $category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Imagen de Portada</label>
                    
                    <div id="drop-area" class="drop-zone">
                        <svg style="width:40px; height:40px; color:#9ca3af; margin-bottom:5px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        
                        <p>Arrastra para cambiar la imagen</p>
                        
                        <input type="file" name="image" id="file-input" accept="image/*" style="display:none;">
                        
                        <img id="preview-image" class="preview-img" 
                             src="{{ Str::startsWith($trip->image, 'http') ? $trip->image : asset($trip->image) }}" 
                             alt="Imagen del viaje">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="5" class="form-input" required>{{ old('description', $trip->description) }}</textarea>
                </div>

                <div style="margin-top:30px;">
                    <button type="submit" class="btn-create" style="width:100%; font-size:1.1rem; cursor: pointer;">Actualizar Viaje</button>
                </div>

            </form>
        </div>
    </main>
</div>

<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-input');
    const previewImage = document.getElementById('preview-image');

    // 1. Clic
    dropArea.addEventListener('click', () => fileInput.click());

    // 2. Cambio manual
    fileInput.addEventListener('change', function() {
        if (this.files.length) showPreview(this.files[0]);
    });

    // 3. Drag & Drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eName => {
        dropArea.addEventListener(eName, (e) => { e.preventDefault(); e.stopPropagation(); });
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
            }
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>