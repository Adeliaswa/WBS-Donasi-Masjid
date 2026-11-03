
<header class="public-header">

    <div class="public-header__container">

        {{-- BRAND --}}
        <a href="{{ route('public.home') }}" class="public-brand">

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


        {{-- MOBILE TOGGLE --}}
        <button
            type="button"
            class="public-header__toggle"
            aria-label="Buka navigasi"
            aria-expanded="false"
            aria-controls="public-navigation"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>


        {{-- NAVIGATION --}}
        <nav class="public-navigation" id="public-navigation">

            <div class="public-navigation__links">

                {{-- BERANDA --}}
                <a
                    href="{{ route('public.home') }}"
                    class="public-navigation__link {{ request()->routeIs('public.home') && !request()->has('section') ? 'active' : '' }}"
                    data-nav-link
                >
                    Beranda
                </a>


                {{-- TENTANG PROGRAM --}}
                <a
                    href="{{ route('public.home') }}#tentang-program"
                    class="public-navigation__link"
                    data-nav-link
                >
                    Tentang Program
                </a>


                {{-- BERITA KEGIATAN --}}
                <a
                    href="{{ route('public.home') }}#kegiatan"
                    class="public-navigation__link"
                    data-nav-link
                >
                    Berita Kegiatan
                </a>


                {{-- LAPORAN --}}
                <a
                    href="{{ route('public.reports.index') }}"
                    class="public-navigation__link {{ request()->routeIs('public.reports.*') ? 'active' : '' }}"
                    data-nav-link
                >
                    Laporan
                </a>


                {{-- ANIMATED ACTIVE INDICATOR --}}
                <span
                    class="public-navigation__indicator"
                    aria-hidden="true"
                ></span>

            </div>


            {{-- CONTACT BUTTON --}}
            <a
                href="{{ route('public.home') }}#hubungi-kami"
                class="public-navigation__contact"
            >

                <span>Hubungi Kami</span>

                <svg viewBox="0 0 20 20"
                     fill="none"
                     aria-hidden="true">

                    <path
                        d="M4 10H16M10 4L16 10L10 16"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

            </a>

        </nav>

    </div>

</header>
