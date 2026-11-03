
@if ($donations->hasPages())

    <div class="donations-pagination">

        {{-- PAGINATION INFORMATION --}}
        <div class="donations-pagination__info">

            Menampilkan

            <strong>
                {{ $donations->firstItem() ?? 0 }}
            </strong>

            sampai

            <strong>
                {{ $donations->lastItem() ?? 0 }}
            </strong>

            dari

            <strong>
                {{ $donations->total() }}
            </strong>

            data donasi

        </div>


        {{-- PAGINATION NAVIGATION --}}
        <nav
            class="donations-pagination__navigation"
            aria-label="Navigasi halaman"
        >

            {{-- PREVIOUS --}}
            @if ($donations->onFirstPage())

                <span class="donations-pagination__button is-disabled">
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


            {{-- PAGE NUMBERS --}}
            @php
                $startPage = max(
                    1,
                    $donations->currentPage() - 2
                );

                $endPage = min(
                    $donations->lastPage(),
                    $donations->currentPage() + 2
                );
            @endphp

            @for ($page = $startPage; $page <= $endPage; $page++)

                @if ($donations->currentPage() === $page)

                    <span
                        class="donations-pagination__number is-active"
                        aria-current="page"
                    >
                        {{ $page }}
                    </span>

                @else

                    <a
                        href="{{ $donations->url($page) }}"
                        class="donations-pagination__number"
                    >
                        {{ $page }}
                    </a>

                @endif

            @endfor


            {{-- NEXT --}}
            @if ($donations->hasMorePages())

                <a
                    href="{{ $donations->nextPageUrl() }}"
                    class="donations-pagination__button"
                >
                    Berikutnya →
                </a>

            @else

                <span class="donations-pagination__button is-disabled">
                    Berikutnya →
                </span>

            @endif

        </nav>

    </div>

@endif
