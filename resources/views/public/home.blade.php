
@extends('layouts.public')

@section('title', 'Beranda - Transparansi Masjid Sabilillah')

@section('content')

    {{-- HERO SECTION --}}
    @include('public.partials.hero')

    {{-- SUMMARY CARDS --}}
    @include('public.partials.summary-cards', [
        'totalDonation' => $totalDonation,
        'totalDistribution' => $totalDistribution,
        'totalRecipients' => $totalRecipients,
        'balance' => $balance
    ])

    {{-- DONATION CHART --}}
    @include('public.partials.donation-chart', [
        'monthlyChart' => $monthlyChart
    ])

    {{-- DISTRIBUTION CATEGORY CHART --}}
    @include('public.partials.distribution-chart', [
        'distributionCategoryChart' => $distributionCategoryChart
    ])

    {{-- PROGRAMS --}}
    @include('public.partials.programs')

    {{-- LATEST ACTIVITIES --}}
    @include('public.partials.activities', [
        'latestActivities' => $latestActivities
    ])

    {{-- DONATION BANNER --}}
    @include('public.partials.donation-banner')

    {{-- ==========================================
         DATA GRAFIK UNTUK JAVASCRIPT
    =========================================== --}}

    {{-- DATA GRAFIK DONASI DAN PENYALURAN --}}
    <script id="monthlyChartData" type="application/json">
        @json($monthlyChart)
    </script>

    {{-- DATA GRAFIK KATEGORI PENYALURAN --}}
    <script id="distributionCategoryData" type="application/json">
        @json($distributionCategoryChart)
    </script>

@endsection


