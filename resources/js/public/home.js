
/* =========================================================
   PUBLIC HOME JAVASCRIPT
   MASJID SABILILLAH
========================================================= */

export function initHome() {

    initMobileNavigation();

    initSmoothScroll();

    initHeroImage();

    initActivityImages();

}


/* =========================================================
   MOBILE NAVIGATION
========================================================= */

function initMobileNavigation() {

    const toggle = document.querySelector(
        '.public-header__toggle'
    );

    const navigation = document.querySelector(
        '.public-navigation'
    );

    if (!toggle || !navigation) {
        return;
    }


    function closeNavigation() {

        navigation.classList.remove('is-open');

        toggle.setAttribute('aria-expanded', 'false');

    }


    function openNavigation() {

        navigation.classList.add('is-open');

        toggle.setAttribute('aria-expanded', 'true');

    }


    toggle.setAttribute('aria-expanded', 'false');


    toggle.addEventListener('click', () => {

        const isOpen =
            toggle.getAttribute('aria-expanded') === 'true';

        isOpen ? closeNavigation() : openNavigation();

    });


    navigation.querySelectorAll('a').forEach(link => {

        link.addEventListener('click', closeNavigation);

    });


    document.addEventListener('click', event => {

        if (
            !navigation.contains(event.target) &&
            !toggle.contains(event.target)
        ) {

            closeNavigation();

        }

    });


    window.addEventListener('resize', () => {

        if (window.innerWidth > 768) {

            closeNavigation();

        }

    });

}


/* =========================================================
   SMOOTH SCROLL
========================================================= */

function initSmoothScroll() {

    const links = document.querySelectorAll(
        'a[href^="#"]'
    );


    links.forEach(link => {

        link.addEventListener('click', event => {

            const targetId = link.getAttribute('href');

            if (!targetId || targetId === '#') {
                return;
            }


            let target;

            try {

                target = document.querySelector(targetId);

            } catch (error) {

                return;

            }


            if (!target) {
                return;
            }


            event.preventDefault();


            target.scrollIntoView({

                behavior: 'smooth',

                block: 'start'

            });

        });

    });

}


/* =========================================================
   HERO IMAGE
========================================================= */

function initHeroImage() {

    const image = document.querySelector(
        '.public-hero__image'
    );

    if (!image) {
        return;
    }


    image.addEventListener('error', () => {

        image.classList.add('image-error');

    });


    image.addEventListener('load', () => {

        image.classList.remove('image-error');

    });

}


/* =========================================================
   ACTIVITY IMAGES
========================================================= */

function initActivityImages() {

    const images = document.querySelectorAll(
        '.public-activity-card__image img'
    );


    images.forEach(image => {

        image.addEventListener('error', () => {

            const wrapper = image.closest(
                '.public-activity-card__image'
            );

            if (!wrapper) {
                return;
            }


            image.remove();


            const placeholder = document.createElement('div');

            placeholder.className =
                'public-activity-card__placeholder';

            placeholder.textContent =
                'Foto kegiatan belum tersedia';


            wrapper.appendChild(placeholder);

        });

    });

}
