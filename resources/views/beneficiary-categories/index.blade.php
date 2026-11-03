
@extends('layouts.admin')

@section('title', 'Kategori Penerima Manfaat - Admin Masjid Sabilillah')

@push('styles')
    @vite('resources/css/beneficiary-categories.css')
@endpush

@section('content')

@php
    $activeCount = $categories->getCollection()
        ->where('is_active', true)
        ->count();

    $inactiveCount = $categories->getCollection()
        ->where('is_active', false)
        ->count();
@endphp

<div class="beneficiary-categories-page">

    {{-- PAGE HEADER --}}
    <section class="admin-page-header">

        <div class="admin-page-header__content">

            <div class="admin-page-header__eyebrow">
                <span class="admin-page-header__line"></span>
                Masjid Sabilillah
            </div>

            <h1 class="admin-page-header__title">
                Kategori Penerima Manfaat
            </h1>

            <p class="admin-page-header__description">
                Kelola pengelompokan penerima bantuan agar pendataan
                lebih terstruktur dan mudah dipantau.
            </p>

        </div>

        <div class="admin-page-header__action">

            <a
                href="{{ route('beneficiary-categories.create') }}"
                class="beneficiary-add-button"
            >
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M12 5v14M5 12h14"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

                Tambah Kategori
            </a>

        </div>

    </section>


    {{-- NOTIFICATIONS --}}

    @if (session('success'))
        <div class="beneficiary-alert beneficiary-alert--success" role="status">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path
                    d="m5 12 4 4L19 6"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="beneficiary-alert beneficiary-alert--error" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="beneficiary-alert beneficiary-alert--error" role="alert">
            <strong>Data belum dapat diproses. Periksa kembali:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- SUMMARY CARDS --}}

    <section
        class="beneficiary-summary"
        aria-label="Ringkasan kategori penerima manfaat"
    >

        {{-- TOTAL --}}
        <article class="summary-card summary-card--1">

            <div class="summary-card__top">

                <div class="summary-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path
                            d="M4 7h16M4 12h16M4 17h16"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                        />
                    </svg>
                </div>

                <span class="beneficiary-summary__index">01</span>

            </div>

            <div class="summary-card__body">

                <span class="summary-card__label">
                    Total Kategori
                </span>

                <h2>
                    {{ number_format($categories->total(), 0, ',', '.') }}
                </h2>

            </div>

            <div class="summary-card__bottom">
                <span class="summary-card__comparison">
                    Seluruh kategori terdaftar
                </span>
            </div>

            <div class="summary-card__decoration"></div>

        </article>


        {{-- ACTIVE --}}
        <article class="summary-card summary-card--2">

            <div class="summary-card__top">

                <div class="summary-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path
                            d="m5 12 4 4L19 6"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>

                <span class="beneficiary-summary__index">02</span>

            </div>

            <div class="summary-card__body">

                <span class="summary-card__label">
                    Kategori Aktif
                </span>

                <h2>
                    {{ number_format($activeCount, 0, ',', '.') }}
                </h2>

            </div>

            <div class="summary-card__bottom">
                <span class="summary-card__comparison">
                    Kategori aktif pada halaman ini
                </span>
            </div>

            <div class="summary-card__decoration"></div>

        </article>


        {{-- INACTIVE --}}
        <article class="summary-card summary-card--3">

            <div class="summary-card__top">

                <div class="summary-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle
                            cx="12"
                            cy="12"
                            r="8.5"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />
                        <path
                            d="m9 9 6 6m0-6-6 6"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                        />
                    </svg>
                </div>

                <span class="beneficiary-summary__index">03</span>

            </div>

            <div class="summary-card__body">

                <span class="summary-card__label">
                    Kategori Tidak Aktif
                </span>

                <h2>
                    {{ number_format($inactiveCount, 0, ',', '.') }}
                </h2>

            </div>

            <div class="summary-card__bottom">
                <span class="summary-card__comparison">
                    Kategori tidak aktif pada halaman ini
                </span>
            </div>

            <div class="summary-card__decoration"></div>

        </article>

    </section>


    {{-- CATEGORY TABLE --}}

    <section class="beneficiary-table-section">

        <article class="dashboard-panel beneficiary-table-panel">

            {{-- PANEL HEADING --}}

            <div class="panel-heading beneficiary-table-heading">

                <div>

                    <span class="panel-eyebrow">
                        DATA PENERIMA MANFAAT
                    </span>

                    <h3>
                        Daftar Kategori
                    </h3>

                    <p>
                        Kelola nama, deskripsi, jumlah penerima,
                        dan status kategori.
                    </p>

                </div>

                <span class="beneficiary-total">
                    {{ number_format($categories->total(), 0, ',', '.') }}
                    kategori
                </span>

            </div>


            {{-- TABLE WRAPPER --}}

            <div class="beneficiary-table-wrapper">

                <table class="dashboard-table beneficiary-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Penerima</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($categories as $category)

                            <tr>

                                {{-- NUMBER --}}
                                <td class="table-date">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>


                                {{-- NAME --}}
                                <td>
                                    <div class="table-person">

                                        <span class="table-avatar">
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path
                                                    d="M4 7h16M4 12h16M4 17h10"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </span>

                                        <span>
                                            {{ $category->name }}
                                        </span>

                                    </div>
                                </td>


                                {{-- DESCRIPTION --}}
                                <td>
                                    <span class="beneficiary-description">
                                        {{ $category->description ?: '-' }}
                                    </span>
                                </td>


                                {{-- BENEFICIARIES --}}
                                <td>
                                    <span class="table-amount">
                                        {{ number_format($category->beneficiaries_count, 0, ',', '.') }}
                                    </span>

                                    <span class="beneficiary-count-label">
                                        penerima
                                    </span>
                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if ($category->is_active)

                                        <span class="status-badge status-badge--success">
                                            <span class="beneficiary-status-dot"></span>
                                            Aktif
                                        </span>

                                    @else

                                        <span class="status-badge status-badge--danger">
                                            <span class="beneficiary-status-dot"></span>
                                            Tidak Aktif
                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td>

                                    <div class="beneficiary-actions">

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('beneficiary-categories.edit', $category) }}"
                                            class="beneficiary-action beneficiary-action--edit"
                                            title="Edit kategori"
                                            aria-label="Edit kategori {{ $category->name }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path
                                                    d="m14 5 5 5M4 20l4.5-1 10.8-10.8a2.1 2.1 0 0 0-3-3L5.5 16 4 20Z"
                                                    stroke="currentColor"
                                                    stroke-width="1.6"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />
                                            </svg>
                                            Edit
                                        </a>


                                        {{-- TOGGLE STATUS --}}
                                        <form
                                            action="{{ route('beneficiary-categories.toggle-status', $category) }}"
                                            method="POST"
                                            class="beneficiary-action-form"
                                            onsubmit="return confirm(@js(
                                                'Yakin ingin ' .
                                                ($category->is_active ? 'menonaktifkan' : 'mengaktifkan') .
                                                ' kategori ' . $category->name . '?'
                                            ))"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="beneficiary-action beneficiary-action--status"
                                            >

                                                @if ($category->is_active)

                                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <rect
                                                            x="3"
                                                            y="6"
                                                            width="18"
                                                            height="12"
                                                            rx="6"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                        />
                                                        <circle cx="15" cy="12" r="2.5" fill="currentColor"/>
                                                    </svg>

                                                    Nonaktifkan

                                                @else

                                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <rect
                                                            x="3"
                                                            y="6"
                                                            width="18"
                                                            height="12"
                                                            rx="6"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                        />
                                                        <circle cx="9" cy="12" r="2.5" fill="currentColor"/>
                                                    </svg>

                                                    Aktifkan

                                                @endif

                                            </button>
                                        </form>


                                        {{-- DELETE --}}
                                        <form
                                            action="{{ route('beneficiary-categories.destroy', $category) }}"
                                            method="POST"
                                            class="beneficiary-action-form"
                                            onsubmit="return confirm(@js(
                                                'Yakin ingin menghapus kategori ' .
                                                $category->name .
                                                '? Pastikan kategori ini tidak sedang digunakan oleh penerima manfaat.'
                                            ))"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="beneficiary-action beneficiary-action--delete"
                                            >
                                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path
                                                        d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"
                                                        stroke="currentColor"
                                                        stroke-width="1.6"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>

                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">

                                    <div class="dashboard-empty beneficiary-empty">

                                        <div class="dashboard-empty__icon">
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path
                                                    d="M4 7h16M4 12h16M4 17h10"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </div>

                                        <strong>
                                            Belum ada kategori penerima manfaat
                                        </strong>

                                        <span>
                                            Tambahkan kategori untuk mengelompokkan
                                            data penerima manfaat di dalam sistem.
                                        </span>

                                        <a
                                            href="{{ route('beneficiary-categories.create') }}"
                                            class="beneficiary-empty-link"
                                        >
                                            Tambah Kategori
                                        </a>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            @if ($categories->hasPages())

                <div class="beneficiary-pagination">

                    <div class="beneficiary-pagination__info">

                        Menampilkan
                        <strong>{{ $categories->firstItem() ?? 0 }}</strong>
                        sampai
                        <strong>{{ $categories->lastItem() ?? 0 }}</strong>
                        dari
                        <strong>{{ $categories->total() }}</strong>
                        kategori

                    </div>

                    <nav
                        class="beneficiary-pagination__navigation"
                        aria-label="Navigasi halaman kategori"
                    >

                        @if ($categories->onFirstPage())

                            <span class="beneficiary-pagination__button is-disabled">
                                ← Sebelumnya
                            </span>

                        @else

                            <a
                                href="{{ $categories->previousPageUrl() }}"
                                class="beneficiary-pagination__button"
                            >
                                ← Sebelumnya
                            </a>

                        @endif


                        @php
                            $startPage = max(
                                1,
                                $categories->currentPage() - 2
                            );

                            $endPage = min(
                                $categories->lastPage(),
                                $categories->currentPage() + 2
                            );
                        @endphp

                        @for ($page = $startPage; $page <= $endPage; $page++)

                            @if ($categories->currentPage() === $page)

                                <span
                                    class="beneficiary-pagination__number is-active"
                                    aria-current="page"
                                >
                                    {{ $page }}
                                </span>

                            @else

                                <a
                                    href="{{ $categories->url($page) }}"
                                    class="beneficiary-pagination__number"
                                >
                                    {{ $page }}
                                </a>

                            @endif

                        @endfor


                        @if ($categories->hasMorePages())

                            <a
                                href="{{ $categories->nextPageUrl() }}"
                                class="beneficiary-pagination__button"
                            >
                                Berikutnya →
                            </a>

                        @else

                            <span class="beneficiary-pagination__button is-disabled">
                                Berikutnya →
                            </span>

                        @endif

                    </nav>

                </div>

            @endif

        </article>

    </section>

</div>

@endsection
