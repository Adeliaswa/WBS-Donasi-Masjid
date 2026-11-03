
@extends('layouts.public')

@section('title', 'Laporan Transparansi - Masjid Sabilillah')

@section('content')

<section class="public-report-page">

    <div class="public-container">

        {{-- PAGE HEADER --}}
        @include('public.reports.partials.report-header')

        {{-- FILTER --}}
        @include('public.reports.partials.report-filter')

        {{-- SUMMARY CARDS --}}
        @include('public.reports.partials.summary-cards')

        {{-- REPORT TABS --}}
        @include('public.reports.partials.report-tabs')

        {{-- REPORT CONTENT --}}
        <div class="public-report-content">

            @if ($tab === 'donasi')

                @include('public.reports.partials.donation-table')

            @elseif ($tab === 'penyaluran')

                @include('public.reports.partials.distribution-table')

            @elseif ($tab === 'kategori')

                @include('public.reports.partials.category-table')

            @elseif ($tab === 'bulanan')

                @include('public.reports.partials.monthly-table')

            @endif

        </div>

        {{-- NOTES --}}
        @include('public.reports.partials.report-notes')

    </div>

</section>

@endsection
