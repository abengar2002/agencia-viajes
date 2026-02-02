<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component {

    // Renderiza la vista del layout para invitados (login, registro, etc.)
    public function render(): View {
        return view('layouts.guest');
    }
}