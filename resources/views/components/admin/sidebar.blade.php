<aside class="admin-sidebar" id="adminSidebar">

    {{-- Brand --}}
    <div class="admin-sidebar__brand">

        <a
            href="{{ route('donations.index') }}"
            class="admin-sidebar__brand-link"
            aria-label="Masjid Sabilillah"
        >
            <div class="admin-sidebar__logo" aria-hidden="true">
                <svg viewBox="0 0 48 48" fill="none">
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

            <div class="admin-sidebar__brand-info">
                <span class="admin-sidebar__brand-name">
                    Sabilillah
                </span>

                <span class="admin-sidebar__brand-caption">
                    ADMIN PANEL
                </span>
            </div>
        </a>

        <button
            type="button"
            class="admin-sidebar__close"
            id="closeSidebar"
            aria-label="Tutup menu"
        >
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path
                    d="M18 6L6 18M6 6L18 18"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>
        </button>

    </div>


    {{-- Navigasi --}}
    <nav class="admin-sidebar__navigation" aria-label="Navigasi admin">

        <div class="admin-sidebar__section">

            <span class="admin-sidebar__section-label">
                MENU UTAMA
            </span>

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="admin-sidebar__link"
                data-menu-name="dashboard"
            >
                <span class="admin-sidebar__link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect
                            x="3"
                            y="3"
                            width="7"
                            height="7"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <rect
                            x="14"
                            y="3"
                            width="7"
                            height="7"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <rect
                            x="3"
                            y="14"
                            width="7"
                            height="7"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <rect
                            x="14"
                            y="14"
                            width="7"
                            height="7"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />
                    </svg>
                </span>

                <span class="admin-sidebar__link-text">
                    Dashboard
                </span>
            </a>


            {{-- Data Donasi --}}
            <a
                href="{{ route('donations.index') }}"
                class="admin-sidebar__link {{ request()->routeIs('donations.*') ? 'admin-sidebar__link--active' : '' }}"
                @if (request()->routeIs('donations.*'))
                    aria-current="page"
                @endif
                data-menu-name="data donasi"
            >
                <span class="admin-sidebar__link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 3V21"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <path
                            d="M17 7.5C17 5.843 14.761 4.5 12 4.5C9.239 4.5 7 5.843 7 7.5C7 9.157 9.239 10.5 12 10.5C14.761 10.5 17 11.843 17 13.5C17 15.157 14.761 16.5 12 16.5C9.239 16.5 7 15.157 7 13.5"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </span>

                <span class="admin-sidebar__link-text">
                    Data Donasi
                </span>

                <span class="admin-sidebar__link-indicator"></span>
            </a>

            {{-- Data Penerima Manfaat --}}
            <a
                href="{{ route('beneficiaries.index') }}"
                class="admin-sidebar__link {{ request()->routeIs('beneficiaries.*') ? 'admin-sidebar__link--active' : '' }}"
                @if (request()->routeIs('beneficiaries.*'))
                    aria-current="page"
                @endif
                data-menu-name="data penerima manfaat"
            >
                <span class="admin-sidebar__link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M3.5 19V17.5C3.5 14.739 5.739 12.5 8.5 12.5H9.5C12.261 12.5 14.5 14.739 14.5 17.5V19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 5.5C18.071 5.5 19.5 6.929 19.5 9S18.071 12.5 16 12.5M17 14.5C19.209 14.5 21 16.291 21 18.5V19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>

                <span class="admin-sidebar__link-text">
                    Data Penerima Manfaat
                </span>

                @if (request()->routeIs('beneficiaries.*'))
                    <span class="admin-sidebar__link-indicator"></span>
                @endif
            </a>
            
            {{-- Kategori Penerima Manfaat --}}
            <a
                href="{{ route('beneficiary-categories.index') }}"
                class="admin-sidebar__link {{ request()->routeIs('beneficiary-categories.*') ? 'admin-sidebar__link--active' : '' }}"
                @if (request()->routeIs('beneficiary-categories.*'))
                    aria-current="page"
                @endif
                data-menu-name="kategori penerima manfaat"
            >
                <span class="admin-sidebar__link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 9H16M8 12.5H16M8 16H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>

                <span class="admin-sidebar__link-text">
                    Kategori Penerima Manfaat
                </span>

                @if (request()->routeIs('beneficiary-categories.*'))
                    <span class="admin-sidebar__link-indicator"></span>
                @endif
            </a>

            {{-- Data Penyaluran --}}
            <a
                href="{{ route('distributions.index') }}"
                class="admin-sidebar__link {{ request()->routeIs('distributions.*') ? 'admin-sidebar__link--active' : '' }}"
                @if (request()->routeIs('distributions.*'))
                    aria-current="page"
                @endif
                data-menu-name="data penyaluran"
            >
                <span class="admin-sidebar__link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M4 5H20V19H4Z"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M8 9H16M8 13H16M8 17H13"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </span>

                <span class="admin-sidebar__link-text">
                    Data Penyaluran
                </span>

                @if (request()->routeIs('distributions.*'))
                    <span class="admin-sidebar__link-indicator"></span>
                @endif
            </a>

        </div>


        {{-- Preferensi --}}
        <div class="admin-sidebar__section">

            <span class="admin-sidebar__section-label">
                PREFERENSI
            </span>

            <button
                type="button"
                class="admin-sidebar__link admin-sidebar__link--disabled"
                disabled
                title="Menu ini belum tersedia"
            >
                <span class="admin-sidebar__link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle
                            cx="12"
                            cy="12"
                            r="3"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <path
                            d="M19.4 15A1.65 1.65 0 0 0 19.73 16.82L19.79 16.88L17.79 20.34L17.71 20.3A1.65 1.65 0 0 0 15.9 20.3A1.65 1.65 0 0 0 15 21.7V21.8H9V21.7A1.65 1.65 0 0 0 8.1 20.3A1.65 1.65 0 0 0 6.29 20.3L6.21 20.34L4.21 16.88L4.27 16.82A1.65 1.65 0 0 0 4.6 15A1.65 1.65 0 0 0 3 14H2.9V10H3A1.65 1.65 0 0 0 4.6 9A1.65 1.65 0 0 0 4.27 7.18L4.21 7.12L6.21 3.66L6.29 3.7A1.65 1.65 0 0 0 8.1 3.7A1.65 1.65 0 0 0 9 2.3V2.2H15V2.3A1.65 1.65 0 0 0 15.9 3.7A1.65 1.65 0 0 0 17.71 3.7L17.79 3.66L19.79 7.12L19.73 7.18A1.65 1.65 0 0 0 19.4 9A1.65 1.65 0 0 0 21 10H21.1V14H21A1.65 1.65 0 0 0 19.4 15Z"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linejoin="round"
                        />
                    </svg>
                </span>

                <span class="admin-sidebar__link-text">
                    Pengaturan
                </span>

                <span class="admin-sidebar__coming-soon">
                    Segera
                </span>
            </button>

        </div>

    </nav>


    {{-- Profil admin --}}
    <div class="admin-sidebar__bottom">

        <div class="admin-sidebar__profile">

            <div class="admin-sidebar__avatar" aria-hidden="true">
                A
            </div>

            <div class="admin-sidebar__profile-info">
                <span class="admin-sidebar__profile-name">
                    Administrator
                </span>

                <span class="admin-sidebar__profile-role">
                    Masjid Sabilillah
                </span>
            </div>

            <span
                class="admin-sidebar__profile-status"
                aria-label="Panel administrasi"
            ></span>

        </div>

        <div class="admin-sidebar__footer">
            <span>Masjid Sabilillah</span>
            <span class="admin-sidebar__footer-dot"></span>
            <span>Admin Panel</span>
        </div>

    </div>

</aside>

<div class="admin-sidebar-overlay" id="sidebarOverlay"></div>