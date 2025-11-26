<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? $theme['system_name'] ?? 'Kedai' }}</title>

    @if(isset($theme['favicon']) && $theme['favicon'])
        <link rel="icon" href="{{ asset('storage/' . $theme['favicon']) }}">
    @endif

    <!-- Dynamic Theme Colors -->
    <style>
        :root {
            --color-primary: {{ $theme['colors']['primary'] ?? '#1e3a8a' }};
            --color-secondary: {{ $theme['colors']['secondary'] ?? '#3b82f6' }};
            --color-tertiary: {{ $theme['colors']['tertiary'] ?? '#60a5fa' }};
        }
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @yield('content')
    </div>
</body>
</html>
