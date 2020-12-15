<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content={{csrf_token()}}>
        <title>Storyclash</title>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ secure_asset('svg/logo.svg') }}">
        <script src="{{ mix('js/app.js')}}" defer></script>
    </head>
    <body>
        @component('components.sidebar', ['reports' => $reports])
        @endcomponent
        @yield("content")
    </body>
</html>
