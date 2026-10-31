
<aside class="admin-sidebar" id="adminSidebar">

    {{-- BRAND --}}
    <div class="admin-sidebar__brand">

        <a href="{{ route('dashboard') }}"
           class="admin-sidebar__brand-link"
           aria-label="Masjid Sabilillah">

            <div class="admin-sidebar__logo" aria-hidden="true">
                <svg viewBox="0 0 48 48" fill="none">
                    <path
                        d="M24 5L27 14L36 10L32 19L42 22L32 25L36 34L27 30L24 40L21 30L12 34L16 25L6 22L16 19L12 10L21 14L24 5Z"
                        fill="currentColor" opacity=".15"
                    />
                    <path
                        d="M12 37V24C12 17.373 17.373 12 24 12C30.627 12 36 17.373 36 24V37"
                        stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round"
                    />
                    <path
                        d="M18 37V28C18 24.686 20.686 22 24 22C27.314 22 30 24.686 30 28V37"
                        stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round"
                    />
                    <path
                        d="M7 37H41M24 5V9"
                        stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round"
                    />
                </svg>
            </div>

            <div class="admin-sidebar__brand-info">
                <span class="admin-sidebar__brand-name">Sabilillah</span>
                <span class="admin-sidebar__brand-caption">ADMIN PANEL</span>
            </div>

        </a>

        <button
            type="button"
            class="admin-sidebar__close"
            id="closeSidebar"
            aria-label="Tutup menu"
        >
            <svg viewBox="0 0 24 24" fill="none">
                <path
                    d="M18 6L6 18M6 6L18 18"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>
        </button>

    </div>


    {{-- NAVIGATION --}}
    <nav class="admin-sidebar__navigation" aria-label="Navigasi utama">

        <div class="admin-sidebar__section">

            {{-- DASHBOARD --}}
            <a
                href="{{ route('dashboard') }}"
                class="admin-sidebar__link {{ request()->routeIs('dashboard') ? 'admin-sidebar__link--active' : '' }}"
                @if(request()->routeIs('dashboard')) aria-current="page" @endif
            >
                <span class="admin-sidebar__link-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"
                              stroke="currentColor" stroke-width="1.7"/>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"
                              stroke="currentColor" stroke-width="1.7"/>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"
                              stroke="currentColor" stroke-width="1.7"/>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"
                              stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </span>
                <span class="admin-sidebar__link-text">Dashboard</span>
            </a>


            {{-- DATA DONASI --}}
            <a
                href="{{ route('donations.index') }}"
                class="admin-sidebar__link {{ request()->routeIs('donations.*') ? 'admin-sidebar__link--active' : '' }}"
                @if(request()->routeIs('donations.*')) aria-current="page" @endif
            >
                <span class="admin-sidebar__link-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 3V21"
                              stroke="currentColor" stroke-width="1.8"
                              stroke-linecap="round"/>
                        <path
                            d="M17 7.5C17 5.843 14.761 4.5 12 4.5C9.239 4.5 7 5.843 7 7.5C7 9.157 9.239 10.5 12 10.5C14.761 10.5 17 11.843 17 13.5C17 15.157 14.761 16.5 12 16.5C9.239 16.5 7 15.157 7 13.5"
                            stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </span>
                <span class="admin-sidebar__link-text">Data Donasi</span>
            </a>


            {{-- DATA PENERIMA MANFAAT --}}
            <details
                class="admin-sidebar__menu-group"
                {{ request()->routeIs('beneficiaries.*', 'beneficiary-categories.*') ? 'open' : '' }}
            >
                <summary
                    class="admin-sidebar__link admin-sidebar__link--group {{ request()->routeIs('beneficiaries.*', 'beneficiary-categories.*') ? 'admin-sidebar__link--active' : '' }}"
                >
                    <span class="admin-sidebar__link-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="9" cy="8" r="3"
                                    stroke="currentColor" stroke-width="1.8"/>
                            <path
                                d="M3.5 19v-1.5a5.5 5.5 0 0 1 11 0V19"
                                stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round"
                            />
                            <path
                                d="M16 5.5a3 3 0 0 1 0 5.8M17 14a5 5 0 0 1 3.5 4.8V19"
                                stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>

                    <span class="admin-sidebar__link-text">
                        Data Penerima Manfaat
                    </span>

                    <span class="admin-sidebar__menu-chevron">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="m7 10 5 5 5-5"
                                stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>
                </summary>

                <div class="admin-sidebar__submenu">

                    <a
                        href="{{ route('beneficiaries.index') }}"
                        class="admin-sidebar__submenu-link {{ request()->routeIs('beneficiaries.*') ? 'is-active' : '' }}"
                        @if(request()->routeIs('beneficiaries.*')) aria-current="page" @endif
                    >
                        Daftar Penerima
                    </a>

                    <a
                        href="{{ route('beneficiary-categories.index') }}"
                        class="admin-sidebar__submenu-link {{ request()->routeIs('beneficiary-categories.*') ? 'is-active' : '' }}"
                        @if(request()->routeIs('beneficiary-categories.*')) aria-current="page" @endif
                    >
                        Kategori Penerima
                    </a>

                </div>
            </details>


            {{-- DATA PENYALURAN --}}
            <a
                href="{{ route('distributions.index') }}"
                class="admin-sidebar__link {{ request()->routeIs('distributions.*') ? 'admin-sidebar__link--active' : '' }}"
                @if(request()->routeIs('distributions.*')) aria-current="page" @endif
            >
                <span class="admin-sidebar__link-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 5H20V19H4Z"
                              stroke="currentColor" stroke-width="1.8"
                              stroke-linejoin="round"/>
                        <path
                            d="M8 9H16M8 13H16M8 17H13"
                            stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </span>
                <span class="admin-sidebar__link-text">Data Penyaluran</span>
            </a>

        </div>

    </nav>


    {{-- ADMIN PROFILE --}}
    <div class="admin-sidebar__bottom">

        <div class="admin-sidebar__profile">

            <div class="admin-sidebar__avatar" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>

            <div class="admin-sidebar__profile-info">

                <span class="admin-sidebar__profile-name">
                    Pengurus
                </span>

                <span class="admin-sidebar__profile-role">
                    Masjid Sabilillah
                </span>

            </div>

            <span
                class="admin-sidebar__profile-status"
                title="Status aktif"
                aria-label="Aktif"
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
