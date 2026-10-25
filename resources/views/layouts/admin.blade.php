<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Masjid Sabilillah')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- CSS dan JS Laravel --}}
    @vite([
        'resources/css/app.css',
        'resources/css/admin-donation-form.css',
        'resources/js/app.js'
    ])
</head>
<body>
    @yield('content')
</body>
</html>