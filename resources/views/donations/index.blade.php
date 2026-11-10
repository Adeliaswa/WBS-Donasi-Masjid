
@extends('layouts.admin')

@section('title', 'Data Donasi - Admin Masjid Sabilillah')
@push('scripts')
    @vite('resources/js/admin-donations.js')
@endpush

@push('styles')
    @vite('resources/css/admin-donations.css')
@endpush

@section('content')

<div class="donations-page">

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
                Data Donasi
            </h1>

            <p class="admin-page-header__description">
                Kelola, pantau, dan verifikasi seluruh transaksi donasi
                yang masuk ke Masjid Sabilillah.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('donations.create') }}"
                class="donations-button donations-button--primary donations-add-button"
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

                Tambah Donasi
            </a>

        </div>

    </section>


    {{-- ==========================================
         SUMMARY CARDS
    =========================================== --}}

    @include('components.admin.donations.summary-cards')


    {{-- ==========================================
         DONATION DATA SECTION
    =========================================== --}}

    <section class="donations-section">

        {{-- SECTION HEADING --}}

        <div class="donations-section__heading">

            <div>

                <span class="donations-section__eyebrow">
                </span>

                <h2>
                </h2>

                <p>
                </p>

            </div>

        </div>


        {{-- ======================================
             FILTER
        ======================================= --}}

        @include('components.admin.donations.filters')


        {{-- ======================================
             DONATION TABLE CARD
        ======================================= --}}

        <div class="donations-table-card">

            {{-- TABLE HEADING --}}

            <div class="donations-table-card__heading">

                <div>

                    <h3>
                        Seluruh Transaksi Donasi
                    </h3>

                    <p>
                        Menampilkan data donasi yang tercatat dalam sistem.
                    </p>

                </div>

                <span class="donations-table-card__count">
                    {{ $donations->total() }} Data
                </span>

            </div>


            {{-- TABLE CONTENT --}}

            @include('components.admin.donations.table')


            {{-- ==================================
                 PAGINATION
            =================================== --}}

            @include('components.admin.donations.pagination')

        </div>

    </section>

</div>

{{-- MODAL KONFIRMASI HAPUS DONASI --}}
<div
    id="deleteDonationModal"
    class="donations-delete-modal"
    aria-hidden="true"
>
    <div
        class="donations-delete-modal__backdrop"
        data-close-modal
    ></div>

    <div
        class="donations-delete-modal__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteDonationTitle"
    >
        <div class="donations-delete-modal__icon">
            !
        </div>

        <h2 id="deleteDonationTitle">
            Hapus Data Donasi?
        </h2>

        <p>
            Apakah kamu yakin ingin menghapus data donasi
            <strong id="deleteDonationName">ini</strong>?
            Data tidak akan ditampilkan lagi dalam daftar donasi.
        </p>

        <form
            id="deleteDonationForm"
            action="#"
            method="POST"
        >
            @csrf
            @method('DELETE')

            <div class="donations-delete-modal__actions">
                <button
                    type="button"
                    class="donations-delete-modal__cancel"
                    data-close-modal
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="donations-delete-modal__confirm"
                >
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
