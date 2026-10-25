@extends('layouts.auth')

@section('title', 'Login Pengurus | Donasi Masjid')

@section('content')

<main class="login-page">
    <section class="login-card">

        {{-- PANEL KIRI: IDENTITAS DAN ILUSTRASI ISLAMI --}}
        <aside class="login-intro">

            <div class="brand">
                <div class="brand-logo" aria-hidden="true">
                    DS
                </div>

                <div class="brand-text">
                    <h2>Donasi Masjid</h2>
                    <p>Masjid Sabilillah</p>
                </div>
            </div>

            {{-- Hiasan bulan dan bintang tersebar di panel --}}
            <div class="islamic-decoration" aria-hidden="true">

                <span class="moon moon-one"></span>
                <span class="star star-one">✦</span>
                <span class="star star-two">✧</span>
                <span class="star star-three">✦</span>
                <span class="star star-four">·</span>
                <span class="star star-five">✧</span>

            </div>

            <div class="intro-content">

                <p class="intro-label">
                    SISTEM PENGELOLAAN DONASI
                </p>

                <h1>
                    Kelola Donasi,<br>
                    Bangun Kebaikan.
                </h1>

                <p class="intro-description">
                    Kelola amanah dan salurkan manfaat melalui
                    pengelolaan donasi yang tertib, transparan,
                    dan terorganisasi.
                </p>

            </div>

            {{-- Ilustrasi masjid --}}
            <div class="mosque-illustration" aria-hidden="true">
                <svg
                    viewBox="0 0 220 140"
                    xmlns="http://www.w3.org/2000/svg"
                    focusable="false"
                >
                    {{-- Kubah utama --}}
                    <path
                        d="M65 83
                           C65 58 84 38 110 29
                           C136 38 155 58 155 83"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    {{-- Badan masjid --}}
                    <path
                        d="M50 83 H170 V112 H50 Z"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    {{-- Pintu masjid --}}
                    <path
                        d="M98 112 V96
                           A12 12 0 0 1 122 96
                           V112"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    {{-- Menara kiri --}}
                    <path
                        d="M25 112 V58 L36 42 L47 58 V112"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M29 58 H43 M32 68 H40"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                    />

                    {{-- Menara kanan --}}
                    <path
                        d="M173 112 V58 L184 42 L195 58 V112"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M177 58 H191 M180 68 H188"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                    />

                    {{-- Garis dasar --}}
                    <path
                        d="M13 112 H207"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />
                </svg>
            </div>

            <footer class="intro-footer">
                <span class="footer-line" aria-hidden="true"></span>
                <p>Mengelola amanah, menebar manfaat.</p>
            </footer>

        </aside>


        {{-- PANEL KANAN: FORM LOGIN --}}
        <section class="login-panel">

            <div class="login-content">

                <header class="login-header">

                    <p class="login-eyebrow">
                        SELAMAT DATANG KEMBALI
                    </p>

                    <h2>Masuk ke Akun</h2>

                    <p class="login-description">
                        Masuk menggunakan akun pengurus untuk
                        melanjutkan ke sistem pengelolaan donasi.
                    </p>

                </header>


                {{-- Pesan kesalahan --}}
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif


                {{-- Pesan berhasil --}}
                @if (session('success'))
                    <div class="alert alert-success" role="status">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- Form login --}}
                @include('components.auth.login-from')


                <div class="login-notice">
                    <span class="notice-dot" aria-hidden="true"></span>
                    <p>Akses khusus untuk pengurus masjid.</p>
                </div>

            </div>

            <footer class="login-copyright">
                &copy; {{ date('Y') }} Masjid Sabilillah.
                Seluruh hak cipta dilindungi.
            </footer>

        </section>

    </section>
</main>

@endsection