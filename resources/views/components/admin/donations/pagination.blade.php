@if ($donations->hasPages())
    <div class="donations-pagination">
        <div class="donations-pagination__info">
            Menampilkan
            <strong>{{ $donations->firstItem() ?? 0 }}</strong>
            sampai
            <strong>{{ $donations->lastItem() ?? 0 }}</strong>
            dari
            <strong>{{ $donations->total() }}</strong>
            data donasi
        </div>

        <nav class="donations-pagination__navigation" aria-label="Navigasi halaman">
            {{-- Tombol sebelumnya --}}
            @if ($donations->onFirstPage())
                <span class="donations-pagination__button is-disabled" aria-disabled="true">
                    ← Sebelumnya
                </span>
            @else
                <a
                    href="{{ $donations->previousPageUrl() }}"
                    class="donations-pagination__button"
                >
                    ← Sebelumnya
                </a>
            @endif

            {{-- Nomor halaman --}}
            @php
                $startPage = max(1, $donations->currentPage() - 2);
                $endPage = min($donations->lastPage(), $donations->currentPage() + 2);
            @endphp

            @for ($page = $startPage; $page <= $endPage; $page++)
                <a
                    href="{{ $donations->url($page) }}"
                    class="donations-pagination__number {{ $donations->currentPage() === $page ? 'is-active' : '' }}"
                    @if ($donations->currentPage() === $page)
                        aria-current="page"
                    @endif
                >
                    {{ $page }}
                </a>
            @endfor

            {{-- Tombol berikutnya --}}
            @if ($donations->hasMorePages())
                <a
                    href="{{ $donations->nextPageUrl() }}"
                    class="donations-pagination__button"
                >
                    Berikutnya →
                </a>
            @else
                <span class="donations-pagination__button is-disabled" aria-disabled="true">
                    Berikutnya →
                </span>
            @endif
        </nav>
    </div>
@endif