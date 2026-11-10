
@extends('layouts.admin')

@section('title', 'Laporan Donasi dan Penyaluran - Admin Masjid Sabilillah')

@push('styles')
    @vite('resources/css/admin-reports.css')
@endpush

@section('content')

<div class="report-page">

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
                Pantau rekapitulasi donasi masuk dan penyaluran bantuan
                berdasarkan periode dan kategori.
            </p>
        </div>
    </section>

    @if ($errors->any())
        <div class="report-alert report-alert--danger">
            <div class="report-alert__content">
                <strong>Terjadi kesalahan pada filter laporan</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- FILTER LAPORAN --}}
    <section class="report-panel report-filter-panel">

        <div class="report-section-heading">
            <div class="report-section-heading__icon">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8">
                    <path d="M4 5h16M7 12h10M10 19h4"
                          stroke-linecap="round"/>
                </svg>
            </div>

            <div>
                <span class="report-eyebrow">PENGATURAN LAPORAN</span>
                <h2>Filter Laporan</h2>
                <p>Tentukan periode dan jenis laporan yang ingin ditampilkan.</p>
            </div>
        </div>

        <form action="{{ route('reports.index') }}"
              method="GET"
              class="report-filter-form">

            <div class="report-filter-grid">

                <div class="report-form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <div class="report-input-wrapper report-input-wrapper--date">
                        <input type="date"
                               id="start_date"
                               name="start_date"
                               value="{{ $startDate }}">
                    </div>
                </div>

                <div class="report-form-group">
                    <label for="end_date">Tanggal Akhir</label>
                    <div class="report-input-wrapper report-input-wrapper--date">
                        <input type="date"
                               id="end_date"
                               name="end_date"
                               value="{{ $endDate }}">
                    </div>
                </div>

                <div class="report-form-group">
                    <label for="report_type">Jenis Laporan</label>
                    <div class="report-input-wrapper">
                        <select name="report_type" id="report_type">
                            <option value="semua"
                                {{ $reportType === 'semua' ? 'selected' : '' }}>
                                Semua Laporan
                            </option>
                            <option value="donasi"
                                {{ $reportType === 'donasi' ? 'selected' : '' }}>
                                Donasi
                            </option>
                            <option value="penyaluran"
                                {{ $reportType === 'penyaluran' ? 'selected' : '' }}>
                                Penyaluran
                            </option>
                        </select>
                    </div>
                </div>

                <div class="report-form-group">
                    <label for="category">Kategori</label>
                    <div class="report-input-wrapper">
                        <select name="category" id="category">
                            <option value="">Semua Kategori</option>

                            @if ($reportType !== 'penyaluran')
                                <optgroup label="Kategori Donasi">
                                    @foreach ($donationCategories as $item)
                                        <option value="{{ $item }}"
                                            {{ $category === $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                            @if ($reportType !== 'donasi')
                                <optgroup label="Jenis Penyaluran">
                                    @foreach ($distributionCategories as $item)
                                        <option value="{{ $item }}"
                                            {{ $category === $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>
                </div>

            </div>

            <div class="report-filter-actions">
                <a href="{{ route('reports.index') }}"
                   class="report-button report-button--reset">
                    Reset Filter
                </a>

                <button type="submit"
                        class="report-button report-button--primary">
                    Terapkan Filter
                </button>
            </div>

        </form>
    </section>

    {{-- RINGKASAN --}}
    <section class="report-summary-section">

        <div class="report-main-heading">
            <div>
                <h2>Ringkasan Laporan</h2>
                <p>Rekapitulasi transaksi berdasarkan filter yang dipilih.</p>
            </div>
        </div>

        <div class="report-summary-grid">

            <article class="report-summary-card report-summary-card--green">
                <div class="report-summary-card__top">
                    <div class="report-summary-card__icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M12 3v18M17 7H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
                                  stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="report-summary-card__number">01</span>
                </div>
                <div class="report-summary-card__body">
                    <span>Total Donasi</span>
                    <h3>Rp {{ number_format((float) $totalDonation, 0, ',', '.') }}</h3>
                </div>
                <div class="report-summary-card__decoration"></div>
            </article>

            <article class="report-summary-card report-summary-card--blue">
                <div class="report-summary-card__top">
                    <div class="report-summary-card__icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M4 12h16M12 4l8 8-8 8"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="report-summary-card__number">02</span>
                </div>
                <div class="report-summary-card__body">
                    <span>Total Penyaluran</span>
                    <h3>Rp {{ number_format((float) $totalDistribution, 0, ',', '.') }}</h3>
                </div>
                <div class="report-summary-card__decoration"></div>
            </article>

            <article class="report-summary-card report-summary-card--gold">
                <div class="report-summary-card__top">
                    <div class="report-summary-card__icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6M23 11h-6"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="report-summary-card__number">03</span>
                </div>
                <div class="report-summary-card__body">
                    <span>Total Penerima Bantuan</span>
                    <h3>{{ number_format((int) $totalRecipients, 0, ',', '.') }}
                        <small>Orang</small>
                    </h3>
                </div>
                <div class="report-summary-card__decoration"></div>
            </article>

            <article class="report-summary-card report-summary-card--purple">
                <div class="report-summary-card__top">
                    <div class="report-summary-card__icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M4 7h16M4 12h16M4 17h16"
                                  stroke-linecap="round"/>
                            <circle cx="8" cy="7" r="1"/>
                            <circle cx="16" cy="17" r="1"/>
                        </svg>
                    </div>
                    <span class="report-summary-card__number">04</span>
                </div>
                <div class="report-summary-card__body">
                    <span>Saldo Donasi</span>
                    <h3>Rp {{ number_format((float) $balance, 0, ',', '.') }}</h3>
                </div>
                <div class="report-summary-card__decoration"></div>
            </article>

        </div>
    </section>

    {{-- TABEL DONASI --}}
    @if ($reportType !== 'penyaluran')
        <section class="report-panel report-table-panel">

            <div class="report-table-heading">
                <div class="report-table-heading__content">
                    <span class="report-eyebrow">DATA TRANSAKSI</span>
                    <h2>Rekapitulasi Donasi</h2>
                    <p>Daftar donasi yang telah diverifikasi.</p>
                </div>

                <div class="report-table-heading__icon report-table-heading__icon--green">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3v18M17 7H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
                              stroke-linecap="round"/>
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
                            <th>Metode Pembayaran</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($donations as $index => $donation)
                            <tr>
                                <td class="report-table__number">
                                    {{ $donations->firstItem() + $index }}
                                </td>
                                <td class="report-table__date">
                                    {{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="report-category">
                                        {{ $donation->category }}
                                    </span>
                                </td>
                                <td>{{ $donation->payment_method ?? '-' }}</td>
                                <td class="report-table__amount">
                                    Rp {{ number_format((float) $donation->amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="report-status report-status--success">
                                        <span></span>
                                        Terverifikasi
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="report-table__empty">
                                    <div class="report-empty">
                                        <strong>Belum ada data donasi</strong>
                                        <span>Tidak ditemukan transaksi donasi pada filter yang dipilih.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($donations->hasPages())
                <div class="report-pagination">
                    {{ $donations->links() }}
                </div>
            @endif

        </section>
    @endif

    {{-- TABEL PENYALURAN --}}
    @if ($reportType !== 'donasi')
        <section class="report-panel report-table-panel">

            <div class="report-table-heading">
                <div class="report-table-heading__content">
                    <span class="report-eyebrow">DATA PENYALURAN</span>
                    <h2>Rekapitulasi Penyaluran Bantuan</h2>
                    <p>Daftar bantuan yang telah disalurkan kepada penerima.</p>
                </div>

                <div class="report-table-heading__icon report-table-heading__icon--blue">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12h16M12 4l8 8-8 8"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
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
                            <th>Penerima</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($distributions as $index => $distribution)
                            <tr>
                                <td class="report-table__number">
                                    {{ $distributions->firstItem() + $index }}
                                </td>
                                <td class="report-table__date">
                                    {{ \Carbon\Carbon::parse($distribution->distribution_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="report-category report-category--blue">
                                        {{ $distribution->assistance_type }}
                                    </span>
                                </td>
                                <td>
                                    Penerima #{{ $distribution->beneficiary_id }}
                                </td>
                                <td class="report-table__amount">
                                    Rp {{ number_format((float) $distribution->amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="report-status report-status--success">
                                        <span></span>
                                        Disalurkan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="report-table__empty">
                                    <div class="report-empty">
                                        <strong>Belum ada data penyaluran</strong>
                                        <span>Tidak ditemukan transaksi penyaluran pada filter yang dipilih.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($distributions->hasPages())
                <div class="report-pagination">
                    {{ $distributions->links() }}
                </div>
            @endif

        </section>
    @endif

</div>

@endsection
