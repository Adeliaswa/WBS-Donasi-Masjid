
<section class="public-category-section">

    <div class="public-container">

        <div class="public-category-card">

            <div class="public-category-card__header">

                <span class="public-eyebrow">
                    DISTRIBUSI BANTUAN
                </span>

                <h2 class="public-section-title">
                    Kategori Penyaluran Bantuan
                </h2>

                <p class="public-section-description">
                    Gambaran alokasi dana berdasarkan jenis bantuan
                    yang telah disalurkan.
                </p>

            </div>

            @if ($distributionCategoryChart->isNotEmpty())

                <div class="public-category-card__content">

                    <div class="public-category-card__chart">

                        <canvas
                            id="distributionCategoryChart"
                            aria-label="Grafik kategori penyaluran bantuan"
                            role="img"
                            data-chart="{{ json_encode($distributionCategoryChart) }}"
                        ></canvas>

                    </div>

                    <div class="public-category-card__legend">

                        @foreach ($distributionCategoryChart as $item)

                            <div class="public-category-legend-item">

                                <div class="public-category-legend-item__left">

                                    <span class="public-category-legend-item__dot"></span>

                                    <span class="public-category-legend-item__name">
                                        {{ $item['category'] }}
                                    </span>

                                </div>

                                <strong>
                                    Rp {{ number_format($item['total'], 0, ',', '.') }}
                                </strong>

                            </div>

                        @endforeach

                    </div>

                </div>

            @else

                <div class="public-empty-state">
                    <h3>Belum Ada Data Penyaluran</h3>

                    <p>
                        Informasi kategori bantuan akan muncul
                        setelah terdapat penyaluran.
                    </p>
                </div>

            @endif

        </div>

    </div>

</section>
