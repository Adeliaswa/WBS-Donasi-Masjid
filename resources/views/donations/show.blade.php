
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

    @include('components.admin.sidebar')

    <div class="admin-main">

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

        <main class="donations-page">

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
                            Informasi lengkap pencatatan donasi masjid.
                        </p>
                    </div>
                </div>

                <a
                    href="{{ route('donations.index') }}"
                    class="donations-button donations-button--secondary"
                >
                    Kembali
                </a>
            </header>

            <section class="donations-section">
                <div class="donations-section__header">
                    <div>
                        <h2 class="donations-section__title">
                            Informasi Donasi
                        </h2>
                        <p class="donations-section__description">
                            Rincian data donasi yang tersimpan dalam sistem.
                        </p>
                    </div>
                </div>

                <div class="donations-table-wrapper">
                    <table class="donations-table">
                        <tbody>
                            <tr>
                                <th scope="row">Nama Donatur</th>
                                <td>{{ $donation->display_donor_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal Donasi</th>
                                <td>{{ $donation->donation_date->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nominal Donasi</th>
                                <td>Rp {{ number_format((float) $donation->amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kanal</th>
                                <td>{{ $donation->channel }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Metode Pembayaran</th>
                                <td>{{ $donation->payment_method }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kategori</th>
                                <td>{{ $donation->category }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status Verifikasi</th>
                                <td>
                                    @switch(strtolower($donation->verification_status))
                                        @case('pending')
                                            Menunggu Verifikasi
                                            @break
                                        @case('verified')
                                            Terverifikasi
                                            @break
                                        @case('rejected')
                                            Ditolak
                                            @break
                                        @default
                                            {{ $donation->verification_status }}
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Catatan</th>
                                <td>{{ $donation->notes ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bukti Donasi</th>
                                <td>{{ $donation->proof_path ?: '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="padding: 20px 24px;">
                    <a
                        href="{{ route('donations.edit', $donation) }}"
                        class="donations-button donations-button--primary"
                    >
                        Ubah Donasi
                    </a>
                </div>
            </section>

        </main>
    </div>

    @vite([
        'resources/js/admin-sidebar.js',
        'resources/js/admin-donations.js'
    ])

</body>
</html>
