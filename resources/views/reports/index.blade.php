
@extends('layouts.admin')

@section('title', 'Laporan Donasi dan Penyaluran - Admin Masjid Sabilillah')

@push('styles')
    @vite('resources/css/admin-reports.css')
@endpush

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Terjemahan Pesan Validasi Backend
    |--------------------------------------------------------------------------
    */

    $translatedErrors = collect($errors->all())->map(function ($error) {

        $message = strtolower($error);

        // Validasi tanggal akhir
        if (
            str_contains($message, 'end date') &&
            (
                str_contains($message, 'after') ||
                str_contains($message, 'before') ||
                str_contains($message, 'equal')
            )
        ) {
            return 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.';
        }

        // Validasi tanggal mulai
        if (
            str_contains($message, 'start date') &&
            str_contains($message, 'required')
        ) {
            return 'Tanggal mulai wajib diisi.';
        }

        // Validasi tanggal akhir wajib diisi
        if (
            str_contains($message, 'end date') &&
            str_contains($message, 'required')
        ) {
            return 'Tanggal akhir wajib diisi.';
        }

        // Validasi format tanggal
        if (
            str_contains($message, 'date') &&
            (
                str_contains($message, 'valid') ||
                str_contains($message, 'date format') ||
                str_contains($message, 'must be a date')
            )
        ) {
            return 'Format tanggal tidak valid. Silakan periksa kembali.';
        }

        // Validasi tanggal secara umum
        if (
            str_contains($message, 'start_date') ||
            str_contains($message, 'end_date')
        ) {
            return 'Tanggal yang dimasukkan tidak sesuai. Silakan periksa kembali.';
        }

        // Validasi kolom wajib
        if (str_contains($message, 'required')) {
            return 'Kolom yang wajib diisi belum dilengkapi.';
        }

        // Pesan lain yang tidak dikenali tetap ditampilkan
        return $error;

    })->unique();

@endphp


