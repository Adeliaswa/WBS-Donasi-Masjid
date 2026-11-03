
<footer class="public-footer" id="hubungi-kami">

    <div class="public-container">

        <div class="public-footer__main">

            {{-- BRAND / IDENTITAS MASJID --}}
            <div class="public-footer__brand">

                <a href="{{ route('public.home') }}"
                   class="public-brand">

                    <div class="public-brand__logo" aria-hidden="true">

                        <svg viewBox="0 0 48 48"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M24 5L27 14L36 10L32 19L42 22L32 25L36 34L27 30L24 40L21 30L12 34L16 25L6 22L16 19L12 10L21 14L24 5Z"
                                fill="currentColor"
                                opacity=".15"
                            />

                            <path
                                d="M12 37V24C12 17.373 17.373 12 24 12C30.627 12 36 17.373 36 24V37"
                                stroke="currentColor"
                                stroke-width="2.2"
                                stroke-linecap="round"
                            />

                            <path
                                d="M18 37V28C18 24.686 20.686 22 24 22C27.314 22 30 24.686 30 28V37"
                                stroke="currentColor"
                                stroke-width="2.2"
                                stroke-linecap="round"
                            />

                            <path
                                d="M7 37H41M24 5V9"
                                stroke="currentColor"
                                stroke-width="2.2"
                                stroke-linecap="round"
                            />

                        </svg>

                    </div>

                    <div class="public-brand__text">

                        <span class="public-brand__name">
                            Masjid Sabilillah
                        </span>

                        <span class="public-brand__description">
                            Transparansi Bantuan Sosial
                        </span>

                    </div>

                </a>

                <p class="public-footer__description">
                    Bersama menebar kebaikan melalui pengelolaan
                    donasi dan penyaluran bantuan sosial yang
                    transparan dan terpercaya.
                </p>

            </div>


            {{-- NAVIGASI --}}
            <div class="public-footer__navigation">

                <h3 class="public-footer__heading">
                    Navigasi
                </h3>

                <a href="{{ route('public.home') }}">
                    Beranda
                </a>

                <a href="{{ route('public.home') }}#tentang-program">
                    Tentang Program
                </a>

                <a href="{{ route('public.reports.index') }}">
                    Laporan Transparansi
                </a>

                <a href="{{ route('public.home') }}#kegiatan">
                    Berita Kegiatan
                </a>

            </div>


            {{-- INFORMASI KONTAK --}}
            <div class="public-footer__contact">

                <h3 class="public-footer__heading">
                    Hubungi Kami
                </h3>

                <div class="public-footer__contact-content">

                    <span class="public-footer__contact-name">
                        Masjid Sabilillah
                    </span>

                    <p>
                        Informasi donasi dan penyaluran bantuan sosial
                        dapat diperoleh melalui pengurus masjid.
                    </p>

                </div>

            </div>

        </div>


        {{-- FOOTER BOTTOM --}}
        <div class="public-footer__bottom">

            <p>
                © {{ date('Y') }} Masjid Sabilillah.
                Seluruh hak cipta dilindungi.
            </p>

            <span>
                Transparansi untuk Kepercayaan Bersama
            </span>

        </div>

    </div>

</footer>
