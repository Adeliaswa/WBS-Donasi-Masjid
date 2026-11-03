
<section class="public-summary">

    <div class="public-container">

        <div class="public-section-heading public-section-heading--row">

            <div>
                <span class="public-eyebrow">
                    RINGKASAN TRANSPARANSI
                </span>

                <h2 class="public-section-title">
                    Informasi Dana Masjid
                </h2>

                <p class="public-section-description">
                    Ringkasan donasi dan penyaluran bantuan sosial
                    Masjid Sabilillah.
                </p>
            </div>

            <a
                href="{{ route('public.reports.index') }}"
                class="public-text-link"
            >
                Lihat detail laporan
                <span>→</span>
            </a>

        </div>

        <div class="public-summary__grid">

            {{-- TOTAL DONASI --}}
            <article class="public-stat-card">

                <div class="public-stat-card__top">

                    <div class="public-stat-card__icon public-stat-card__icon--green">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="4" y="3" width="16" height="18" rx="2"
                                  stroke="currentColor" stroke-width="1.7"/>
                            <path d="M8 8H16M8 12H16M8 16H13"
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

                <span class="public-stat-card__note">
                    <span class="public-stat-card__status-dot"></span>
                    Hingga {{ now()->translatedFormat('d F Y') }}
                </span>

            </article>

            {{-- TOTAL PENYALURAN --}}
            <article class="public-stat-card">

                <div class="public-stat-card__top">

                    <div class="public-stat-card__icon public-stat-card__icon--blue">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M3 8L12 3L21 8V19H3V8Z"
                                  stroke="currentColor" stroke-width="1.7"
                                  stroke-linejoin="round"/>
                            <path d="M3 8H21M12 3V19"
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

                <span class="public-stat-card__note">
                    <span class="public-stat-card__status-dot"></span>
                    Hingga {{ now()->translatedFormat('d F Y') }}
                </span>

            </article>

            {{-- JUMLAH PENERIMA --}}
            <article class="public-stat-card">

                <div class="public-stat-card__top">

                    <div class="public-stat-card__icon public-stat-card__icon--purple">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="9" cy="8" r="3"
                                    stroke="currentColor" stroke-width="1.7"/>
                            <path d="M3 20C3 16.686 5.686 14 9 14C12.314 14 15 16.686 15 20"
                                  stroke="currentColor" stroke-width="1.7"
                                  stroke-linecap="round"/>
                            <path d="M16 5.5C17.933 5.5 19.5 7.067 19.5 9C19.5 10.933 17.933 12.5 16 12.5"
                                  stroke="currentColor" stroke-width="1.7"
                                  stroke-linecap="round"/>
                            <path d="M17 15C19.333 15.6 21 17.6 21 20"
                                  stroke="currentColor" stroke-width="1.7"
                                  stroke-linecap="round"/>
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

                <span class="public-stat-card__note">
                    <span class="public-stat-card__status-dot"></span>
                    Hingga {{ now()->translatedFormat('d F Y') }}
                </span>

            </article>

            {{-- SALDO --}}
            <article class="public-stat-card public-stat-card--highlight">

                <div class="public-stat-card__top">

                    <div class="public-stat-card__icon public-stat-card__icon--white">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M3 7H19C20.105 7 21 7.895 21 9V19H5C3.895 19 3 18.105 3 17V7Z"
                                  stroke="currentColor" stroke-width="1.7"/>
                            <path d="M3 7V5C3 3.895 3.895 3 5 3H18"
                                  stroke="currentColor" stroke-width="1.7"
                                  stroke-linecap="round"/>
                            <path d="M16 13H18"
                                  stroke="currentColor" stroke-width="1.7"
                                  stroke-linecap="round"/>
                        </svg>
                    </div>

                    <span class="public-stat-card__label">
                        Saldo Donasi Tersedia
                    </span>

                </div>

                <h3 class="public-stat-card__value">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </h3>

                <span class="public-stat-card__note">
                    <span class="public-stat-card__status-dot"></span>
                    Hingga {{ now()->translatedFormat('d F Y') }}
                </span>

            </article>

        </div>

    </div>

</section>
