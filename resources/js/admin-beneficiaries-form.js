
/* =========================================================
   ADMIN BENEFICIARIES FORM
   Create & Edit Penerima Manfaat
   Masjid Sabilillah
   ========================================================= */

(() => {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('.beneficiary-form');

        // Jalankan hanya pada halaman form penerima manfaat.
        if (!form) {
            return;
        }

        initOtherCategory();
        initFieldValidation();
        initFormSubmission();
        initValidationFocus();

        /* =================================================
           1. KATEGORI LAINNYA
           Menampilkan input tambahan jika kategori
           yang dipilih adalah "Lainnya".
           ================================================= */

        function initOtherCategory() {
            const categorySelect =
                form.querySelector('#category_id');

            const otherField =
                form.querySelector('#other-category-field');

            const otherInput =
                form.querySelector('#other_category');

            if (!categorySelect || !otherField || !otherInput) {
                return;
            }

            function toggleOtherCategory() {
                const selectedOption =
                    categorySelect.options[
                        categorySelect.selectedIndex
                    ];

                const selectedCategory = selectedOption
                    ? selectedOption.textContent
                        .trim()
                        .toLocaleLowerCase('id')
                    : '';

                const isOther = selectedCategory === 'lainnya';

                // Tampilkan atau sembunyikan kolom.
                otherField.hidden = !isOther;

                // Wajib diisi hanya ketika kategori Lainnya.
                otherInput.required = isOther;

                otherInput.setAttribute(
                    'aria-required',
                    String(isOther)
                );

                // Jika kategori diganti, hilangkan error
                // kategori lainnya yang sudah tidak relevan.
                if (!isOther) {
                    otherInput.classList.remove('is-invalid');

                    const errorMessage =
                        otherField.querySelector(
                            '.beneficiary-form__error'
                        );

                    if (errorMessage) {
                        errorMessage.remove();
                    }
                }
            }

            categorySelect.addEventListener(
                'change',
                toggleOtherCategory
            );

            // Penting untuk Create, Edit, dan old() Laravel.
            toggleOtherCategory();
        }

        /* =================================================
           2. VALIDASI FIELD
           Menghilangkan penanda error ketika pengguna
           mulai memperbaiki input.
           ================================================= */

        function initFieldValidation() {
            const fields = form.querySelectorAll(
                'input, select, textarea'
            );

            fields.forEach((field) => {
                const eventName =
                    field.tagName === 'SELECT'
                        ? 'change'
                        : 'input';

                field.addEventListener(eventName, () => {
                    if (!field.classList.contains('is-invalid')) {
                        return;
                    }

                    field.classList.remove('is-invalid');

                    const fieldContainer =
                        field.closest('.beneficiary-form__field');

                    if (!fieldContainer) {
                        return;
                    }

                    const errorMessage =
                        fieldContainer.querySelector(
                            '.beneficiary-form__error'
                        );

                    if (errorMessage) {
                        errorMessage.remove();
                    }
                });
            });
        }

        /* =================================================
           3. SUBMIT FORM
           Mencegah pengiriman berulang dan memberikan
           feedback ketika data sedang disimpan.
           ================================================= */

        function initFormSubmission() {
            form.addEventListener('submit', (event) => {
                // Jangan kirim form dua kali.
                if (form.dataset.submitting === 'true') {
                    event.preventDefault();
                    return;
                }

                // Biarkan validasi HTML browser bekerja.
                if (!form.checkValidity()) {
                    return;
                }

                const submitButton = event.submitter;

                form.dataset.submitting = 'true';

                form.setAttribute('aria-busy', 'true');

                if (!submitButton) {
                    return;
                }

                submitButton.dataset.originalHtml =
                    submitButton.innerHTML;

                submitButton.disabled = true;
                submitButton.setAttribute('aria-busy', 'true');

                submitButton.textContent = 'Menyimpan...';
            });
        }

        /* =================================================
           4. FOKUS PADA FIELD YANG ERROR
           Membantu admin menemukan kesalahan validasi
           setelah halaman dikembalikan oleh Laravel.
           ================================================= */

        function initValidationFocus() {
            const invalidField = form.querySelector(
                '.beneficiary-form__field .is-invalid'
            );

            if (!invalidField) {
                return;
            }

            // Hormati pengaturan reduced motion pengguna.
            const prefersReducedMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            window.requestAnimationFrame(() => {
                invalidField.scrollIntoView({
                    behavior: prefersReducedMotion
                        ? 'auto'
                        : 'smooth',
                    block: 'center',
                });

                invalidField.focus({
                    preventScroll: true,
                });
            });
        }
    });

    /* =====================================================
       5. PEMULIHAN TOMBOL
       Mengantisipasi halaman dibuka kembali melalui
       browser Back/Forward setelah submit.
       ===================================================== */

    window.addEventListener('pageshow', () => {
        const form = document.querySelector('.beneficiary-form');

        if (!form) {
            return;
        }

        form.dataset.submitting = 'false';
        form.removeAttribute('aria-busy');

        const submitButtons = form.querySelectorAll(
            'button[type="submit"]'
        );

        submitButtons.forEach((button) => {
            button.disabled = false;
            button.removeAttribute('aria-busy');

            if (button.dataset.originalHtml) {
                button.innerHTML = button.dataset.originalHtml;
                delete button.dataset.originalHtml;
            }
        });
    });
})();