<div class="report-page">

    {{-- =====================================================
         1. PAGE HEADER
    ====================================================== --}}

    <section class="admin-page-header">

        <div class="admin-page-header__content">

            <div class="admin-page-header__eyebrow">
                <span class="admin-page-header__line"></span>
                Masjid Sabilillah
            </div>

            <h1 class="admin-page-header__title">
                Laporan Donasi dan Penyaluran
            </h1>

            <p class="admin-page-header__description">
                Ringkasan dan rekapitulasi aktivitas donasi serta
                penyaluran bantuan sosial Masjid Sabilillah.
            </p>

        </div>

    </section>


    {{-- =====================================================
         2. ERROR NOTIFICATION
    ====================================================== --}}

    @if ($translatedErrors->isNotEmpty())

        <div class="report-alert report-alert--danger">

            <div class="report-alert__icon">

                <svg viewBox="0 0 24 24" fill="none">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    <path
                        d="M12 8v5m0 3h.01"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />
                </svg>

            </div>

            <div class="report-alert__content">

                <strong>Terjadi Kesalahan</strong>

                <ul>
                    @foreach ($translatedErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    @endif


    {{-- =====================================================
         3. FILTER LAPORAN
    ====================================================== --}}

    <section class="report-panel report-filter-panel">

        <div class="report-section-heading">

            <div class="report-section-heading__icon">

                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M4 5h16l-6.5 7.5v5l-3 1.5v-6.5L4 5Z"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </div>

            <div>

                <span class="report-eyebrow">
                    PENGATURAN DATA
                </span>

                <h2>Filter Laporan</h2>

                <p>
                    Tentukan jenis laporan dan periode data yang ingin ditampilkan.
                </p>

            </div>

        </div>


        <form
            action="{{ route('reports.index') }}"
            method="GET"
            class="report-filter-form"
            id="reportFilterForm"
            novalidate
        >

            <div class="report-filter-grid">

                {{-- JENIS LAPORAN --}}

                <div class="report-form-group">

                    <label for="report_type">
                        Jenis Laporan
                    </label>

                    <div class="report-input-wrapper">

                        <select
                            name="report_type"
                            id="report_type"
                        >

                            <option
                                value="semua"
                                {{ $reportType === 'semua' ? 'selected' : '' }}
                            >
                                Semua Laporan
                            </option>

                            <option
                                value="donasi"
                                {{ $reportType === 'donasi' ? 'selected' : '' }}
                            >
                                Donasi
                            </option>

                            <option
                                value="penyaluran"
                                {{ $reportType === 'penyaluran' ? 'selected' : '' }}
                            >
                                Penyaluran
                            </option>

                        </select>

                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="m7 10 5 5 5-5"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                </div>


                {{-- KATEGORI --}}

                <div class="report-form-group">

                    <label for="category">
                        Kategori
                    </label>

                    <div class="report-input-wrapper">

                        <select
                            name="category"
                            id="category"
                        >

                            <option value="">
                                Semua Kategori
                            </option>

                            <optgroup label="Kategori Donasi">

                                @foreach ($donationCategories as $item)

                                    <option
                                        value="{{ $item }}"
                                        {{ $category === $item ? 'selected' : '' }}
                                    >
                                        {{ $item }}
                                    </option>

                                @endforeach

                            </optgroup>

                            <optgroup label="Jenis Bantuan">

                                @foreach ($distributionCategories as $item)

                                    <option
                                        value="{{ $item }}"
                                        {{ $category === $item ? 'selected' : '' }}
                                    >
                                        {{ $item }}
                                    </option>

                                @endforeach

                            </optgroup>

                        </select>

                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="m7 10 5 5 5-5"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                </div>


                {{-- TANGGAL MULAI --}}

                <div class="report-form-group">

                    <label for="start_date">
                        Tanggal Mulai
                    </label>

                    <div class="report-input-wrapper report-input-wrapper--date">

                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ $startDate }}"
                            required
                        >

                    </div>

                </div>


                {{-- TANGGAL AKHIR --}}

                <div class="report-form-group">

                    <label for="end_date">
                        Tanggal Akhir
                    </label>

                    <div class="report-input-wrapper report-input-wrapper--date">

                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ $endDate }}"
                            required
                        >

                    </div>

                </div>

            </div>


            {{-- DATE VALIDATION MESSAGE --}}

            <div
                class="report-date-error"
                id="reportDateError"
                role="alert"
                aria-live="polite"
                style="display: none;"
            >
                <span></span>
            </div>


            {{-- FILTER ACTION --}}

            <div class="report-filter-actions">

                <a
                    href="{{ route('reports.index') }}"
                    class="report-button report-button--reset"
                >

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M4 11a8 8 0 1 1 2.3 5.7M4 11V5m0 6h6"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Reset Filter

                </a>


                <button
                    type="submit"
                    class="report-button report-button--primary"
                >

                    Tampilkan Laporan

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M5 12h14m-6-6 6 6-6 6"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                </button>

            </div>

        </form>

    </section>


    {{-- =====================================================
         4. SUMMARY SECTION
    ====================================================== --}}

    <section class="report-summary-section">

        <div class="report-main-heading">

            <div>

                <span class="report-eyebrow">
                </span>


            </div>

        </div>


        <div class="report-summary-grid">

            {{-- TOTAL DONASI --}}

            <article class="report-summary-card report-summary-card--green">

                <div class="report-summary-card__top">

                    <div class="report-summary-card__icon">

                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 3v18m5-14H9.5a3 3 0 0 0 0 6h5a3 3 0 0 1 0 6H6"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                    <span class="report-summary-card__number">
                        01
                    </span>

                </div>

                <div class="report-summary-card__body">

                    <span>Total Donasi Masuk</span>

                    <h3>
                        Rp {{ number_format($totalDonation, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="report-summary-card__decoration"></div>

            </article>


            {{-- TOTAL PENYALURAN --}}

            <article class="report-summary-card report-summary-card--blue">

                <div class="report-summary-card__top">

                    <div class="report-summary-card__icon">

                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M3 12h18M13 4l8 8-8 8M3 5h5M3 19h5"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                    <span class="report-summary-card__number">
                        02
                    </span>

                </div>

                <div class="report-summary-card__body">

                    <span>Total Penyaluran</span>

                    <h3>
                        Rp {{ number_format($totalDistribution, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="report-summary-card__decoration"></div>

            </article>


            {{-- JUMLAH PENERIMA --}}

            <article class="report-summary-card report-summary-card--gold">

                <div class="report-summary-card__top">

                    <div class="report-summary-card__icon">

                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M16 20v-1.5a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4V20M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM17 4.2a4 4 0 0 1 0 7.6M21 20v-1.5a4 4 0 0 0-3-3.87"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                    <span class="report-summary-card__number">
                        03
                    </span>

                </div>

                <div class="report-summary-card__body">

                    <span>Jumlah Penerima</span>

                    <h3>
                        {{ number_format($totalRecipients, 0, ',', '.') }}
                        <small>Orang</small>
                    </h3>

                </div>

                <div class="report-summary-card__decoration"></div>

            </article>


            {{-- SALDO DONASI --}}

            <article class="report-summary-card report-summary-card--purple">

                <div class="report-summary-card__top">

                    <div class="report-summary-card__icon">

                        <svg viewBox="0 0 24 24" fill="none">

                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="1.7"
                            />

                            <path
                                d="M3 10h18m-5 4h2"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                            />

                        </svg>

                    </div>

                    <span class="report-summary-card__number">
                        04
                    </span>

                </div>

                <div class="report-summary-card__body">

                    <span>Saldo Donasi</span>

                    <h3>
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="report-summary-card__decoration"></div>

            </article>

        </div>

    </section>


    {{-- =====================================================
         5. DONATION RECAP
    ====================================================== --}}

    <section class="report-panel report-table-panel">

        <div class="report-table-heading">

            <div class="report-table-heading__content">

                <span class="report-eyebrow">
                    DATA DONASI
                </span>

                <h2>Rekap Donasi</h2>

                <p>
                    Daftar transaksi donasi yang tercatat berdasarkan filter laporan.
                </p>

            </div>

            <div class="report-table-heading__icon report-table-heading__icon--green">

                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 3v18m5-14H9.5a3 3 0 0 0 0 6h5a3 3 0 0 1 0 6H6"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </div>

        </div>


        <div class="report-table-wrapper">

            <table class="report-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Nominal</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($donations as $donation)

                        <tr>

                            <td class="report-table__number">
                                {{ $donations->firstItem() + $loop->index }}
                            </td>

                            <td class="report-table__date">
                                {{ $donation->donation_date->format('d-m-Y') }}
                            </td>

                            <td>
                                <span class="report-category">
                                    {{ $donation->category }}
                                </span>
                            </td>

                            <td class="report-table__amount">
                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $donation->payment_method }}
                            </td>

                            <td>

                                @if ($donation->verification_status === 'verified')

                                    <span class="report-status report-status--success">
                                        <span></span>
                                        Terverifikasi
                                    </span>

                                @elseif ($donation->verification_status === 'pending')

                                    <span class="report-status report-status--warning">
                                        <span></span>
                                        Menunggu
                                    </span>

                                @else

                                    <span class="report-status report-status--danger">
                                        <span></span>
                                        Ditolak
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="report-table__empty">

                                <div class="report-empty">

                                    <div class="report-empty__icon">

                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M7 3h8l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm8 0v5h5M9 13h6m-6 4h6"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>

                                    </div>

                                    <strong>Belum ada data donasi</strong>

                                    <span>
                                        Data donasi belum tersedia pada periode yang dipilih.
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- DONATION PAGINATION --}}

        @if ($donations->hasPages())

            <div class="report-pagination">
                {{ $donations->appends(request()->query())->links() }}
            </div>

        @endif

    </section>


    {{-- =====================================================
         6. DISTRIBUTION RECAP
    ====================================================== --}}

    <section class="report-panel report-table-panel report-table-panel--distribution">

        <div class="report-table-heading">

            <div class="report-table-heading__content">

                <span class="report-eyebrow">
                    DATA PENYALURAN
                </span>

                <h2>Rekap Penyaluran</h2>

                <p>
                    Daftar bantuan yang telah dicatat dalam sistem pengelolaan donasi.
                </p>

            </div>

            <div class="report-table-heading__icon report-table-heading__icon--blue">

                <svg viewBox="0 0 24 24" fill="none">

                    <path
                        d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linejoin="round"
                    />

                    <path
                        d="m4 7.5 8 4.5 8-4.5M12 12v9"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linejoin="round"
                    />

                </svg>

            </div>

        </div>


        <div class="report-table-wrapper">

            <table class="report-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jenis Bantuan</th>
                        <th>Jumlah Penerima</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($distributions as $distribution)

                        <tr>

                            <td class="report-table__number">
                                {{ $distributions->firstItem() + $loop->index }}
                            </td>

                            <td class="report-table__date">
                                {{ $distribution->distribution_date->format('d-m-Y') }}
                            </td>

                            <td>
                                <span class="report-category report-category--blue">
                                    {{ $distribution->assistance_type }}
                                </span>
                            </td>

                            <td>
                                <span class="report-recipient-count">
                                    1 Orang
                                </span>
                            </td>

                            <td class="report-table__amount">
                                Rp {{ number_format($distribution->amount, 0, ',', '.') }}
                            </td>

                            <td>

                                @if ($distribution->status === 'Disalurkan')

                                    <span class="report-status report-status--success">
                                        <span></span>
                                        Disalurkan
                                    </span>

                                @elseif ($distribution->status === 'Diproses')

                                    <span class="report-status report-status--warning">
                                        <span></span>
                                        Diproses
                                    </span>

                                @else

                                    <span class="report-status report-status--danger">
                                        <span></span>
                                        Dibatalkan
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="report-table__empty">

                                <div class="report-empty">

                                    <div class="report-empty__icon">

                                        <svg viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />

                                            <path
                                                d="m4 7.5 8 4.5 8-4.5M12 12v9"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />

                                        </svg>

                                    </div>

                                    <strong>Belum ada data penyaluran</strong>

                                    <span>
                                        Data penyaluran belum tersedia pada periode yang dipilih.
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- DISTRIBUTION PAGINATION --}}

        @if ($distributions->hasPages())

            <div class="report-pagination">
                {{ $distributions->appends(request()->query())->links() }}
            </div>

        @endif

    </section>

