<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="MotoVerse — the Middle East's multi-brand motorcycle house. Discover Volta, Nomad, Apex and Sovereign, book a test ride and find your nearest showroom.">
        <meta name="theme-color" content="#0a0b0d">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,500;0,600;0,700;0,800;1,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <x-inertia::head>
            <title>{{ config('app.name', 'MotoVerse') }}</title>
        </x-inertia::head>
    </head>
    <body class="bg-ink-950 text-ink-100 font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
