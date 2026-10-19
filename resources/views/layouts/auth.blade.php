<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Login | Donasi Masjid')</title>

    @vite([
        'resources/css/app.css',
        'resources/css/auth.css',
        'resources/js/app.js',
        'resources/js/auth.js'
    ])
</head>
<body class="auth-body">

    @yield('content')

</body>
</html>