</div>

@endsection


{{-- =====================================================
     7. JAVASCRIPT DATE VALIDATION
     Validasi tanggal dari Frontend
====================================================== --}}

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('reportFilterForm');

    const startDate = document.getElementById('start_date');

    const endDate = document.getElementById('end_date');

    const errorContainer = document.getElementById('reportDateError');

    if (!form || !startDate || !endDate || !errorContainer) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Menampilkan Pesan Kesalahan
    |--------------------------------------------------------------------------
    */

    function showError(message) {

        errorContainer.querySelector('span').textContent = message;

        errorContainer.style.display = 'flex';

        startDate.setAttribute('aria-invalid', 'false');
        endDate.setAttribute('aria-invalid', 'true');

    }


    /*
    |--------------------------------------------------------------------------
    | Menghapus Pesan Kesalahan
    |--------------------------------------------------------------------------
    */

    function hideError() {

        errorContainer.style.display = 'none';

        errorContainer.querySelector('span').textContent = '';

        startDate.removeAttribute('aria-invalid');
        endDate.removeAttribute('aria-invalid');

    }


    /*
    |--------------------------------------------------------------------------
    | Validasi Tanggal
    |--------------------------------------------------------------------------
    */

    function validateDates() {

        const start = startDate.value;

        const end = endDate.value;


        // Tanggal mulai wajib diisi

        if (!start) {

            showError('Tanggal mulai wajib diisi.');

            return false;

        }


        // Tanggal akhir wajib diisi

        if (!end) {

            showError('Tanggal akhir wajib diisi.');

            return false;

        }


        // Tanggal akhir tidak boleh lebih awal dari tanggal mulai

        if (end < start) {

            showError(
                'Tanggal akhir tidak boleh lebih awal dari tanggal mulai.'
            );

            return false;

        }


        // Jika seluruh tanggal valid

        hideError();

        return true;

    }


    /*
    |--------------------------------------------------------------------------
    | Membatasi Tanggal Akhir
    |--------------------------------------------------------------------------
    */

    function updateEndDateMinimum() {

        if (startDate.value) {

            endDate.min = startDate.value;

        } else {

            endDate.removeAttribute('min');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Event Perubahan Tanggal Mulai
    |--------------------------------------------------------------------------
    */

    startDate.addEventListener('change', function () {

        updateEndDateMinimum();

        if (endDate.value) {
            validateDates();
        } else {
            hideError();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Event Perubahan Tanggal Akhir
    |--------------------------------------------------------------------------
    */

    endDate.addEventListener('change', function () {

        if (startDate.value && endDate.value) {

            validateDates();

        } else {

            hideError();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Menghapus Error Saat Input Diperbaiki
    |--------------------------------------------------------------------------
    */

    startDate.addEventListener('input', function () {

        updateEndDateMinimum();

        hideError();

    });


    endDate.addEventListener('input', function () {

        hideError();

    });


    /*
    |--------------------------------------------------------------------------
    | Validasi Sebelum Form Dikirim
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        if (!validateDates()) {

            event.preventDefault();

            errorContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            if (!startDate.value) {

                startDate.focus();

            } else {

                endDate.focus();

            }

        }

    });


    // Jalankan pembatasan tanggal saat halaman dibuka

    updateEndDateMinimum();


    // Periksa tanggal yang sudah terisi sebelumnya

    if (startDate.value && endDate.value) {
        validateDates();
    }

});
</script>

@endpush
