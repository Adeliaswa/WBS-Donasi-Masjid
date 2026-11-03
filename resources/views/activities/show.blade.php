@extends('layouts.admin')

@section('title', 'Detail Kegiatan - Admin Masjid Sabilillah')

@push('styles')
    @vite([
        'resources/css/admin-donations.css',
        'resources/css/admin-activity-show.css',
    ])
@endpush

@section('content')

@php
    $isPublished = (bool) $activity->is_published;

    $statusClass = $isPublished ? 'published' : 'draft';
    $statusLabel = $isPublished ? 'Dipublikasikan' : 'Draft';
    $statusCaption = $isPublished
        ? 'Kegiatan tampil di halaman publik'
        : 'Kegiatan belum tampil di halaman publik';
@endphp

<div class="donations-page activity-detail-page">

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
                Detail Kegiatan
            </h1>

            <p class="admin-page-header__description">
                Informasi lengkap kegiatan yang tercatat
                dalam sistem administrasi Masjid Sabilillah.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('activities.index') }}"
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
                href="{{ route('activities.edit', $activity) }}"
                class="donations-button donations-button--primary"
            >
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>
                Ubah Kegiatan
            </a>

        </div>

    </section>


    {{-- ==========================================
         SUCCESS NOTIFICATION
    =========================================== --}}

    @if (session('success'))

        <div class="activity-show-alert" role="status">

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
         ACTIVITY DETAIL
    =========================================== --}}

    <section class="activity-show-card">

        {{-- CARD HEADER --}}

        <div class="activity-show-card__header">

            <div class="activity-show-card__heading">

                <div class="activity-show-card__icon">
                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                        <path d="M3.5 10H20.5M8 3V6.5M16 3V6.5"/>
                    </svg>
                </div>

                <div>
                    <h2>Informasi Kegiatan</h2>

                    <p>
                        Rincian kegiatan yang tersimpan dalam sistem.
                    </p>
                </div>

            </div>

            <span class="activity-show-card__reference">
                Detail Kegiatan
            </span>

        </div>


        {{-- CARD BODY --}}

        <div class="activity-show-card__body">

            {{-- HIGHLIGHT --}}

            <div class="activity-show-highlight">

                <div class="activity-show-highlight__date">

                    <span class="activity-show-label">
                        Tanggal Kegiatan
                    </span>

                    <strong>
                        {{ $activity->activity_date?->format('d-m-Y') ?? '-' }}
                    </strong>

                    <span class="activity-show-highlight__caption">
                        Tanggal pelaksanaan kegiatan
                    </span>

                </div>

                <div class="activity-show-highlight__divider"></div>

                <div class="activity-show-highlight__status">

                    <span class="activity-show-label">
                        Status Publikasi
                    </span>

                    <span class="activity-show-status activity-show-status--{{ $statusClass }}">
                        <span class="activity-show-status__dot"></span>
                        {{ $statusLabel }}
                    </span>

                    <span class="activity-show-highlight__caption">
                        {{ $statusCaption }}
                    </span>

                </div>

            </div>


            {{-- MAIN INFORMATION --}}

            <div class="activity-show-section">

                <div class="activity-show-section__heading">

                    <div>
                        <span class="activity-show-section__eyebrow">
                            INFORMASI UTAMA
                        </span>

                        <h3>Data Kegiatan</h3>
                    </div>

                </div>

                <dl class="activity-show-grid">

                    <div class="activity-show-item activity-show-item--full">
                        <dt>Judul Kegiatan</dt>
                        <dd>{{ $activity->title ?: '-' }}</dd>
                    </div>

                    <div class="activity-show-item">
                        <dt>Dibuat Pada</dt>
                        <dd>
                            {{ $activity->created_at?->format('d-m-Y H:i') ?? '-' }}
                        </dd>
                    </div>

                    <div class="activity-show-item">
                        <dt>Terakhir Diperbarui</dt>
                        <dd>
                            {{ $activity->updated_at?->format('d-m-Y H:i') ?? '-' }}
                        </dd>
                    </div>

                </dl>

            </div>


            {{-- IMAGE (tampil hanya jika ada gambar) --}}

            @if ($activity->image_path)

                <div class="activity-show-section activity-show-section--image">

                    <div class="activity-show-section__heading">

                        <div>
                            <span class="activity-show-section__eyebrow">
                                DOKUMENTASI
                            </span>

                            <h3>Gambar Kegiatan</h3>
                        </div>

                    </div>

                    <div class="activity-show-image">
                        <img
                            src="{{ asset('storage/' . $activity->image_path) }}"
                            alt="Gambar kegiatan {{ $activity->title }}"
                            loading="lazy"
                        >
                    </div>

                </div>

            @endif


            {{-- DESCRIPTION --}}

            <div class="activity-show-section activity-show-section--notes">

                <div class="activity-show-section__heading">

                    <div>
                        <span class="activity-show-section__eyebrow">
                            KETERANGAN
                        </span>

                        <h3>Deskripsi Kegiatan</h3>
                    </div>

                </div>

                <div class="activity-show-notes">
                    <p>
                        {{ $activity->description ?: 'Belum ada deskripsi untuk kegiatan ini.' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- CARD FOOTER --}}

        <div class="activity-show-card__footer">

            <div class="activity-show-card__footer-info">

                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>

                <p>
                    Pastikan informasi kegiatan sudah benar sebelum
                    dipublikasikan kepada jamaah.
                </p>

            </div>

            <a
                href="{{ route('activities.edit', $activity) }}"
                class="donations-button donations-button--primary activity-show-edit-button"
            >
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>

                Ubah Data Kegiatan
            </a>

        </div>

    </section>

</div>

@endsection