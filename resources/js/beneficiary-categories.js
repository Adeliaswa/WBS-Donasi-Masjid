
/* =========================================================
   KATEGORI PENERIMA MANFAAT
   Masjid Sabilillah
   ========================================================= */

(() => {
    'use strict';

    document.addEventListener('DOMContentLoaded', initCategoryPage);

    function initCategoryPage() {
        const page = document.querySelector(
            '.beneficiary-categories-page'
        );

        // Jangan jalankan script pada halaman lain.
        if (!page) {
            return;
        }

        initActionForms(page);
        initAlertFocus(page);
    }

    /* =====================================================
       1. FORM AKSI KATEGORI
       Mencegah submit berulang.
       Konfirmasi tetap mengikuti onsubmit pada Blade.
       ===================================================== */

    function initActionForms(page) {
        const forms = page.querySelectorAll(
            '.beneficiary-categories-action-form'
        );

        forms.forEach((form) => {
            form.addEventListener('submit', (event) => {
                // Jangan proses jika konfirmasi bawaan dibatalkan.
                if (event.defaultPrevented) {
                    return;
                }

                // Cegah pengiriman form berulang.
                if (form.dataset.submitting === 'true') {
                    event.preventDefault();
                    return;
                }

                const submitButton = event.submitter
                    || form.querySelector('button[type="submit"]');

                if (!submitButton) {
                    return;
                }

                form.dataset.submitting = 'true';
                form.setAttribute('aria-busy', 'true');

                // Simpan teks asli untuk menjaga tampilan.
                if (!submitButton.dataset.originalText) {
                    submitButton.dataset.originalText =
                        submitButton.textContent.trim();
                }

                submitButton.disabled = true;
                submitButton.textContent = 'Memproses...';
                submitButton.classList.add('is-processing');

                // Form dilanjutkan secara normal ke Laravel.
            });
        });
    }

    /* =====================================================
       2. NOTIFIKASI
       Fokuskan notifikasi ketika ada pesan dari server.
       ===================================================== */

    function initAlertFocus(page) {
        const alert = page.querySelector(
            '.beneficiary-categories-alert'
        );

        if (!alert) {
            return;
        }

        // Buat notifikasi dapat menerima fokus aksesibel.
        if (!alert.hasAttribute('tabindex')) {
            alert.setAttribute('tabindex', '-1');
        }

        // Jangan menggeser halaman secara paksa.
        // Fokus hanya diberikan jika browser mendukungnya.
        if (typeof alert.focus === 'function') {
            alert.focus({ preventScroll: true });
        }
    }
})();
