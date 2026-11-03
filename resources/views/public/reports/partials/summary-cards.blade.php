
<section class="public-report-summary">

    <div class="public-report-summary__heading">

        <div>
            <h2>Ringkasan Laporan</h2>

            <p>
                Periode
                {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
                -
                {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
            </p>
        </div>

        <span class="public-report-summary__period">
            <span></span>
            Periode Terpilih
        </span>

    </div>

    <div class="public-summary__grid">

        <article class="public-stat-card">

            <div class="public-stat-card__top">
                <div class="public-stat-card__icon public-stat-card__icon--green">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="4" y="3" width="16" height="18" rx="2"
                              stroke="currentColor" stroke-width="1.7"/>
                        <path d="M8 8H16M8 12H16"
                              stroke="currentColor" stroke-width="1.7"
                              stroke-linecap="round"/>
                    </svg>
                </div>

                <span class="public-stat-card__label">
                    Total Donasi Terkumpul
                </span>
            </div>

            <h3 class="public-stat-card__value">
                Rp {{ number_format($totalDonation, 0, ',', '.') }}
            </h3>

        </article>

        <article class="public-stat-card">

            <div class="public-stat-card__top">
                <div class="public-stat-card__icon public-stat-card__icon--blue">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 8L12 3L21 8V19H3V8Z"
                              stroke="currentColor" stroke-width="1.7"/>
                        <path d="M3 8H21"
                              stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </div>

                <span class="public-stat-card__label">
                    Total Bantuan Disalurkan
                </span>
            </div>

            <h3 class="public-stat-card__value">
                Rp {{ number_format($totalDistribution, 0, ',', '.') }}
            </h3>

        </article>

        <article class="public-stat-card">

            <div class="public-stat-card__top">
                <div class="public-stat-card__icon public-stat-card__icon--purple">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="9" cy="8" r="3"
                                stroke="currentColor" stroke-width="1.7"/>
                        <path d="M3 20C3 16.686 5.686 14 9 14C12.314 14 15 16.686 15 20"
                              stroke="currentColor" stroke-width="1.7"/>
                        <path d="M16 5.5C17.933 5.5 19.5 7.067 19.5 9C19.5 10.933 17.933 12.5 16 12.5"
                              stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </div>

                <span class="public-stat-card__label">
                    Jumlah Penerima
                </span>
            </div>

            <h3 class="public-stat-card__value">
                {{ number_format($totalRecipients, 0, ',', '.') }}
                <span>orang</span>
            </h3>

        </article>

        <article class="public-stat-card public-stat-card--highlight">

            <div class="public-stat-card__top">
                <div class="public-stat-card__icon public-stat-card__icon--white">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="3" y="6" width="18" height="14" rx="2"
                              stroke="currentColor" stroke-width="1.7"/>
                        <circle cx="12" cy="13" r="3"
                                stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </div>

                <span class="public-stat-card__label">
                    Saldo Donasi Tersedia
                </span>
            </div>

            <h3 class="public-stat-card__value">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </h3>

        </article>

    </div>

</section>
