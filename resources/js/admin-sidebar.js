
document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    const openButton = document.getElementById('openSidebar');
    const closeButton = document.getElementById('closeSidebar');

    if (!sidebar) return;

    const mobileQuery = window.matchMedia('(max-width: 768px)');

    /* OPEN SIDEBAR */
    function openSidebar() {

        if (!mobileQuery.matches) return;

        sidebar.classList.add('is-open');
        overlay?.classList.add('is-visible');

        document.body.classList.add('sidebar-open');

        openButton?.setAttribute('aria-expanded', 'true');

        closeButton?.focus();
    }

    /* CLOSE SIDEBAR */
    function closeSidebar() {

        sidebar.classList.remove('is-open');
        overlay?.classList.remove('is-visible');

        document.body.classList.remove('sidebar-open');

        openButton?.setAttribute('aria-expanded', 'false');
    }

    /* BUTTON EVENTS */
    openButton?.addEventListener('click', openSidebar);

    closeButton?.addEventListener('click', () => {

        closeSidebar();
        openButton?.focus();

    });

    overlay?.addEventListener('click', closeSidebar);

    /* ESCAPE KEY */
    document.addEventListener('keydown', (event) => {

        if (
            event.key === 'Escape' &&
            sidebar.classList.contains('is-open')
        ) {

            closeSidebar();
            openButton?.focus();

        }

    });

    /* CLOSE AFTER NAVIGATION */
    sidebar.querySelectorAll('a').forEach((link) => {

        link.addEventListener('click', () => {

            if (mobileQuery.matches) {
                closeSidebar();
            }

        });

    });

    /* SUBMENU: ONE OPEN AT A TIME */
    const menuGroups = sidebar.querySelectorAll(
        '.admin-sidebar__menu-group'
    );

    menuGroups.forEach((group) => {

        group.addEventListener('toggle', () => {

            if (!group.open) return;

            menuGroups.forEach((otherGroup) => {

                if (otherGroup !== group) {
                    otherGroup.open = false;
                }

            });

        });

    });

    /* RESPONSIVE RESET */
    mobileQuery.addEventListener('change', (event) => {

        if (!event.matches) {
            closeSidebar();
        }

    });

});
