document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    const openButton = document.getElementById('openSidebar');
    const closeButton = document.getElementById('closeSidebar');

    const mobileQuery = window.matchMedia('(max-width: 768px)');

    if (!sidebar) {
        return;
    }

    function openSidebar() {
        if (!mobileQuery.matches) {
            return;
        }

        sidebar.classList.add('is-open');
        overlay?.classList.add('is-visible');

        document.body.classList.add('sidebar-open');

        openButton?.setAttribute('aria-expanded', 'true');
        sidebar.setAttribute('aria-hidden', 'false');
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay?.classList.remove('is-visible');

        document.body.classList.remove('sidebar-open');

        openButton?.setAttribute('aria-expanded', 'false');

        if (mobileQuery.matches) {
            sidebar.setAttribute('aria-hidden', 'true');
        } else {
            sidebar.removeAttribute('aria-hidden');
        }
    }

    openButton?.addEventListener('click', () => {
        if (sidebar.classList.contains('is-open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    closeButton?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape' &&
            sidebar.classList.contains('is-open')
        ) {
            closeSidebar();
            openButton?.focus();
        }
    });

    function syncSidebar() {
        closeSidebar();

        if (mobileQuery.matches) {
            sidebar.setAttribute('aria-hidden', 'true');
        } else {
            sidebar.removeAttribute('aria-hidden');
        }
    }

    if (mobileQuery.addEventListener) {
        mobileQuery.addEventListener('change', syncSidebar);
    } else {
        mobileQuery.addListener(syncSidebar);
    }

    syncSidebar();
});