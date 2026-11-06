
@extends('layouts.admin')

@section('title', 'Detail Penerima Manfaat - Admin Masjid Sabilillah')

@push('styles')
    @vite([
        'resources/css/admin-beneficiaries.css',
        'resources/css/admin-beneficiaries-show.css',
    ])
@endpush

@section('content')

@php
    $categoryName = $beneficiary->beneficiaryCategory?->name;

    $displayCategory = $categoryName ?? '-';

    if (
        strtolower($categoryName ?? '') === 'lainnya'
        && $beneficiary->other_category
    ) {
        $displayCategory = $beneficiary->other_category;
    }

    $isActive = $beneficiary->status === 'Aktif';

    $registeredDate = $beneficiary->registered_at
        ? $beneficiary->registered_at->format('d M Y')
        : '-';

    $updatedDate = $beneficiary->updated_at
        ? $beneficiary->updated_at->format('d-m-Y H:i')
        : '-';
@endphp

<div class="beneficiaries-page beneficiary-detail-page">

    {{-- ==========================================
         BREADCRUMB
    =========================================== --}}

    <nav class="beneficiary-show-breadcrumb" aria-label="Breadcrumb">

        <a href="{{ route('beneficiaries.index') }}">
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

            Data Penerima
        </a>

        <span class="beneficiary-show-breadcrumb__separator">/</span>

        <span>Detail Penerima</span>

    </nav>


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
                Detail Penerima Manfaat
            </h1>

            <p class="admin-page-header__description">
                Informasi lengkap penerima bantuan yang tercatat
                dalam sistem administrasi Masjid Sabilillah.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('beneficiaries.index') }}"
                class="beneficiary-show-button beneficiary-show-button--secondary"
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
                href="{{ route('beneficiaries.edit', $beneficiary) }}"
                class="beneficiary-show-button beneficiary-show-button--primary"
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

                Ubah Data
            </a>

        </div>

    </section>


    {{-- ==========================================
         SUCCESS NOTIFICATION
    =========================================== --}}

    @if (session('success'))

        <div class="beneficiary-show-alert" role="status">

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
         BENEFICIARY DETAIL CARD
    =========================================== --}}

    <section
        class="beneficiary-show-card"
        aria-labelledby="beneficiaryShowTitle"
    >

        {{-- CARD HEADER --}}

        <div class="beneficiary-show-card__header">

            <div class="beneficiary-show-card__identity">

                <div class="beneficiary-show-card__icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    </svg>

                </div>

                <div class="beneficiary-show-card__heading">

                    <span class="beneficiary-show-card__eyebrow">
                        INFORMASI PENERIMA
                    </span>

                    <h2 id="beneficiaryShowTitle">
                        {{ $beneficiary->name }}
                    </h2>

                    <p>
                        Data identitas dan informasi administrasi penerima.
                    </p>

                </div>

            </div>

            <div class="beneficiary-show-card__header-right">

                <span class="beneficiary-show-reference">
                    ID #{{ $beneficiary->id }}
                </span>

                @if ($isActive)

                    <span class="beneficiary-show-status beneficiary-show-status--active">
                        <span class="beneficiary-show-status__dot"></span>
                        Aktif
                    </span>

                @else

                    <span class="beneficiary-show-status beneficiary-show-status--inactive">
                        <span class="beneficiary-show-status__dot"></span>
                        Tidak Aktif
                    </span>

                @endif

            </div>

        </div>


        {{-- CARD BODY --}}

        <div class="beneficiary-show-card__body">


            {{-- ==================================
                 REGISTRATION SUMMARY
            =================================== --}}

            <div class="beneficiary-show-highlight">

                <div class="beneficiary-show-highlight__identity">

                    <span class="beneficiary-show-label">
                        Nama Penerima Manfaat
                    </span>

                    <strong>
                        {{ $beneficiary->name }}
                    </strong>

                    <span class="beneficiary-show-caption">
                        Identitas penerima bantuan Masjid Sabilillah.
                    </span>

                </div>

                <div class="beneficiary-show-highlight__divider"></div>

                <div class="beneficiary-show-highlight__registration">

                    <span class="beneficiary-show-label">
                        Tanggal Terdaftar
                    </span>

                    <strong>
                        {{ $registeredDate }}
                    </strong>

                    <span class="beneficiary-show-caption">
                        Tanggal pencatatan penerima dalam sistem.
                    </span>

                </div>

            </div>


            {{-- ==================================
                 PERSONAL INFORMATION
            =================================== --}}

            <div class="beneficiary-show-section">

                <div class="beneficiary-show-section__heading">

                    <div>

                        <span class="beneficiary-show-section__eyebrow">
                            INFORMASI UTAMA
                        </span>

                        <h3>Data Identitas Penerima</h3>

                    </div>

                </div>


                <dl class="beneficiary-show-grid">

                    {{-- NAMA --}}

                    <div class="beneficiary-show-item">

                        <dt>Nama Penerima</dt>

                        <dd>
                            {{ $beneficiary->name ?: '-' }}
                        </dd>

                    </div>


                    {{-- NIK --}}

                    <div class="beneficiary-show-item">

                        <dt>Nomor Induk Kependudukan (NIK)</dt>

                        <dd>
                            {{ $beneficiary->nik ?: '-' }}
                        </dd>

                    </div>


                    {{-- KONTAK --}}

                    <div class="beneficiary-show-item">

                        <dt>Nomor Kontak</dt>

                        <dd>
                            {{ $beneficiary->contact ?: '-' }}
                        </dd>

                    </div>


                    {{-- KATEGORI --}}

                    <div class="beneficiary-show-item">

                        <dt>Kategori Penerima</dt>

                        <dd>
                            {{ $displayCategory }}
                        </dd>

                    </div>


                    {{-- STATUS --}}

                    <div class="beneficiary-show-item">

                        <dt>Status Penerima</dt>

                        <dd>

                            @if ($isActive)

                                <span class="beneficiary-show-inline-status beneficiary-show-inline-status--active">
                                    Aktif
                                </span>

                            @else

                                <span class="beneficiary-show-inline-status beneficiary-show-inline-status--inactive">
                                    Tidak Aktif
                                </span>

                            @endif

                        </dd>

                    </div>


                    {{-- TANGGAL TERDAFTAR --}}

                    <div class="beneficiary-show-item">

                        <dt>Tanggal Terdaftar</dt>

                        <dd>
                            {{ $beneficiary->registered_at?->format('d-m-Y') ?? '-' }}
                        </dd>

                    </div>


                    {{-- ALAMAT --}}

                    <div class="beneficiary-show-item beneficiary-show-item--full">

                        <dt>Alamat Lengkap</dt>

                        <dd class="beneficiary-show-item__multiline">
                            {{ $beneficiary->address ?: '-' }}
                        </dd>

                    </div>


                    {{-- KONDISI --}}

                    <div class="beneficiary-show-item beneficiary-show-item--full">

                        <dt>Kondisi / Kriteria Penerima</dt>

                        <dd class="beneficiary-show-item__multiline">
                            {{ $beneficiary->condition ?: '-' }}
                        </dd>

                    </div>


                    {{-- CATATAN --}}

                    <div class="beneficiary-show-item beneficiary-show-item--full">

                        <dt>Catatan Tambahan</dt>

                        <dd class="beneficiary-show-item__multiline">
                            {{ $beneficiary->notes ?: 'Tidak ada catatan tambahan untuk penerima ini.' }}
                        </dd>

                    </div>

                </dl>

            </div>


            {{-- ==================================
                 REGISTRATION INFORMATION
            =================================== --}}

            <div class="beneficiary-show-section beneficiary-show-section--registration">

                <div class="beneficiary-show-section__heading">

                    <div>

                        <span class="beneficiary-show-section__eyebrow">
                            INFORMASI ADMINISTRASI
                        </span>

                        <h3>Riwayat Pencatatan</h3>

                    </div>

                </div>

                <div class="beneficiary-show-registration">

                    <div class="beneficiary-show-registration__item">

                        <span>Terdaftar Sejak</span>

                        <strong>
                            {{ $registeredDate }}
                        </strong>

                    </div>

                    <div class="beneficiary-show-registration__item">

                        <span>Terakhir Diperbarui</span>

                        <strong>
                            {{ $updatedDate }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- ==================================
                 DISTRIBUTION HISTORY
            =================================== --}}

            <div class="beneficiary-show-section beneficiary-show-section--distributions">

                <div class="beneficiary-show-section__heading">

                    <div>

                        <span class="beneficiary-show-section__eyebrow">
                            RIWAYAT BANTUAN
                        </span>

                        <h3>Riwayat Penyaluran</h3>

                        <p>
                            Daftar bantuan yang pernah diterima oleh
                            {{ $beneficiary->name }}.
                        </p>

                    </div>

                    <span class="beneficiary-show-reference">
                        {{ $beneficiary->distributions->count() }} Penyaluran
                    </span>

                </div>

                @if ($beneficiary->distributions->isNotEmpty())

                    <div class="beneficiary-show-history-table-wrapper">

                        <table class="beneficiary-show-history-table">

                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Bantuan</th>
                                    <th>Nominal / Nilai</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($beneficiary->distributions as $distribution)

                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $distribution->distribution_date?->format('d-m-Y') ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $distribution->assistance_type }}
                                        </td>

                                        <td>
                                            Rp{{ number_format((float) $distribution->amount, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            {{ $distribution->status }}
                                        </td>

                                        <td>
                                            {{ $distribution->notes ?: '-' }}
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="beneficiary-show-empty-history">

                        <div class="beneficiary-show-empty-history__icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <rect x="3" y="4" width="18" height="16" rx="2"/>
                                <path d="M8 9h8"/>
                                <path d="M8 13h5"/>
                            </svg>

                        </div>

                        <strong>Belum Ada Riwayat Penyaluran</strong>

                        <p>
                            Penerima manfaat ini belum memiliki riwayat
                            penyaluran bantuan yang tercatat dalam sistem.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- ==================================
             CARD FOOTER
        =================================== --}}

        <div class="beneficiary-show-card__footer">

            <div class="beneficiary-show-footer-info">

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
                    Pastikan data penerima sesuai dengan informasi
                    administrasi yang tersimpan.
                </p>

            </div>

            <a
                href="{{ route('beneficiaries.edit', $beneficiary) }}"
                class="beneficiary-show-button beneficiary-show-button--primary beneficiary-show-edit-button"
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

                Ubah Data Penerima
            </a>

        </div>

    </section>

</div>

@endsection
