{{-- Pagination Data Penerima Manfaat --}}
<div class="beneficiaries-pagination">

    {{-- Informasi jumlah data --}}
    <div class="beneficiaries-pagination__info">
        @if ($beneficiaries->total() > 0)
            Menampilkan
            <strong>{{ $beneficiaries->firstItem() ?? 0 }}</strong>
            sampai
            <strong>{{ $beneficiaries->lastItem() ?? 0 }}</strong>
            dari
            <strong>{{ $beneficiaries->total() }}</strong>
            data penerima
        @else
            Belum ada data penerima
        @endif
    </div>

    {{-- Navigasi halaman --}}
    @if ($beneficiaries->total() > 0)
        <nav
            class="beneficiaries-pagination__navigation"
            aria-label="Navigasi halaman penerima manfaat"
        >
            {{-- Tombol sebelumnya --}}
            @if ($beneficiaries->onFirstPage())
                <span
                    class="beneficiaries-pagination__button is-disabled"
                    aria-disabled="true"
                >
                    &larr; Sebelumnya
                </span>
            @else
                <a
                    href="{{ $beneficiaries->previousPageUrl() }}"
                    class="beneficiaries-pagination__button"
                    rel="prev"
                >
                    &larr; Sebelumnya
                </a>
            @endif

            {{-- Nomor halaman --}}
            @php
                $startPage = max(
                    1,
                    $beneficiaries->currentPage() - 2
                );

                $endPage = min(
                    $beneficiaries->lastPage(),
                    $beneficiaries->currentPage() + 2
                );
            @endphp

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($beneficiaries->currentPage() === $page)
                    <span
                        class="beneficiaries-pagination__number is-active"
                        aria-current="page"
                    >
                        {{ $page }}
                    </span>
                @else
                    <a
                        href="{{ $beneficiaries->url($page) }}"
                        class="beneficiaries-pagination__number"
                        aria-label="Halaman {{ $page }}"
                    >
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Tombol berikutnya --}}
            @if ($beneficiaries->hasMorePages())
                <a
                    href="{{ $beneficiaries->nextPageUrl() }}"
                    class="beneficiaries-pagination__button"
                    rel="next"
                >
                    Berikutnya &rarr;
                </a>
            @else
                <span
                    class="beneficiaries-pagination__button is-disabled"
                    aria-disabled="true"
                >
                    Berikutnya &rarr;
                </span>
            @endif
        </nav>
    @endif

</div>