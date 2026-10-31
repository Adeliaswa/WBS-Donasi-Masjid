
@extends('layouts.admin')

@section('title', 'Dashboard - Admin Masjid Sabilillah')

@push('styles')
    @vite('resources/css/admin-dashboard.css')
@endpush

@section('content')

@php
    $formatRupiah = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };

    $formatCompact = function ($value) {
        if ($value >= 1000000000) {
            return 'Rp ' . number_format($value / 1000000000, 1, ',', '.') . ' M';
        }

        if ($value >= 1000000) {
            return 'Rp ' . number_format($value / 1000000, 1, ',', '.') . ' jt';
        }

        if ($value >= 1000) {
            return 'Rp ' . number_format($value / 1000, 0, ',', '.') . ' rb';
        }

        return $formatRupiah($value);
    };

    $monthOptions = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $monthOptionsShort = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'Mei',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Agu',
        9 => 'Sep',
        10 => 'Okt',
        11 => 'Nov',
        12 => 'Des',
    ];
@endphp

<div class="dashboard-page">

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
                Dashboard
            </h1>

            <p class="admin-page-header__description">
                Ringkasan aktivitas bantuan sosial Masjid Sabilillah.
            </p>

        </div>

        <div class="admin-page-header__action">
            <form
                action="{{ route('dashboard') }}"
                method="GET"
                class="dashboard-period"
            >
                <div class="dashboard-period__field">
                    <label for="month">Periode</label>

                    <select id="month" name="month">
                        @foreach ($monthOptions as $number => $name)
                            <option
                                value="{{ $number }}"
                                @selected($selectedMonth == $number)
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="dashboard-period__divider"></div>

                <div class="dashboard-period__field">
                    <label for="year">Tahun</label>

                    <select id="year" name="year">
                        @foreach ($availableYears as $year)
                            <option
                                value="{{ $year }}"
                                @selected($selectedYear == $year)
                            >
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button
                    type="submit"
                    class="dashboard-period__button"
                    aria-label="Terapkan periode"
                    title="Terapkan periode"
                >
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path
                            d="M5 12h14M13 6l6 6-6 6"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </button>
            </form>
        </div>

    </section>


    {{-- ==========================================
         SUMMARY CARDS
    =========================================== --}}

    <section class="dashboard-summary">

        @foreach ($summary as $index => $item)

            <article class="summary-card summary-card--{{ $index + 1 }}">

                <div class="summary-card__top">

                    <div class="summary-card__icon">
                        @if ($item['icon'] === 'hand-heart')
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M20.8 8.8c0 4.4-8.8 10-8.8 10s-8.8-5.6-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="M8 12h2l1.2-2 1.6 4 1.2-2H16"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        @elseif ($item['icon'] === 'users')
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M16 20v-1.5a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4V20M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM17 4.2a4 4 0 0 1 0 7.6M21 20v-1.5a4 4 0 0 0-3-3.87"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        @elseif ($item['icon'] === 'package-check')
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="m4.5 7.8 7.5 4.4 7.5-4.4M12 12.2V21M9 4.7l8 4.6"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M16 20v-1.5a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4V20M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM17 4.2a4 4 0 0 1 0 7.6M21 20v-1.5a4 4 0 0 0-3-3.87"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                />
                            </svg>
                        @endif
                    </div>

                    <button
                        type="button"
                        class="summary-card__more"
                        title="{{ $item['title'] }}"
                        aria-label="{{ $item['title'] }}"
                    >
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="5" cy="12" r="1" fill="currentColor"/>
                            <circle cx="12" cy="12" r="1" fill="currentColor"/>
                            <circle cx="19" cy="12" r="1" fill="currentColor"/>
                        </svg>
                    </button>

                </div>

                <div class="summary-card__body">

                    <span class="summary-card__label">
                        {{ $item['title'] }}
                    </span>

                    <h2>
                        @if ($item['type'] === 'currency')
                            {{ $formatRupiah($item['value']) }}
                        @else
                            {{ number_format($item['value'], 0, ',', '.') }}
                        @endif
                    </h2>

                </div>

                <div class="summary-card__bottom">

                    @if ($item['change'] === null)

                        <span class="summary-change summary-change--neutral">
                            <span>—</span>
                            Belum ada data bulan lalu
                        </span>

                    @else

                        <span class="summary-change
                            {{ $item['change'] > 0
                                ? 'summary-change--positive'
                                : ($item['change'] < 0
                                    ? 'summary-change--negative'
                                    : 'summary-change--neutral') }}"
                        >
                            @if ($item['change'] > 0)
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="m5 15 7-7 7 7"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            @elseif ($item['change'] < 0)
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="m5 9 7 7 7-7"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            @else
                                <span>—</span>
                            @endif

                            {{ abs($item['change']) }}%
                        </span>

                        <span class="summary-card__comparison">
                            dari bulan lalu
                        </span>

                    @endif

                </div>

                <div class="summary-card__decoration"></div>

            </article>

        @endforeach

    </section>


    {{-- ==========================================
         CHART SECTION
    =========================================== --}}

    <section class="dashboard-charts">

        {{-- DONATION CHART --}}

        <article class="dashboard-panel donation-panel">

            <div class="panel-heading">

                <div>
                    <span class="panel-eyebrow">STATISTIK DONASI</span>
                    <h3>Donasi Masuk</h3>
                    <p>Perkembangan donasi sepanjang tahun</p>
                </div>

                <form
                    action="{{ route('dashboard') }}"
                    method="GET"
                    class="chart-filter"
                >
                    <input type="hidden" name="month" value="{{ $selectedMonth }}">
                    <input type="hidden" name="year" value="{{ $selectedYear }}">

                    <select
                        name="chart_year"
                        aria-label="Pilih tahun grafik"
                        onchange="this.form.submit()"
                    >
                        @foreach ($availableYears as $year)
                            <option
                                value="{{ $year }}"
                                @selected($chartYear == $year)
                            >
                                Tahun {{ $year }}
                            </option>
                        @endforeach
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
                </form>

            </div>

            <div class="donation-chart-summary">
                <div>
                    <span>Total donasi tahun {{ $chartYear }}</span>
                    <strong>{{ $formatCompact($chartYearTotal) }}</strong>
                </div>

                <div class="chart-legend">
                    <span>
                        <i></i>
                        Donasi terverifikasi
                    </span>
                </div>
            </div>

            @if (collect($chartDonations)->sum('total') > 0)

                <div class="donation-chart-container">
                    <canvas
                        id="donationChart"
                        aria-label="Grafik donasi masuk per bulan"
                    ></canvas>
                </div>

            @else

                <div class="dashboard-empty dashboard-empty--chart">
                    <div class="dashboard-empty__icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M4 19V5m0 14h16M8 15l3-4 3 2 5-7"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                    <strong>Belum ada data donasi</strong>
                    <span>Data donasi untuk tahun {{ $chartYear }} belum tersedia.</span>
                </div>

            @endif

        </article>


        {{-- CATEGORY CHART --}}

        <article class="dashboard-panel category-panel">

            <div class="panel-heading">
                <div>
                    <span class="panel-eyebrow">KOMPOSISI DONASI</span>
                    <h3>Kategori Donasi</h3>
                    <p>{{ $selectedMonthName }} {{ $selectedYear }}</p>
                </div>
            </div>

            @if ($categoryTotal > 0)

                <div class="category-chart-wrapper">

                    <div class="category-donut-container">
                        <canvas
                            id="categoryChart"
                            aria-label="Grafik kategori donasi"
                        ></canvas>

                        <div class="category-donut-center">
                            <span>Total Donasi</span>
                            <strong>{{ $formatCompact($categoryTotal) }}</strong>
                        </div>
                    </div>

                </div>

                <div class="category-legend">

                    @foreach ($categoryChart as $category)

                        <div class="category-legend__item">

                            <span
                                class="category-legend__dot"
                                style="--category-color: {{ $category['color'] }}"
                            ></span>

                            <span class="category-legend__name">
                                {{ $category['name'] }}
                            </span>

                            <strong>
                                {{ number_format($category['percentage'], 1, ',', '.') }}%
                            </strong>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="dashboard-empty dashboard-empty--category">
                    <div class="dashboard-empty__icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 3v9h9A9 9 0 1 1 12 3Zm3 0a9 9 0 0 1 6 6h-6V3Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                    <strong>Belum ada kategori donasi</strong>
                    <span>Data kategori akan muncul setelah ada donasi terverifikasi.</span>
                </div>

            @endif

        </article>

    </section>


    {{-- ==========================================
         RECENT DATA SECTION
    =========================================== --}}

    <section class="dashboard-tables">

        {{-- LATEST DONATIONS --}}

        <article class="dashboard-panel table-panel">

            <div class="panel-heading table-panel__heading">

                <div>
                    <span class="panel-eyebrow">AKTIVITAS TERBARU</span>
                    <h3>Donasi Terbaru</h3>
                    <p>Daftar donasi yang menunggu proses verifikasi pengurus.</p>
                </div>

                <a
                    href="{{ route('donations.index') }}"
                    class="panel-link"
                >
                    Lihat Semua
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M5 12h14m-6-6 6 6-6 6"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>

            </div>

            @if ($latestDonations->isNotEmpty())

                <div class="dashboard-table-wrapper">

                    <table class="dashboard-table">

                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Donatur</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($latestDonations as $donation)

                                <tr>

                                    <td class="table-date">
                                        {{ $donation->donation_date->format('d M Y') }}
                                    </td>

                                    <td>
                                        <div class="table-person">
                                            <span class="table-avatar">
                                                {{ strtoupper(substr($donation->display_donor_name, 0, 1)) }}
                                            </span>

                                            <span>
                                                {{ $donation->display_donor_name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="table-category">
                                            {{ $donation->category }}
                                        </span>
                                    </td>

                                    <td class="table-amount">
                                        {{ $formatRupiah($donation->amount) }}
                                    </td>

                                    <td>
                                        @if ($donation->verification_status === 'verified')
                                            <span class="status-badge status-badge--success">
                                                Terverifikasi
                                            </span>
                                        @elseif ($donation->verification_status === 'pending')
                                            <span class="status-badge status-badge--warning">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="status-badge status-badge--danger">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="dashboard-empty dashboard-empty--table">
                    <div class="dashboard-empty__icon">
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
                    <span>Donasi yang dicatat akan muncul di sini.</span>
                </div>

            @endif

        </article>


        {{-- LATEST DISTRIBUTIONS --}}

        <article class="dashboard-panel table-panel">

            <div class="panel-heading table-panel__heading">

                <div>
                    <span class="panel-eyebrow">PENYALURAN BANTUAN</span>
                    <h3>Penyaluran Terbaru</h3>
                    <p>Daftar bantuan yang baru dicatat</p>
                </div>

                <a
                    href="{{ route('distributions.index') }}"
                    class="panel-link"
                >
                    Lihat Semua
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M5 12h14m-6-6 6 6-6 6"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>

            </div>

            @if ($latestDistributions->isNotEmpty())

                <div class="dashboard-table-wrapper">

                    <table class="dashboard-table">

                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Penerima</th>
                                <th>Jenis Bantuan</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($latestDistributions as $distribution)

                                <tr>

                                    <td class="table-date">
                                        {{ $distribution->distribution_date->format('d M Y') }}
                                    </td>

                                    <td>
                                        <div class="table-person">
                                            <span class="table-avatar table-avatar--recipient">
                                                {{ strtoupper(substr($distribution->beneficiary?->name ?? 'P', 0, 1)) }}
                                            </span>

                                            <span>
                                                {{ $distribution->beneficiary?->name ?? 'Penerima tidak tersedia' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="table-category">
                                            {{ $distribution->assistance_type }}
                                        </span>
                                    </td>

                                    <td class="table-amount">
                                        {{ $formatRupiah($distribution->amount) }}
                                    </td>

                                    <td>
                                        @if ($distribution->status === 'Disalurkan')
                                            <span class="status-badge status-badge--success">
                                                Disalurkan
                                            </span>
                                        @elseif ($distribution->status === 'Diproses')
                                            <span class="status-badge status-badge--warning">
                                                Diproses
                                            </span>
                                        @else
                                            <span class="status-badge status-badge--danger">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="dashboard-empty dashboard-empty--table">
                    <div class="dashboard-empty__icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Zm0 9 8-4.5M12 12 4 7.5M12 12v9"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                    <strong>Belum ada penyaluran</strong>
                    <span>Data penyaluran bantuan akan muncul di sini.</span>
                </div>

            @endif

        </article>

    </section>

</div>

{{-- DATA GRAFIK UNTUK JAVASCRIPT --}}

<script>
    window.dashboardChartData = {
        donations: @json($chartDonations),
        categories: @json($categoryChart)
    };
</script>

@endsection

@push('scripts')
    @vite('resources/js/admin-dashboard.js')
@endpush
