@extends('layouts.admin')

@section('title', 'Data Kegiatan - Admin Masjid Sabilillah')

@push('styles')
    @vite('resources/css/admin-activities.css')
@endpush

@section('content')

<div class="activities-page">

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
                Data Kegiatan
            </h1>

            <p class="admin-page-header__description">
                Kelola seluruh kegiatan Masjid Sabilillah, mulai dari
                menambah, memperbarui, hingga mengatur status publikasinya.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('activities.create') }}"
                class="activities-button activities-button--primary activities-add-button"
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

                Tambah Kegiatan
            </a>

        </div>

    </section>


    {{-- ==========================================
         FLASH MESSAGE
    =========================================== --}}

    @if (session('success'))
        <div class="activities-alert activities-alert--success" role="status">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="12" cy="12" r="9"/>
                <path d="m8.5 12.5 2.5 2.5 4.5-5"/>
            </svg>

            <span>{{ session('success') }}</span>

        </div>
    @endif


    {{-- ==========================================
         ACTIVITY DATA SECTION
    =========================================== --}}

    <section class="activities-section">

        <div class="activities-table-card">

            {{-- TABLE HEADING --}}

            <div class="activities-table-card__heading">

                <div>

                    <h3>
                        Seluruh Kegiatan
                    </h3>

                    <p>
                        Menampilkan kegiatan yang tercatat dalam sistem.
                    </p>

                </div>

                <span class="activities-table-card__count">
                    {{ $activities->total() }} Data
                </span>

            </div>


            {{-- TABLE --}}

            <div class="activities-table-wrapper">

                <table class="activities-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Status Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($activities as $activity)

                            <tr>

                                <td class="activities-table__number">
                                    {{ $activities->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="activities-table__title">

                                        <span class="activities-table__avatar" aria-hidden="true">
                                            {{ strtoupper(mb_substr($activity->title, 0, 1)) }}
                                        </span>

                                        <span class="activities-table__title-text">
                                            {{ $activity->title }}
                                        </span>

                                    </div>
                                </td>

                                <td>
                                    <span class="activities-table__description">
                                        {{ $activity->description }}
                                    </span>
                                </td>

                                <td>
                                    {{ $activity->activity_date->format('d-m-Y') }}
                                </td>

                                <td>
                                    @if ($activity->is_published)
                                        <span class="activities-status activities-status--published">
                                            <span class="activities-status__dot"></span>
                                            Dipublikasikan
                                        </span>
                                    @else
                                        <span class="activities-status activities-status--draft">
                                            <span class="activities-status__dot"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="activities-table__actions">

                                        <a
                                            href="{{ route('activities.show', $activity->id) }}"
                                            class="activities-table__action activities-table__action--detail"
                                        >
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('activities.edit', $activity->id) }}"
                                            class="activities-table__action activities-table__action--edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('activities.destroy', $activity->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="activities-table__action activities-table__action--delete"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="activities-table__empty">

                                    <div class="activities-table__empty-icon" aria-hidden="true">
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                            <path d="M3.5 10H20.5M8 3V6.5M16 3V6.5"/>
                                        </svg>
                                    </div>

                                    <h3>Belum ada kegiatan</h3>

                                    <p>
                                        Kegiatan yang kamu tambahkan akan tampil di sini.
                                    </p>

                                    <a
                                        href="{{ route('activities.create') }}"
                                        class="activities-button activities-button--primary"
                                    >
                                        Tambah Kegiatan
                                    </a>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ==================================
                 PAGINATION
            =================================== --}}

            @if ($activities->total() > 0)

                @php
                    $currentPage = $activities->currentPage();
                    $lastPage    = $activities->lastPage();
                    $startPage   = max(1, $currentPage - 2);
                    $endPage     = min($lastPage, $currentPage + 2);
                @endphp

                <div class="activities-pagination">

                    <div class="activities-pagination__info">
                        Menampilkan
                        <strong>{{ $activities->firstItem() }}</strong>
                        sampai
                        <strong>{{ $activities->lastItem() }}</strong>
                        dari
                        <strong>{{ $activities->total() }}</strong>
                        kegiatan
                    </div>

                    @if ($activities->hasPages())
                        <nav class="activities-pagination__navigation" aria-label="Navigasi halaman">

                            @if ($activities->onFirstPage())
                                <span class="activities-pagination__button is-disabled">
                                    Sebelumnya
                                </span>
                            @else
                                <a
                                    href="{{ $activities->previousPageUrl() }}"
                                    class="activities-pagination__button"
                                    rel="prev"
                                >
                                    Sebelumnya
                                </a>
                            @endif

                            @foreach (range($startPage, $endPage) as $page)
                                <a
                                    href="{{ $activities->url($page) }}"
                                    class="activities-pagination__number {{ $page === $currentPage ? 'is-active' : '' }}"
                                    @if ($page === $currentPage) aria-current="page" @endif
                                >
                                    {{ $page }}
                                </a>
                            @endforeach

                            @if ($activities->hasMorePages())
                                <a
                                    href="{{ $activities->nextPageUrl() }}"
                                    class="activities-pagination__button"
                                    rel="next"
                                >
                                    Berikutnya
                                </a>
                            @else
                                <span class="activities-pagination__button is-disabled">
                                    Berikutnya
                                </span>
                            @endif

                        </nav>
                    @endif

                </div>

            @endif

        </div>

    </section>

</div>

@endsection