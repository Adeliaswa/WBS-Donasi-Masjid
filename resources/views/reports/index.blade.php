@extends('layouts.public')

@section('title', 'Laporan Transparansi')

@section('content')

    <div class="public-reports">

        <div class="public-container">

            @include('public.reports.partials.page-heading')

            @include('public.reports.partials.filter')

            @include('public.reports.partials.summary-cards')

            <section class="report-section">

                @include('public.reports.partials.report-tabs')

                <div class="report-content">

                    @switch($tab)

                        @case('donasi')
                            @include('public.reports.tables.donations')
                            @break

                        @case('penyaluran')
                            @include('public.reports.tables.distributions')
                            @break

                        @case('kategori')
                            @include('public.reports.tables.categories')
                            @break

                        @case('bulanan')
                            @include('public.reports.tables.monthly')
                            @break

                        @default
                            @include('public.reports.tables.donations')

                    @endswitch

                </div>

            </section>

            @include('public.reports.partials.notes')

        </div>

    </div>

@endsection