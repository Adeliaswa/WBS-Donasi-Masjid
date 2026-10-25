<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#294236">

    <title>Data Donasi | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-donations.css'
    ])
</head>

<body class="admin-layout">

    {{-- Sidebar navigasi admin --}}
    @include('components.admin.sidebar')

    {{-- Area utama halaman --}}
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


        <main class="donations-page">

            {{-- Header halaman --}}
            <header class="donations-page__header">

                <div class="donations-page__heading">

                    <div class="donations-page__identity">

                        <span class="donations-page__eyebrow">
                            MASJID SABILILLAH
                        </span>

                        <h1 class="donations-page__title">
                            Data Donasi
                        </h1>

                        <p class="donations-page__description">
                            Kelola dan pantau pencatatan donasi masjid
                            dengan tertib, amanah, dan transparan.
                        </p>

                    </div>

                </div>

                <a
                    href="{{ route('donations.create') }}"
                    class="donations-button donations-button--primary"
                >
                    <span aria-hidden="true">+</span>
                    Tambah Donasi
                </a>

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


            {{-- Notifikasi kesalahan --}}
            @if ($errors->any())

                <div
                    class="donations-alert donations-alert--error"
                    role="alert"
                >

                    <strong>
                        Data belum dapat diproses.
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            {{-- Ringkasan donasi --}}
            @include('components.admin.donations.summary-cards')


            {{-- Pencarian dan filter --}}
            @include('components.admin.donations.filters')


            {{-- Daftar donasi --}}
            <section class="donations-section">

                <div class="donations-section__header">

                    <div>

                        <h2 class="donations-section__title">
                            Daftar Donasi
                        </h2>

                        <p class="donations-section__description">
                            Pantau pencatatan dan status verifikasi donasi
                            yang tersimpan dalam sistem.
                        </p>

                    </div>

                    <span class="donations-section__count">
                        {{ $donations->total() }} data
                    </span>

                </div>


                {{-- Tabel donasi --}}
                @include('components.admin.donations.table')


                {{-- Navigasi halaman --}}
                @include('components.admin.donations.pagination')

            </section>

        </main>

    </div>


    {{-- Modal konfirmasi penghapusan --}}
    <div
        class="donations-modal"
        id="deleteDonationModal"
        aria-hidden="true"
    >

        <div
            class="donations-modal__backdrop"
            data-close-modal
        ></div>

        <div
            class="donations-modal__dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="deleteDonationTitle"
        >

            <div
                class="donations-modal__icon"
                aria-hidden="true"
            >
                !
            </div>

            <h2
                class="donations-modal__title"
                id="deleteDonationTitle"
            >
                Hapus Data Donasi?
            </h2>

            <p class="donations-modal__description">
                Apakah kamu yakin ingin menghapus data donasi atas nama
                <strong id="deleteDonationName">ini</strong>?
                Periksa kembali sebelum melanjutkan.
            </p>

            <div class="donations-modal__actions">

                <button
                    type="button"
                    class="donations-button donations-button--secondary"
                    data-close-modal
                >
                    Batal
                </button>

                <form
                    id="deleteDonationForm"
                    method="POST"
                    action=""
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="donations-button donations-button--danger"
                    >
                        Ya, Hapus
                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- Interaksi sidebar dan halaman donasi --}}
    @vite([
        'resources/js/admin-sidebar.js',
        'resources/js/admin-donations.js'
    ])

</body>

</html>