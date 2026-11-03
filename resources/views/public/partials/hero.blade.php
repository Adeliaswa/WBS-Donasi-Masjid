
<section class="public-hero">

    <div class="public-container">

        <div class="public-hero__content">

            <div class="public-hero__text">

                <span class="public-eyebrow">
                    <span class="public-eyebrow__dot"></span>
                    MASJID SABILILLAH
                </span>

                <h1 class="public-hero__title">
                    Bersama,
                    <span>Menebar Manfaat</span>
                    untuk Umat
                </h1>

                <p class="public-hero__description">
                    Transparansi donasi dan penyaluran bantuan
                    sosial Masjid Sabilillah untuk masyarakat
                    yang lebih baik.
                </p>

                <div class="public-hero__actions">

                    <a
                        href="{{ route('public.reports.index') }}"
                        class="public-button public-button--primary"
                    >
                        Lihat Laporan

                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path
                                d="M4 10H16M10 4L16 10L10 16"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </a>

                    <a
                        href="#tentang-program"
                        class="public-button public-button--outline"
                    >
                        Tentang Program
                    </a>

                </div>

                <div class="public-hero__trust">

                    <span class="public-hero__trust-icon">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path
                                d="M12 3L19 6V11C19 15.5 16 19 12 21C8 19 5 15.5 5 11V6L12 3Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9 12L11 14L15 10"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>

                    <span>
                        Informasi terbuka dan dapat diakses publik
                    </span>

                </div>

            </div>

            <div class="public-hero__visual">

                <div class="public-hero__image-wrapper">

                    <img
                        src="{{ Vite::asset('resources/images/public/masjid-hero.webp') }}"
                        alt="Masjid Sabilillah"
                        class="public-hero__image"
                        fetchpriority="high"
                    >

                    <div class="public-hero__image-overlay"></div>

                    <div class="public-hero__image-caption">

                        <span class="public-hero__caption-label">
                            MASJID SABILILLAH
                        </span>

                        <span class="public-hero__caption-text">
                            Bersama membangun kepedulian umat
                        </span>

                    </div>

                </div>

                <div class="public-hero__decoration"></div>

            </div>

        </div>

    </div>

</section>
