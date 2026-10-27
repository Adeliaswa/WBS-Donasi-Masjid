
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Kategori Penerima Manfaat | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/beneficiaries.css',
        'resources/css/beneficiary-categories.css',
        'resources/js/app.js',
        'resources/js/admin-sidebar.js',
    ])
</head>

<body class="admin-layout">

    {{-- Sidebar Admin --}}
    @include('components.admin.sidebar')

    {{-- Konten Utama --}}
    <div class="admin-main">
        <main class="beneficiary-categories-page">

            {{-- Header Halaman --}}
            <header class="beneficiary-categories-header">
                <div class="beneficiary-categories-header__content">
                    <span class="beneficiary-categories-header__eyebrow">
                        MASJID SABILILLAH
                    </span>

                    <h1 class="beneficiary-categories-header__title">
                        Kategori Penerima Manfaat
                    </h1>

                    <p class="beneficiary-categories-header__description">
                        Kelola pengelompokan penerima bantuan agar
                        pendataan lebih terstruktur dan mudah dipantau.
                    </p>
                </div>

                <a
                    href="{{ route('beneficiary-categories.create') }}"
                    class="beneficiary-categories-button beneficiary-categories-button--primary"
                >
                    <span aria-hidden="true">+</span>
                    Tambah Kategori
                </a>
            </header>

            {{-- Notifikasi Berhasil --}}
            @if (session('success'))
                <div
                    class="beneficiary-categories-alert beneficiary-categories-alert--success"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if (session('error'))
                <div
                    class="beneficiary-categories-alert beneficiary-categories-alert--error"
                    role="alert"
                >
                    {{ session('error') }}
                </div>
            @endif

            {{-- Notifikasi Validasi --}}
            @if ($errors->any())
                <div
                    class="beneficiary-categories-alert beneficiary-categories-alert--error"
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

            {{-- Ringkasan Kategori --}}
            <section
                class="beneficiary-categories-summary"
                aria-label="Ringkasan kategori penerima manfaat"
            >
                <article class="beneficiary-categories-summary__card">
                    <div class="beneficiary-categories-summary__label">
                        Total Kategori
                    </div>

                    <div class="beneficiary-categories-summary__value">
                        {{ number_format($categories->total(), 0, ',', '.') }}
                    </div>

                    <p class="beneficiary-categories-summary__note">
                        Kategori pada daftar ini
                    </p>
                </article>

                <article class="beneficiary-categories-summary__card">
                    <div class="beneficiary-categories-summary__label">
                        Kategori Aktif
                    </div>

                    <div class="beneficiary-categories-summary__value">
                        {{ number_format($categories->getCollection()->where('is_active', true)->count(), 0, ',', '.') }}
                    </div>

                    <p class="beneficiary-categories-summary__note">
                        Pada halaman ini
                    </p>
                </article>

                <article class="beneficiary-categories-summary__card">
                    <div class="beneficiary-categories-summary__label">
                        Kategori Tidak Aktif
                    </div>

                    <div class="beneficiary-categories-summary__value">
                        {{ number_format($categories->getCollection()->where('is_active', false)->count(), 0, ',', '.') }}
                    </div>

                    <p class="beneficiary-categories-summary__note">
                        Pada halaman ini
                    </p>
                </article>
            </section>

            {{-- Daftar Kategori --}}
            <section
                class="beneficiary-categories-section"
                aria-labelledby="beneficiary-categories-list-title"
            >
                <div class="beneficiary-categories-section__header">
                    <div>
                        <h2
                            id="beneficiary-categories-list-title"
                            class="beneficiary-categories-section__title"
                        >
                            Daftar Kategori
                        </h2>

                        <p class="beneficiary-categories-section__description">
                            Kelola nama, deskripsi, jumlah penerima,
                            dan status kategori.
                        </p>
                    </div>

                    <span class="beneficiary-categories-section__count">
                        {{ number_format($categories->total(), 0, ',', '.') }}
                        kategori
                    </span>
                </div>

                {{-- Tabel Kategori --}}
                <div class="beneficiary-categories-table-wrap">
                    <table class="beneficiary-categories-table">
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
                                    {{-- Nomor --}}
                                    <td class="beneficiary-categories-table__number">
                                        {{ $categories->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Nama --}}
                                    <td>
                                        <span class="beneficiary-categories-table__name">
                                            {{ $category->name }}
                                        </span>
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td>
                                        <span class="beneficiary-categories-table__description">
                                            {{ $category->description ?: '-' }}
                                        </span>
                                    </td>

                                    {{-- Jumlah Penerima --}}
                                    <td>
                                        <span class="beneficiary-categories-table__count">
                                            {{ number_format($category->beneficiaries_count, 0, ',', '.') }}
                                        </span>
                                        <span class="beneficiary-categories-table__count-label">
                                            penerima
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if ($category->is_active)
                                            <span class="beneficiary-categories-status beneficiary-categories-status--active">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="beneficiary-categories-status beneficiary-categories-status--inactive">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td>
                                        <div class="beneficiary-categories-actions">

                                            <a
                                                href="{{ route('beneficiary-categories.edit', $category) }}"
                                                class="beneficiary-categories-action beneficiary-categories-action--edit"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('beneficiary-categories.toggle-status', $category) }}"
                                                method="POST"
                                                class="beneficiary-categories-action-form"
                                                onsubmit="return confirm('Yakin ingin {{ $category->is_active ? 'menonaktifkan' : 'mengaktifkan' }} kategori {{ addslashes($category->name) }}?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="beneficiary-categories-action beneficiary-categories-action--status"
                                                >
                                                    {{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('beneficiary-categories.destroy', $category) }}"
                                                method="POST"
                                                class="beneficiary-categories-action-form"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori {{ addslashes($category->name) }}? Pastikan kategori ini tidak sedang digunakan oleh penerima manfaat.')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="beneficiary-categories-action beneficiary-categories-action--delete"
                                                >
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="beneficiary-categories-empty">
                                            <strong>
                                                Belum ada kategori penerima manfaat
                                            </strong>

                                            <p>
                                                Tambahkan kategori untuk
                                                mengelompokkan data penerima
                                                manfaat di dalam sistem.
                                            </p>

                                            <a
                                                href="{{ route('beneficiary-categories.create') }}"
                                                class="beneficiary-categories-button beneficiary-categories-button--primary"
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

                {{-- Pagination --}}
                @if ($categories->hasPages())
                    <div class="beneficiary-categories-pagination">
                        <div class="beneficiary-categories-pagination__info">
                            Menampilkan
                            <strong>{{ $categories->firstItem() ?? 0 }}</strong>
                            sampai
                            <strong>{{ $categories->lastItem() ?? 0 }}</strong>
                            dari
                            <strong>{{ $categories->total() }}</strong>
                            kategori
                        </div>

                        <nav
                            class="beneficiary-categories-pagination__navigation"
                            aria-label="Navigasi halaman kategori"
                        >
                            {{-- Sebelumnya --}}
                            @if ($categories->onFirstPage())
                                <span class="beneficiary-categories-pagination__button is-disabled">
                                    ← Sebelumnya
                                </span>
                            @else
                                <a
                                    href="{{ $categories->previousPageUrl() }}"
                                    class="beneficiary-categories-pagination__button"
                                >
                                    ← Sebelumnya
                                </a>
                            @endif

                            {{-- Nomor Halaman --}}
                            @php
                                $startPage = max(1, $categories->currentPage() - 2);
                                $endPage = min($categories->lastPage(), $categories->currentPage() + 2);
                            @endphp

                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <a
                                    href="{{ $categories->url($page) }}"
                                    class="beneficiary-categories-pagination__number {{ $categories->currentPage() === $page ? 'is-active' : '' }}"
                                    @if ($categories->currentPage() === $page)
                                        aria-current="page"
                                    @endif
                                >
                                    {{ $page }}
                                </a>
                            @endfor

                            {{-- Berikutnya --}}
                            @if ($categories->hasMorePages())
                                <a
                                    href="{{ $categories->nextPageUrl() }}"
                                    class="beneficiary-categories-pagination__button"
                                >
                                    Berikutnya →
                                </a>
                            @else
                                <span class="beneficiary-categories-pagination__button is-disabled">
                                    Berikutnya →
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif

            </section>

        </main>
    </div>

</body>
</html>
