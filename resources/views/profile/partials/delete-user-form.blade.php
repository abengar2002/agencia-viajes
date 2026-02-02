<section>
    <header style="margin-bottom: 25px;">
        <h2 style="font-size: 1.5rem; color: #dc2626; margin-bottom: 5px;">Eliminar Cuenta</h2>
        <p style="color: var(--gray);">Una vez eliminada, no podrás recuperar tus datos ni reservas.</p>
    </header>

    <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 25px; border-radius: 12px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <svg style="width:24px; height:24px; color:#991b1b;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            
            <p style="color: #991b1b; font-weight: bold; margin: 0;">
                ¿Estás seguro de que quieres hacer esto?
            </p>
        </div>
        
        <p style="color: #7f1d1d; font-size: 0.9rem; margin-bottom: 20px;">
            Para confirmar la eliminación permanente de tu cuenta, por favor introduce tu contraseña actual.
        </p>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="form-group" x-data="{ show: false }">
                <div style="position:relative;">
                    <input 
                        :type="show ? 'text' : 'password'" 
                        name="password" 
                        class="form-input" 
                        placeholder="Escribe tu contraseña para confirmar" 
                        style="border-color: #fca5a5; padding-right: 40px;"
                    />
                    
                    <button type="button" @click="show = !show" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#991b1b; display:flex; align-items:center;">
                        <svg x-show="!show" style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" style="width:20px; height:20px; display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                @error('password', 'userDeletion') <span style="color: #dc2626; font-size: 0.8rem; display:block; margin-top:5px;">{{ $message }}</span> @enderror
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn-primary" style="background: #dc2626; border: none; width: auto; display:inline-flex; align-items:center; gap:8px;" onclick="return confirm('ÚLTIMA ADVERTENCIA: ¿Borrar cuenta definitivamente?');">
                    <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    ELIMINAR CUENTA
                </button>
            </div>
        </form>
    </div>
</section>