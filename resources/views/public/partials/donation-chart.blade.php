
<section class="public-analytics">

    <div class="public-container">

        <div class="public-analytics__grid">

            <article class="public-panel public-panel--large">

                <div class="public-panel__header">

                    <div>
                        <span class="public-eyebrow">
                            STATISTIK TAHUNAN
                        </span>

                        <h2 class="public-panel__title">
                            Perkembangan Donasi dan Penyaluran
                        </h2>

                        <p class="public-panel__description">
                            Perbandingan dana donasi masuk dan bantuan
                            yang telah disalurkan setiap bulan.
                        </p>
                    </div>

                    <span class="public-panel__year">
                        {{ now()->year }}
                    </span>

                </div>

                <div class="public-chart-legend">

                    <span>
                        <i class="public-chart-legend__dot public-chart-legend__dot--green"></i>
                        Donasi Masuk
                    </span>

                    <span>
                        <i class="public-chart-legend__dot public-chart-legend__dot--blue"></i>
                        Penyaluran
                    </span>

                </div>

                @if (count($monthlyChart) > 0)

                    <div class="public-chart-wrapper">

                        <canvas
                            id="donationDistributionChart"
                            aria-label="Grafik perkembangan donasi dan penyaluran"
                            role="img"
                            data-chart="{{ json_encode($monthlyChart) }}"
                        ></canvas>

                    </div>

                @else

                    <div class="public-empty-state">
                        <div class="public-empty-state__icon">⌁</div>

                        <h3>Belum Ada Data Grafik</h3>

                        <p>
                            Data perkembangan donasi dan penyaluran
                            akan ditampilkan setelah tersedia.
                        </p>
                    </div>

                @endif

            </article>

        </div>

    </div>

</section>
