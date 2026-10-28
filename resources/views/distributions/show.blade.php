<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Detail Penyaluran Bantuan | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-distributions.css',
        'resources/css/admin-distribution-show.css'
    ])
</head>

<body class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        {{-- Header mobile --}}
        <div class="admin-mobile-header">
            <button
                type="button"
                class="admin-sidebar-toggle"
                id="openSidebar"
                aria-label="Buka menu navigasi"
                aria-controls="adminSidebar"
                aria-expanded="false"
            >
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M4 6H20M4 12H20M4 18H20"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    />
                </svg>
            </button>

            <div class="admin-mobile-header__identity">
                <span class="admin-mobile-header__title">
                    Masjid Sabilillah
                </span>

                <span class="admin-mobile-header__subtitle">
                    Panel Administrasi
                </span>
            </div>
        </div>

        <main class="distribution-detail-page">

            {{-- Header halaman --}}
            <header class="distribution-detail-header">

                <div class="distribution-detail-header__content">

                    <span class="distribution-detail-header__eyebrow">
                        MASJID SABILILLAH
                    </span>

                    <h1 class="distribution-detail-header__title">
                        Detail Penyaluran Bantuan
                    </h1>

                    <p class="distribution-detail-header__description">
                        Informasi lengkap mengenai penyaluran bantuan
                        kepada penerima manfaat.
                    </p>

                </div>

                <div class="distribution-detail-header__actions">

                    <a
                        href="{{ route('distributions.index') }}"
                        class="distribution-detail-button distribution-detail-button--secondary"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <path
                                d="M19 12H5M12 19L5 12L12 5"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                        Kembali
                    </a>

                </div>

            </header>


            {{-- Kartu detail --}}
            <section
                class="distribution-detail-card"
                aria-labelledby="distribution-detail-heading"
            >

                {{-- Header kartu --}}
                <div class="distribution-detail-card__header">

                    <div class="distribution-detail-card__identity">

                        <div
                            class="distribution-detail-card__icon"
                            aria-hidden="true"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <rect
                                    x="4"
                                    y="3"
                                    width="16"
                                    height="18"
                                    rx="2"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <path
                                    d="M8 8H16M8 12H16M8 16H13"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </div>

                        <div class="distribution-detail-card__heading">

                            <span class="distribution-detail-card__eyebrow">
                                RINCIAN PENYALURAN
                            </span>

                            <h2
                                id="distribution-detail-heading"
                                class="distribution-detail-card__title"
                            >
                                Informasi Penyaluran
                            </h2>

                            <p class="distribution-detail-card__description">
                                Rincian data penyaluran yang tersimpan dalam sistem.
                            </p>

                        </div>

                    </div>

                    <span class="distribution-detail-id">
                        ID #{{ $distribution->id }}
                    </span>

                </div>


                {{-- Persiapan status --}}
                @php
                    $status = strtolower(
                        trim((string) ($distribution->status ?? ''))
                    );

                    $statusClass = match ($status) {
                        'disalurkan', 'distributed', 'completed' => 'success',
                        'pending', 'menunggu', 'menunggu verifikasi' => 'pending',
                        'diproses', 'processing' => 'processing',
                        'dibatalkan', 'cancelled', 'canceled',
                        'ditolak', 'rejected' => 'danger',
                        default => 'neutral',
                    };

                    $statusLabel = match ($status) {
                        'disalurkan', 'distributed', 'completed' => 'Disalurkan',
                        'pending', 'menunggu', 'menunggu verifikasi' => 'Menunggu',
                        'diproses', 'processing' => 'Diproses',
                        'dibatalkan', 'cancelled', 'canceled' => 'Dibatalkan',
                        'ditolak', 'rejected' => 'Ditolak',
                        default => $distribution->status ?: 'Belum ditentukan',
                    };
                @endphp


                {{-- Isi kartu --}}
                <div class="distribution-detail-card__body">

                    {{-- Ringkasan nominal dan status --}}
                    <div class="distribution-detail-summary">

                        <div class="distribution-detail-summary__amount">

                            <span class="distribution-detail-summary__label">
                                Total Nilai Bantuan
                            </span>

                            <strong>
                                Rp{{ number_format(
                                    (float) $distribution->amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                            <span class="distribution-detail-summary__note">
                                Nilai bantuan yang tercatat pada penyaluran ini.
                            </span>

                        </div>

                        <div class="distribution-detail-summary__status">

                            <span class="distribution-detail-summary__label">
                                Status Penyaluran
                            </span>

                            <span class="distribution-detail-status distribution-detail-status--{{ $statusClass }}">
                                <span
                                    class="distribution-detail-status__dot"
                                    aria-hidden="true"
                                ></span>

                                {{ $statusLabel }}
                            </span>

                        </div>

                    </div>


                    {{-- Informasi detail --}}
                    <dl class="distribution-detail-grid">

                        {{-- Tanggal --}}
                        <div class="distribution-detail-item">

                            <dt>Tanggal Penyaluran</dt>

                            <dd>
                                {{ $distribution->distribution_date
                                    ? $distribution->distribution_date->format('d-m-Y')
                                    : '-' }}
                            </dd>

                        </div>


                        {{-- Penerima --}}
                        <div class="distribution-detail-item">

                            <dt>Nama Penerima Manfaat</dt>

                            <dd>
                                {{ $distribution->beneficiary?->name ?? '-' }}
                            </dd>

                        </div>


                        {{-- Jenis bantuan --}}
                        <div class="distribution-detail-item">

                            <dt>Jenis Bantuan</dt>

                            <dd>
                                <span class="distribution-detail-type">
                                    {{ $distribution->assistance_type ?: '-' }}
                                </span>
                            </dd>

                        </div>


                        {{-- Sumber donasi --}}
                        <div class="distribution-detail-item">

                            <dt>Sumber Donasi</dt>

                            <dd>
                                @if ($distribution->donation)

                                    <span class="distribution-detail-donation">
                                        Donasi #{{ $distribution->donation->id }}
                                    </span>

                                    <span class="distribution-detail-donation__amount">
                                        Rp{{ number_format(
                                            (float) $distribution->donation->amount,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>

                                @else

                                    <span class="distribution-detail-muted">
                                        Tidak dipilih
                                    </span>

                                @endif
                            </dd>

                        </div>


                        {{-- Catatan --}}
                        <div class="distribution-detail-item distribution-detail-item--full">

                            <dt>Catatan</dt>

                            <dd class="distribution-detail-notes">
                                @if (filled($distribution->notes))
                                    {{ $distribution->notes }}
                                @else
                                    <span class="distribution-detail-muted">
                                        Tidak ada catatan untuk penyaluran ini.
                                    </span>
                                @endif
                            </dd>

                        </div>

                    </dl>

                </div>


                {{-- Footer kartu --}}
                <footer class="distribution-detail-card__footer">

                    <p>
                        Pastikan informasi penyaluran sudah sesuai
                        sebelum melakukan perubahan data.
                    </p>

                    <a
                        href="{{ route('distributions.edit', $distribution) }}"
                        class="distribution-detail-button distribution-detail-button--primary"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <path
                                d="M12 20H21"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <path
                                d="M16.5 3.5A2.12 2.12 0 0 1 19.5 6.5L8 18L4 19L5 15L16.5 3.5Z"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                        Edit Penyaluran
                    </a>

                </footer>

            </section>

        </main>

    </div>

    @vite([
        'resources/js/admin-sidebar.js'
    ])

</body>
</html>
