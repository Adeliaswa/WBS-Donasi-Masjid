
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Detail Donasi | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-donations.css'
    ])
</head>

<body class="admin-layout">

    {{-- Sidebar navigasi admin --}}
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

        <main class="donations-page donation-detail-page">

            {{-- Header halaman --}}
            <header class="donations-page__header">

                <div class="donations-page__heading">
                    <div class="donations-page__identity">

                        <span class="donations-page__eyebrow">
                            MASJID SABILILLAH
                        </span>

                        <h1 class="donations-page__title">
                            Detail Donasi
                        </h1>

                        <p class="donations-page__description">
                            Informasi lengkap pencatatan donasi masjid
                            yang tersimpan dalam sistem.
                        </p>

                    </div>
                </div>

                <div class="donation-detail-page__actions">

                    <a
                        href="{{ route('donations.index') }}"
                        class="donations-button donations-button--secondary"
                    >
                        Kembali
                    </a>

                    <a
                        href="{{ route('donations.edit', $donation) }}"
                        class="donations-button donations-button--primary"
                    >
                        Ubah Donasi
                    </a>

                </div>

            </header>

            {{-- Notifikasi berhasil --}}
            @if (session('success'))
                <div
                    class="donations-alert donations-alert--success"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Status donasi --}}
            @php
                $status = strtolower(
                    (string) $donation->verification_status
                );

                $statusClass = match ($status) {
                    'pending' => 'pending',
                    'verified' => 'verified',
                    'rejected' => 'rejected',
                    default => 'unknown',
                };

                $statusLabel = match ($status) {
                    'pending' => 'Menunggu Verifikasi',
                    'verified' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                    default => ucfirst(
                        (string) $donation->verification_status
                    ),
                };
            @endphp

            {{-- Kartu detail donasi --}}
            <section
                class="donation-detail-card"
                aria-labelledby="donationDetailTitle"
            >

                <div class="donation-detail-card__header">

                    <div>
                        <h2
                            class="donations-section__title"
                            id="donationDetailTitle"
                        >
                            Informasi Donasi
                        </h2>

                        <p class="donations-section__description">
                            Rincian donasi untuk membantu proses
                            pencatatan dan verifikasi.
                        </p>
                    </div>

                    <span class="donation-detail-card__label">
                        Detail transaksi
                    </span>

                </div>

                <div class="donation-detail-card__body">

                    {{-- Ringkasan nominal dan status --}}
                    <div class="donation-detail-summary">

                        <div class="donation-detail-summary__amount">
                            <span class="donation-detail-summary__label">
                                Nominal Donasi
                            </span>

                            <strong>
                                Rp {{ number_format(
                                    (float) $donation->amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>
                        </div>

                        <div class="donation-detail-summary__status">
                            <span class="donation-detail-summary__label">
                                Status Verifikasi
                            </span>

                            <span
                                class="donations-status donations-status--{{ $statusClass }}"
                            >
                                {{ $statusLabel }}
                            </span>
                        </div>

                    </div>

                    {{-- Rincian informasi donasi --}}
                    <dl class="donation-detail-grid">

                        <div class="donation-detail-item">
                            <dt>Nama Donatur</dt>
                            <dd>
                                {{ $donation->display_donor_name }}
                            </dd>
                        </div>

                        <div class="donation-detail-item">
                            <dt>Tanggal Donasi</dt>
                            <dd>
                                {{ $donation->donation_date?->format('d-m-Y') ?? '-' }}
                            </dd>
                        </div>

                        <div class="donation-detail-item">
                            <dt>Kanal Donasi</dt>
                            <dd>
                                {{ $donation->channel ?: '-' }}
                            </dd>
                        </div>

                        <div class="donation-detail-item">
                            <dt>Metode Pembayaran</dt>
                            <dd>
                                {{ $donation->payment_method ?: '-' }}
                            </dd>
                        </div>

                        <div class="donation-detail-item">
                            <dt>Kategori Donasi</dt>
                            <dd>
                                {{ $donation->category ?: '-' }}
                            </dd>
                        </div>

                        <div class="donation-detail-item donation-detail-item--full">
                            <dt>Catatan</dt>
                            <dd class="donation-detail-item__notes">
                                {{ $donation->notes ?: '-' }}
                            </dd>
                        </div>

                    </dl>

                </div>

                {{-- Footer kartu --}}
                <div class="donation-detail-card__footer">

                    <p>
                        Pastikan informasi donasi sesuai dengan
                        catatan penerimaan yang tersimpan.
                    </p>

                    <a
                        href="{{ route('donations.edit', $donation) }}"
                        class="donations-button donations-button--primary"
                    >
                        Ubah Data Donasi
                    </a>

                </div>

            </section>

        </main>

    </div>

    {{-- JavaScript navigasi sidebar --}}
    @vite([
        'resources/js/admin-sidebar.js'
    ])

</body>
</html>
