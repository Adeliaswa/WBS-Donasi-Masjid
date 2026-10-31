
<footer class="admin-footer">
    <div class="admin-footer__content">

        {{-- Identitas aplikasi --}}
        <div class="admin-footer__brand">

            <span class="admin-footer__icon" aria-hidden="true">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M3 21h18"/>
                    <path d="M5 21V10l7-6 7 6v11"/>
                    <path d="M9 21v-6a3 3 0 0 1 6 0v6"/>
                    <path d="M12 2v2"/>
                </svg>
            </span>

            <span class="admin-footer__name">
                Sistem Pengelolaan Donasi Masjid Sabilillah
            </span>

        </div>

        {{-- Informasi footer --}}
        <div class="admin-footer__info">

            <span>Dashboard Pengurus</span>

            <span class="admin-footer__separator"></span>

            <span>© {{ date('Y') }} Masjid Sabilillah</span>

        </div>

    </div>
</footer>
