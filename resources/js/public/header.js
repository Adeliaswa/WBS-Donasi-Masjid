
/* =========================================================
   PUBLIC HEADER
   Navigation Indicator & Mobile Menu
   Masjid Sabilillah
========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    const header = document.querySelector('.public-header');

    if (!header) return;

    const navigation = header.querySelector('.public-navigation');

    const navigationLinks = header.querySelectorAll(
        '[data-nav-link]'
    );

    const indicator = header.querySelector(
        '.public-navigation__indicator'
    );

    const toggle = header.querySelector(
        '.public-header__toggle'
    );


    /* =====================================================
       ACTIVE NAVIGATION
    ===================================================== */

    function setActiveLink(link) {

        if (!link) return;

        navigationLinks.forEach(item => {
            item.classList.remove('active');
        });

        link.classList.add('active');

        moveIndicator(link);

    }


    /* =====================================================
       MOVE ACTIVE INDICATOR
    ===================================================== */

    function moveIndicator(link) {

        if (!indicator || !link) return;

        if (window.innerWidth <= 850) return;

        const left = link.offsetLeft;
        const width = link.offsetWidth;

        indicator.style.left = `${left}px`;
        indicator.style.width = `${width}px`;
        indicator.style.opacity = '1';

    }


    /* =====================================================
       INITIAL ACTIVE INDICATOR
    ===================================================== */

    function initializeIndicator() {

        const currentHash = window.location.hash;

        let activeLink = null;

        if (currentHash) {

            activeLink = Array.from(navigationLinks).find(link => {

                const linkUrl = new URL(
                    link.href,
                    window.location.origin
                );

                return (
                    linkUrl.pathname === window.location.pathname &&
                    linkUrl.hash === currentHash
                );

            });

        }

        if (!activeLink) {

            activeLink = header.querySelector(
                '.public-navigation__link.active'
            );

        }

        if (!activeLink) {

            activeLink = navigationLinks[0];

        }

        if (activeLink) {

            navigationLinks.forEach(link => {
                link.classList.remove('active');
            });

            activeLink.classList.add('active');

            moveIndicator(activeLink);

        }

    }


    /* =====================================================
       HOVER EFFECT
       Indicator follows hovered navigation
    ===================================================== */

    navigationLinks.forEach(link => {

        link.addEventListener('mouseenter', () => {

            if (window.innerWidth <= 850) return;

            moveIndicator(link);

        });


        link.addEventListener('click', () => {

            setActiveLink(link);

        });

    });


    /* =====================================================
       RESTORE ACTIVE INDICATOR
       When mouse leaves navigation
    ===================================================== */

    const linksWrapper = header.querySelector(
        '.public-navigation__links'
    );

    if (linksWrapper) {

        linksWrapper.addEventListener('mouseleave', () => {

            const activeLink = linksWrapper.querySelector(
                '.public-navigation__link.active'
            );

            if (activeLink) {

                moveIndicator(activeLink);

            }

        });

    }


    /* =====================================================
       MOBILE MENU
    ===================================================== */

    function closeMobileMenu() {

        if (!navigation || !toggle) return;

        navigation.classList.remove('is-open');

        toggle.classList.remove('is-active');

        toggle.setAttribute('aria-expanded', 'false');

        toggle.setAttribute('aria-label', 'Buka navigasi');

        document.body.classList.remove('public-menu-open');

    }


    function openMobileMenu() {

        if (!navigation || !toggle) return;

        navigation.classList.add('is-open');

        toggle.classList.add('is-active');

        toggle.setAttribute('aria-expanded', 'true');

        toggle.setAttribute('aria-label', 'Tutup navigasi');

        document.body.classList.add('public-menu-open');

    }


    if (toggle && navigation) {

        toggle.addEventListener('click', () => {

            const isOpen = navigation.classList.contains(
                'is-open'
            );

            if (isOpen) {

                closeMobileMenu();

            } else {

                openMobileMenu();

            }

        });


        // Tutup menu setelah link dipilih

        navigationLinks.forEach(link => {

            link.addEventListener('click', () => {

                closeMobileMenu();

            });

        });


        const contactLink = navigation.querySelector(
            '.public-navigation__contact'
        );

        if (contactLink) {

            contactLink.addEventListener('click', () => {

                closeMobileMenu();

            });

        }


        // Tutup menu jika pengguna klik di luar navbar

        document.addEventListener('click', event => {

            if (
                !header.contains(event.target) &&
                navigation.classList.contains('is-open')
            ) {

                closeMobileMenu();

            }

        });

    }


    /* =====================================================
       RESIZE HANDLING
    ===================================================== */

    window.addEventListener('resize', () => {

        if (window.innerWidth > 850) {

            closeMobileMenu();

            initializeIndicator();

        } else if (indicator) {

            indicator.style.opacity = '0';

        }

    });


    /* =====================================================
       INITIALIZE
    ===================================================== */

    initializeIndicator();


    console.log('Public header initialized.');

});
