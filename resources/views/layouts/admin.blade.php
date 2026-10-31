<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>@yield('title', 'Admin Masjid Sabilillah')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Poppins dimuat melalui @import di resources/css/app.css. --}}

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-header.css',
        'resources/css/admin-footer.css',
        'resources/css/admin-layout.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>
<body class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">
        @include('components.admin.header')

        <main class="admin-main__content">
            @yield('content')
        </main>

        @include('components.admin.footer')
    </div>

    @stack('scripts')
</body>
</html>
