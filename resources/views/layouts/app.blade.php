<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Tailwind & App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        body {
            background: linear-gradient(to bottom, #e8f0ff, #ffffff);
        }
        .login-card {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border-radius: 1rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div id="app" class="w-full flex items-center justify-center px-4">
        <main class="w-full max-w-md login-card bg-white p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>