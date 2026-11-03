
@extends('layouts.admin')

@section('title', 'Detail Penyaluran Bantuan - Admin Masjid Sabilillah')

@push('styles')
    @vite([
        'resources/css/admin-distributions.css',
        'resources/css/admin-distribution-show.css',
    ])
@endpush

@section('content')

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

    $formatRupiah = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };
@endphp

<div class="distribution-page distribution-detail-page">

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
                Detail Penyaluran Bantuan
            </h1>

            <p class="admin-page-header__description">
                Informasi lengkap mengenai penyaluran bantuan
                kepada penerima manfaat Masjid Sabilillah.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('distributions.index') }}"
                class="distribution-button distribution-button--secondary"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>

                Kembali
            </a>

            <a
                href="{{ route('distributions.edit', $distribution) }}"
                class="distribution-button distribution-button--primary"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>

                Edit Penyaluran
            </a>

        </div>

    </section>


    {{-- ==========================================
         SUCCESS NOTIFICATION
    =========================================== --}}

    @if (session('success'))

        <div class="distribution-show-alert" role="status">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="12" cy="12" r="10"/>
                <path d="m8 12 3 3 5-6"/>
            </svg>

            <span>{{ session('success') }}</span>

        </div>

    @endif


    {{-- ==========================================
         DETAIL CARD
    =========================================== --}}

    <section
        class="distribution-show-card"
        aria-labelledby="distributionShowTitle"
    >

        {{-- CARD HEADER --}}

        <div class="distribution-show-card__header">

            <div class="distribution-show-card__heading">

                <div class="distribution-show-card__icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                </div>

                <div>

                    <h2 id="distributionShowTitle">
                        Informasi Penyaluran
                    </h2>

                    <p>
                        Rincian data penyaluran yang tersimpan
                        dalam sistem administrasi.
                    </p>

                </div>

            </div>

            <span class="distribution-show-reference">
                ID #{{ $distribution->id }}
            </span>

        </div>


        {{-- CARD BODY --}}

        <div class="distribution-show-card__body">

            {{-- ==================================
                 SUMMARY
            =================================== --}}

            <div class="distribution-show-highlight">

                <div class="distribution-show-highlight__amount">

                    <span class="distribution-show-label">
                        Total Nilai Bantuan
                    </span>

                    <strong>
                        {{ $formatRupiah($distribution->amount) }}
                    </strong>

                    <span class="distribution-show-caption">
                        Nilai bantuan yang tercatat pada penyaluran ini.
                    </span>

                </div>

                <div class="distribution-show-highlight__divider"></div>

                <div class="distribution-show-highlight__status">

                    <span class="distribution-show-label">
                        Status Penyaluran
                    </span>

                    <span class="distribution-show-status distribution-show-status--{{ $statusClass }}">
                        <span class="distribution-show-status__dot"></span>
                        {{ $statusLabel }}
                    </span>

                    <span class="distribution-show-caption">
                        Status pelaksanaan penyaluran bantuan.
                    </span>

                </div>

            </div>


            {{-- ==================================
                 MAIN INFORMATION
            =================================== --}}

            <div class="distribution-show-section">

                <div class="distribution-show-section__heading">

                    <div>

                        <span class="distribution-show-section__eyebrow">
                            INFORMASI UTAMA
                        </span>

                        <h3>Data Penyaluran</h3>

                    </div>

                </div>


                <dl class="distribution-show-grid">

                    {{-- TANGGAL PENYALURAN --}}

                    <div class="distribution-show-item">

                        <dt>Tanggal Penyaluran</dt>

                        <dd>
                            {{ $distribution->distribution_date
                                ? $distribution->distribution_date->format('d-m-Y')
                                : '-' }}
                        </dd>

                    </div>


                    {{-- PENERIMA MANFAAT --}}

                    <div class="distribution-show-item">

                        <dt>Nama Penerima Manfaat</dt>

                        <dd>
                            {{ $distribution->beneficiary?->name ?? '-' }}
                        </dd>

                    </div>


                    {{-- JENIS BANTUAN --}}

                    <div class="distribution-show-item">

                        <dt>Jenis Bantuan</dt>

                        <dd>
                            <span class="distribution-show-type">
                                {{ $distribution->assistance_type ?: '-' }}
                            </span>
                        </dd>

                    </div>


                    {{-- SUMBER DONASI --}}

                    <div class="distribution-show-item">

                        <dt>Sumber Donasi</dt>

                        <dd class="distribution-show-donation">

                            @if ($distribution->donation)

                                <span class="distribution-show-donation__name">
                                    Donasi #{{ $distribution->donation->id }}
                                </span>

                                <span class="distribution-show-donation__amount">
                                    {{ $formatRupiah($distribution->donation->amount) }}
                                </span>

                            @else

                                <span class="distribution-show-muted">
                                    Tidak dipilih
                                </span>

                            @endif

                        </dd>

                    </div>

                </dl>

            </div>


            {{-- ==================================
                 NOTES
            =================================== --}}

            <div class="distribution-show-section distribution-show-section--notes">

                <div class="distribution-show-section__heading">

                    <div>

                        <span class="distribution-show-section__eyebrow">
                            KETERANGAN
                        </span>

                        <h3>Catatan Penyaluran</h3>

                    </div>

                </div>

                <div class="distribution-show-notes">

                    <p>
                        @if (filled($distribution->notes))
                            {{ $distribution->notes }}
                        @else
                            Tidak ada catatan tambahan untuk penyaluran bantuan ini.
                        @endif
                    </p>

                </div>

            </div>

        </div>


        {{-- ==================================
             CARD FOOTER
        =================================== --}}

        <div class="distribution-show-card__footer">

            <div class="distribution-show-footer-info">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>

                <p>
                    Pastikan informasi penyaluran sudah sesuai
                    dengan catatan bantuan yang tersimpan.
                </p>

            </div>

            <a
                href="{{ route('distributions.edit', $distribution) }}"
                class="distribution-button distribution-button--primary distribution-show-edit-button"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                </svg>

                Ubah Data Penyaluran
            </a>

        </div>

    </section>

</div>

@endsection
