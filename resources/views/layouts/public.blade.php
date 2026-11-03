
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Transparansi donasi dan penyaluran bantuan sosial Masjid Sabilillah.">

    <meta name="theme-color" content="#294236">

    <title>@yield('title', 'Transparansi Publik - Masjid Sabilillah')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/public/public.css',
        'resources/js/public/public.js'
    ])

    @stack('styles')
</head>

<body class="public-body">

    <div class="public-page">

        @include('public.partials.header')

        <main class="public-main">
            @yield('content')
        </main>

        @include('public.partials.footer')

    </div>

    @stack('scripts')

</body>
</html>
