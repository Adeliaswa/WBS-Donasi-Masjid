
@extends('layouts.admin')

@section('title', 'Data Penerima Manfaat - Admin Masjid Sabilillah')

@push('styles')
    @vite('resources/css/admin-beneficiaries.css')
@endpush

@push('scripts')
    @vite('resources/js/beneficiary-categories.js')
@endpush

@section('content')

<div class="beneficiaries-page">

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
                Data Penerima Manfaat
            </h1>

            <p class="admin-page-header__description">
                Kelola dan pantau data penerima bantuan masjid
                dengan tertib dan terstruktur.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('beneficiaries.create') }}"
                class="beneficiaries-button beneficiaries-button--primary beneficiaries-add-button"
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
                    <path d="M12 5v14M5 12h14"/>
                </svg>

                Tambah Penerima
            </a>

        </div>

    </section>


    {{-- ==========================================
         NOTIFICATIONS
    =========================================== --}}

    @if (session('success'))

        <div
            class="beneficiaries-alert beneficiaries-alert--success"
            role="status"
        >
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div
            class="beneficiaries-alert beneficiaries-alert--error"
            role="alert"
        >
            {{ session('error') }}
        </div>

    @endif


    @if ($errors->any())

        <div
            class="beneficiaries-alert beneficiaries-alert--error"
            role="alert"
        >

            <strong>
                Data belum dapat diproses. Periksa kembali:
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- ==========================================
         SUMMARY CARDS
    =========================================== --}}

    @include('components.admin.beneficiaries.summary-cards')


    {{-- ==========================================
         BENEFICIARIES DATA SECTION
    =========================================== --}}

    <section class="beneficiaries-section">

        {{-- SECTION HEADING --}}

        <div class="beneficiaries-section__heading">

            <div>

                <span class="beneficiaries-section__eyebrow">
                </span>

                <h2 class="beneficiaries-section__title">
                </h2>

                <p class="beneficiaries-section__description">
                </p>

            </div>

        </div>


        {{-- ======================================
             FILTERS
        ======================================= --}}

        @include('components.admin.beneficiaries.filters')


        {{-- ======================================
             BENEFICIARIES TABLE CARD
        ======================================= --}}

        <div class="beneficiaries-table-card">

            {{-- TABLE HEADING --}}

            <div class="beneficiaries-table-card__heading">

                <div>

                    <h3>
                        Seluruh Data Penerima Manfaat
                    </h3>

                    <p>
                        Menampilkan data penerima manfaat
                        yang tercatat dalam sistem.
                    </p>

                </div>

                <span class="beneficiaries-table-card__count">
                    {{ number_format($beneficiaries->total(), 0, ',', '.') }}
                    Data
                </span>

            </div>


            {{-- TABLE CONTENT --}}

            @include('components.admin.beneficiaries.table')


            {{-- ==================================
                 PAGINATION
            =================================== --}}

            @include('components.admin.beneficiaries.pagination')

        </div>

    </section>

</div>

@endsection
