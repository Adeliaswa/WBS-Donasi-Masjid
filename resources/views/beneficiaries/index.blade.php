<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Data Penerima Manfaat | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-beneficiaries.css',
        'resources/js/app.js',
        'resources/js/admin-sidebar.js',
        'resources/js/beneficiary-categories.js',
    ])
    
</head>

<body class="admin-layout">

    {{-- Sidebar Admin --}}
    @include('components.admin.sidebar')

    {{-- Konten Utama --}}
    <div class="admin-main">
        <main class="beneficiaries-page">

            {{-- Header Halaman --}}
            <header class="beneficiaries-header">
                <div class="beneficiaries-header__content">
                    <span class="beneficiaries-header__eyebrow">
                        MASJID SABILILLAH
                    </span>

                    <h1 class="beneficiaries-header__title">
                        Data Penerima Manfaat
                    </h1>

                    <p class="beneficiaries-header__description">
                        Kelola dan pantau data penerima bantuan masjid
                        dengan tertib dan terstruktur.
                    </p>
                </div>

                <a
                    href="{{ route('beneficiaries.create') }}"
                    class="beneficiaries-button beneficiaries-button--primary"
                >
                    <span aria-hidden="true">+</span>
                    Tambah Penerima
                </a>
            </header>

            {{-- Notifikasi Berhasil --}}
            @if (session('success'))
                <div
                    class="beneficiaries-alert beneficiaries-alert--success"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if (session('error'))
                <div
                    class="beneficiaries-alert beneficiaries-alert--error"
                    role="alert"
                >
                    {{ session('error') }}
                </div>
            @endif

            {{-- Notifikasi Validasi --}}
            @if ($errors->any())
                <div
                    class="beneficiaries-alert beneficiaries-alert--error"
                    role="alert"
                >
                    <strong>
                        Data belum dapat diproses. Periksa kembali:
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Ringkasan Penerima Manfaat --}}
            @include('components.admin.beneficiaries.summary-cards')

            {{-- Pencarian dan Filter --}}
            @include('components.admin.beneficiaries.filters')

            {{-- Daftar Penerima Manfaat --}}
            <section
                class="beneficiaries-section"
                aria-labelledby="beneficiaries-list-title"
            >
                <div class="beneficiaries-section__header">
                    <div>
                        <h2
                            id="beneficiaries-list-title"
                            class="beneficiaries-section__title"
                        >
                            Daftar Penerima
                        </h2>

                        <p class="beneficiaries-section__description">
                            Informasi penerima manfaat yang tercatat
                            dalam sistem.
                        </p>
                    </div>

                    <span class="beneficiaries-section__count">
                        {{ number_format($beneficiaries->total(), 0, ',', '.') }}
                        data
                    </span>
                </div>

                {{-- Tabel Data --}}
                @include('components.admin.beneficiaries.table')

                {{-- Navigasi Halaman --}}
                @include('components.admin.beneficiaries.pagination')
            </section>

        </main>
    </div>

</body>
</html>
