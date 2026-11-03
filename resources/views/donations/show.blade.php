
@extends('layouts.admin')

@section('title', 'Detail Donasi - Admin Masjid Sabilillah')

@push('styles')
    @vite([
        'resources/css/admin-donations.css',
        'resources/css/admin-donation-show.css',
    ])
@endpush

@section('content')

@php
    $status = strtolower((string) $donation->verification_status);

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
        default => ucfirst((string) $donation->verification_status),
    };

    $formatRupiah = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };
@endphp

<div class="donations-page donation-detail-page">

    {{-- ==========================================
         PAGE HEADER
    =========================================== --}}

    <section class="admin-page-header">

        <div class="admin-page-header__content">

            <div class="admin-page-header__eyebrow">
                <span class="admin-page-header__line"></span>
                Masjid Sabilillah
            </div>

            <h1 class="admin-page-header__title">
                Detail Donasi
            </h1>

            <p class="admin-page-header__description">
                Informasi lengkap transaksi donasi yang tercatat
                dalam sistem administrasi Masjid Sabilillah.
            </p>

        </div>

        <div class="admin-page-header__action donation-detail-page__header-actions">

            <a
                href="{{ route('donations.index') }}"
                class="donations-button donations-button--secondary"
            >
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>
                Kembali
            </a>

            <a
                href="{{ route('donations.edit', $donation) }}"
                class="donations-button donations-button--primary"
            >
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>
                Ubah Donasi
            </a>

        </div>

    </section>


    {{-- ==========================================
         SUCCESS NOTIFICATION
    =========================================== --}}

    @if (session('success'))

        <div class="donation-show-alert" role="status">

            <svg viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="M20 6 9 17l-5-5"/>
                <circle cx="12" cy="12" r="10"/>
            </svg>

            <span>{{ session('success') }}</span>

        </div>

    @endif


    {{-- ==========================================
         DONATION DETAIL
    =========================================== --}}

    <section class="donation-show-card">

        {{-- CARD HEADER --}}

        <div class="donation-show-card__header">

            <div class="donation-show-card__heading">

                <div class="donation-show-card__icon">
                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="M12 2v20"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>

                <div>
                    <h2>Informasi Donasi</h2>

                    <p>
                        Rincian transaksi donasi yang tersimpan
                        dalam sistem.
                    </p>
                </div>

            </div>

            <span class="donation-show-card__reference">
                Detail Transaksi
            </span>

        </div>


        {{-- CARD BODY --}}

        <div class="donation-show-card__body">

            {{-- DONATION HIGHLIGHT --}}

            <div class="donation-show-highlight">

                <div class="donation-show-highlight__amount">

                    <span class="donation-show-label">
                        Nominal Donasi
                    </span>

                    <strong>
                        {{ $formatRupiah($donation->amount) }}
                    </strong>

                    <span class="donation-show-highlight__caption">
                        Jumlah donasi yang dicatat
                    </span>

                </div>

                <div class="donation-show-highlight__divider"></div>

                <div class="donation-show-highlight__verification">

                    <span class="donation-show-label">
                        Status Verifikasi
                    </span>

                    <span class="donation-show-status donation-show-status--{{ $statusClass }}">
                        <span class="donation-show-status__dot"></span>
                        {{ $statusLabel }}
                    </span>

                    <span class="donation-show-highlight__caption">
                        Status pencatatan transaksi
                    </span>

                </div>

            </div>


            {{-- DONOR INFORMATION --}}

            <div class="donation-show-section">

                <div class="donation-show-section__heading">

                    <div>
                        <span class="donation-show-section__eyebrow">
                            INFORMASI UTAMA
                        </span>

                        <h3>Data Donasi</h3>
                    </div>

                </div>

                <dl class="donation-show-grid">

                    <div class="donation-show-item">
                        <dt>Nama Donatur</dt>
                        <dd>{{ $donation->display_donor_name ?: '-' }}</dd>
                    </div>

                    <div class="donation-show-item">
                        <dt>Tanggal Donasi</dt>
                        <dd>
                            {{ $donation->donation_date?->format('d-m-Y') ?? '-' }}
                        </dd>
                    </div>

                    <div class="donation-show-item">
                        <dt>Kanal Donasi</dt>
                        <dd>{{ $donation->channel ?: '-' }}</dd>
                    </div>

                    <div class="donation-show-item">
                        <dt>Metode Pembayaran</dt>
                        <dd>{{ $donation->payment_method ?: '-' }}</dd>
                    </div>

                    <div class="donation-show-item donation-show-item--full">
                        <dt>Kategori Donasi</dt>
                        <dd>{{ $donation->category ?: '-' }}</dd>
                    </div>

                </dl>

            </div>


            {{-- NOTES --}}

            <div class="donation-show-section donation-show-section--notes">

                <div class="donation-show-section__heading">

                    <div>
                        <span class="donation-show-section__eyebrow">
                            KETERANGAN
                        </span>

                        <h3>Catatan Donasi</h3>
                    </div>

                </div>

                <div class="donation-show-notes">
                    <p>
                        {{ $donation->notes ?: 'Tidak ada catatan tambahan untuk transaksi donasi ini.' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- CARD FOOTER --}}

        <div class="donation-show-card__footer">

            <div class="donation-show-card__footer-info">

                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>

                <p>
                    Pastikan informasi transaksi sesuai dengan
                    catatan penerimaan donasi.
                </p>

            </div>

            <a
                href="{{ route('donations.edit', $donation) }}"
                class="donations-button donations-button--primary donation-show-edit-button"
            >
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>

                Ubah Data Donasi
            </a>

        </div>

    </section>

</div>

@endsection
