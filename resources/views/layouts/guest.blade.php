<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Carmelo's Agency') }}</title>

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="auth-page"> <div style="width: 100%; display:flex; justify-content:center;">
            {{ $slot }}
        </div>

    </body>
</html>