<section>
    <header style="margin-bottom: 25px;">
        <h2 style="font-size: 1.5rem; color: var(--dark); margin-bottom: 5px;">Información Personal</h2>
        <p style="color: var(--gray);">Actualiza tu foto, nombre y correo electrónico.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-group">
            <label class="form-label">Tu Foto</label>
            
            <div id="avatar-drop-area" style="border: 2px dashed #fdba74; background-color: #fff7ed; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center;">
                
                <div style="width: 80px; height: 80px; margin-bottom: 10px; position: relative;">
                    @if($user->avatar)
                        <img id="avatar-preview-small" src="{{ asset('storage/' . $user->avatar) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    @else
                         <div id="avatar-initials" style="width: 100%; height: 100%; border-radius: 50%; background: #ea580c; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <img id="avatar-preview-small" src="" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: none;">
                    @endif
                </div>

                <div style="color: #9ca3af; margin-bottom: 5px;">
                     <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                
                <p style="margin: 0; font-size: 0.9rem; color: #ea580c; font-weight: 700;">Haz clic o arrastra para cambiar</p>
                
                <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display:none;">
            </div>
            @error('avatar') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nombre Completo</label>
            <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Correo Electrónico</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 10px; background: #fff7ed; padding: 10px; border-radius: 8px; border: 1px solid #fdba74;">
                    <p style="font-size: 0.9rem; color: #9a3412; margin: 0; display:flex; align-items:center; gap:8px;">
                         <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Tu correo no está verificado.
                    </p>
                    <button form="send-verification" style="background: none; border: none; color: #ea580c; text-decoration: underline; cursor: pointer; font-weight: bold; font-size: 0.9rem; margin-top: 5px;">
                        Reenviar correo de verificación.
                    </button>
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn-primary" style="width: auto; padding: 12px 30px;">Guardar Cambios</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="color: #166534; font-weight: bold; display:flex; align-items:center; gap:5px; margin:0;">
                    <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardado correctamente.
                </p>
            @endif
        </div>
    </form>

    <script>
        const avatarDrop = document.getElementById('avatar-drop-area');
        const avatarInp = document.getElementById('avatar-input');
        const avatarPrev = document.getElementById('avatar-preview-small');
        const avatarInitials = document.getElementById('avatar-initials');

        // 1. Abrir selector
        avatarDrop.addEventListener('click', () => avatarInp.click());

        // 2. Cambio manual
        avatarInp.addEventListener('change', function() {
            if (this.files.length) showAvatarPreview(this.files[0]);
        });

        // 3. Drag & Drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eName => {
            avatarDrop.addEventListener(eName, (e) => { e.preventDefault(); e.stopPropagation(); });
        });

        // Efectos visuales
        avatarDrop.addEventListener('dragover', () => avatarDrop.style.backgroundColor = '#ffedd5');
        avatarDrop.addEventListener('dragleave', () => avatarDrop.style.backgroundColor = '#fff7ed');

        // Soltar archivo
        avatarDrop.addEventListener('drop', (e) => {
            avatarDrop.style.backgroundColor = '#fff7ed';
            const files = e.dataTransfer.files;
            avatarInp.files = files; // Asignar al input
            showAvatarPreview(files[0]);
        });

        function showAvatarPreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    // Actualizar la miniatura de este formulario
                    avatarPrev.src = e.target.result;
                    avatarPrev.style.display = 'block';
                    if(avatarInitials) avatarInitials.style.display = 'none';
                    
                    // INTENTO DE MAGIA: Si existe la foto grande en el layout principal (edit.blade.php), actualizarla también
                    const mainAvatar = document.getElementById('avatar-preview-top');
                    if(mainAvatar) mainAvatar.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</section>