<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', "Carmelo's Agency") }}</title>

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body style="background-color: var(--light); color: var(--dark);">
        
        @include('layouts.navigation')

        <main>
            {{ $slot }}
        </main>

        <footer style="text-align:center; padding:40px; color:var(--gray); font-size:0.9rem; border-top:1px solid var(--border); margin-top:50px;">
            &copy; {{ date('Y') }} Carmelo's Agency Inc.
        </footer>
    </body>
</html>