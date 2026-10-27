<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Detail Penerima Manfaat | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-beneficiaries-show.css',
        'resources/js/app.js',
        'resources/js/admin-sidebar.js',
        'resources/js/admin-beneficiaries-show.js',
    ])
</head>

<body class="admin-layout">

    {{-- Sidebar Admin --}}
    @include('components.admin.sidebar')

    <div class="admin-main">
        <main class="beneficiaries-page beneficiary-detail-page">

            {{-- Breadcrumb --}}
            <nav class="beneficiary-detail-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('beneficiaries.index') }}">
                    ← Data Penerima
                </a>

                <span class="beneficiary-detail-breadcrumb__separator">/</span>

                <span>Detail Penerima</span>
            </nav>

            {{-- Notifikasi Berhasil --}}
            @if (session('success'))
                <div
                    class="beneficiaries-alert beneficiaries-alert--success"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header --}}
            <header class="beneficiary-detail-header">
                <div class="beneficiary-detail-header__content">
                    <span class="beneficiary-detail-header__eyebrow">
                        MASJID SABILILLAH
                    </span>

                    <h1 class="beneficiary-detail-header__title">
                        Detail Penerima Manfaat
                    </h1>

                    <p class="beneficiary-detail-header__description">
                        Informasi lengkap penerima bantuan yang tersimpan
                        dalam sistem.
                    </p>

                    <div class="beneficiary-detail-header__meta">
                        <span>
                            ID Penerima:
                            <strong>#{{ $beneficiary->id }}</strong>
                        </span>

                        <span class="beneficiary-detail-header__meta-divider">
                            ·
                        </span>

                        <span>
                            Terdaftar
                            {{ $beneficiary->registered_at?->format('d M Y') ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="beneficiary-detail-header__actions">
                    <a
                        href="{{ route('beneficiaries.index') }}"
                        class="beneficiary-detail-button beneficiary-detail-button--secondary"
                    >
                        Kembali
                    </a>

                    <a
                        href="{{ route('beneficiaries.edit', $beneficiary) }}"
                        class="beneficiary-detail-button beneficiary-detail-button--primary"
                    >
                        Ubah Data
                    </a>
                </div>
            </header>

            {{-- Persiapan data kategori --}}
            @php
                $categoryName = $beneficiary->beneficiaryCategory?->name;

                $displayCategory = $categoryName ?? '-';

                if (
                    strtolower($categoryName ?? '') === 'lainnya'
                    && $beneficiary->other_category
                ) {
                    $displayCategory = $beneficiary->other_category;
                }
            @endphp

            {{-- Kartu Informasi Penerima --}}
            <section
                class="beneficiary-detail-card"
                aria-labelledby="beneficiary-detail-title"
            >
                <div class="beneficiary-detail-card__header">
                    <div>
                        <span class="beneficiary-detail-card__eyebrow">
                            INFORMASI PENERIMA
                        </span>

                        <h2
                            id="beneficiary-detail-title"
                            class="beneficiary-detail-card__title"
                        >
                            {{ $beneficiary->name }}
                        </h2>

                        <p class="beneficiary-detail-card__description">
                            Data identitas dan informasi administrasi penerima.
                        </p>
                    </div>

                    @if ($beneficiary->status === 'Aktif')
                        <span class="beneficiaries-status beneficiaries-status--active">
                            Aktif
                        </span>
                    @else
                        <span class="beneficiaries-status beneficiaries-status--inactive">
                            Tidak Aktif
                        </span>
                    @endif
                </div>

                <div class="beneficiary-detail-grid">

                    {{-- Nama --}}
                    <div class="beneficiary-detail-field">
                        <span class="beneficiary-detail-field__label">
                            Nama Penerima
                        </span>

                        <p class="beneficiary-detail-field__value">
                            {{ $beneficiary->name }}
                        </p>
                    </div>

                    {{-- NIK --}}
                    <div class="beneficiary-detail-field">
                        <span class="beneficiary-detail-field__label">
                            NIK
                        </span>

                        <p class="beneficiary-detail-field__value">
                            {{ $beneficiary->nik }}
                        </p>
                    </div>

                    {{-- Kontak --}}
                    <div class="beneficiary-detail-field">
                        <span class="beneficiary-detail-field__label">
                            Nomor Kontak
                        </span>

                        <p class="beneficiary-detail-field__value">
                            {{ $beneficiary->contact ?: '-' }}
                        </p>
                    </div>

                    {{-- Kategori --}}
                    <div class="beneficiary-detail-field">
                        <span class="beneficiary-detail-field__label">
                            Kategori Penerima
                        </span>

                        <p class="beneficiary-detail-field__value">
                            {{ $displayCategory }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="beneficiary-detail-field">
                        <span class="beneficiary-detail-field__label">
                            Status Penerima
                        </span>

                        <p class="beneficiary-detail-field__value">
                            {{ $beneficiary->status }}
                        </p>
                    </div>

                    {{-- Tanggal Terdaftar --}}
                    <div class="beneficiary-detail-field">
                        <span class="beneficiary-detail-field__label">
                            Tanggal Terdaftar
                        </span>

                        <p class="beneficiary-detail-field__value">
                            {{ $beneficiary->registered_at?->format('d-m-Y') ?? '-' }}
                        </p>
                    </div>

                    {{-- Alamat --}}
                    <div class="beneficiary-detail-field beneficiary-detail-field--full">
                        <span class="beneficiary-detail-field__label">
                            Alamat Lengkap
                        </span>

                        <p class="beneficiary-detail-field__value beneficiary-detail-field__value--multiline">
                            {{ $beneficiary->address }}
                        </p>
                    </div>

                    {{-- Kondisi --}}
                    <div class="beneficiary-detail-field beneficiary-detail-field--full">
                        <span class="beneficiary-detail-field__label">
                            Kondisi / Kriteria Penerima
                        </span>

                        <p class="beneficiary-detail-field__value beneficiary-detail-field__value--multiline">
                            {{ $beneficiary->condition ?: '-' }}
                        </p>
                    </div>

                    {{-- Catatan --}}
                    <div class="beneficiary-detail-field beneficiary-detail-field--full">
                        <span class="beneficiary-detail-field__label">
                            Catatan Tambahan
                        </span>

                        <p class="beneficiary-detail-field__value beneficiary-detail-field__value--multiline">
                            {{ $beneficiary->notes ?: '-' }}
                        </p>
                    </div>

                </div>

                {{-- Footer Kartu --}}
                <div class="beneficiary-detail-card__footer">
                    <span>
                        Terakhir diperbarui:
                        {{ $beneficiary->updated_at?->format('d-m-Y H:i') ?? '-' }}
                    </span>

                    <a href="{{ route('beneficiaries.index') }}">
                        Kembali ke daftar penerima
                    </a>
                </div>
            </section>

        </main>
    </div>

</body>
</html>
