
/* =========================================================
   ADMIN BENEFICIARIES - DETAIL PAGE
   Masjid Sabilillah
   ========================================================= */

(() => {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const detailPage = document.querySelector(
            '.beneficiary-detail-page'
        );

        // Jalankan hanya pada halaman detail penerima manfaat.
        if (!detailPage) {
            return;
        }

        /* =================================================
           1. COPY NIK DAN NOMOR KONTAK
           ================================================= */

        const detailFields = detailPage.querySelectorAll(
            '.beneficiary-detail-field'
        );

        detailFields.forEach((field) => {
            const label = field.querySelector(
                '.beneficiary-detail-field__label'
            );

            const value = field.querySelector(
                '.beneficiary-detail-field__value'
            );

            if (!label || !value) {
                return;
            }

            const labelText = label.textContent
                .trim()
                .toLowerCase()
                .replace(/\s+/g, ' ');

            // Tombol salin hanya ditambahkan pada informasi
            // yang umum perlu disalin oleh admin.
            const copyableLabels = [
                'nik',
                'nomor kontak',
                'kontak',
            ];

            if (!copyableLabels.includes(labelText)) {
                return;
            }

            // Hindari membuat tombol salin dua kali.
            if (field.querySelector('.beneficiary-detail-copy')) {
                return;
            }

            const valueText = value.textContent.trim();

            // Jangan tampilkan tombol untuk data kosong.
            if (!valueText || valueText === '-') {
                return;
            }

            const copyButton = document.createElement('button');

            copyButton.type = 'button';
            copyButton.className = 'beneficiary-detail-copy';
            copyButton.textContent = 'Salin';
            copyButton.setAttribute(
                'aria-label',
                `Salin ${label.textContent.trim()}`
            );

            field.appendChild(copyButton);

            let resetTimer = null;

            copyButton.addEventListener('click', async () => {
                const originalText = 'Salin';

                if (resetTimer) {
                    window.clearTimeout(resetTimer);
                }

                try {
                    await copyToClipboard(valueText);

                    copyButton.textContent = 'Tersalin';
                    copyButton.classList.add('is-copied');
                    copyButton.setAttribute(
                        'aria-label',
                        `${label.textContent.trim()} berhasil disalin`
                    );
                } catch (error) {
                    console.error(
                        'Gagal menyalin informasi penerima:',
                        error
                    );

                    copyButton.textContent = 'Gagal menyalin';
                    copyButton.classList.remove('is-copied');
                    copyButton.setAttribute(
                        'aria-label',
                        'Gagal menyalin. Silakan coba lagi.'
                    );
                }

                resetTimer = window.setTimeout(() => {
                    copyButton.textContent = originalText;
                    copyButton.classList.remove('is-copied');
                    copyButton.setAttribute(
                        'aria-label',
                        `Salin ${label.textContent.trim()}`
                    );

                    resetTimer = null;
                }, 1800);
            });
        });

        /* =================================================
           2. TOMBOL CETAK DETAIL
           ================================================= */

        detailPage.addEventListener('click', (event) => {
            const printButton = event.target.closest(
                '[data-print-page]'
            );

            if (!printButton || !detailPage.contains(printButton)) {
                return;
            }

            event.preventDefault();

            window.print();
        });

        /* =================================================
           3. KONFIRMASI FORM YANG MEMILIKI DATA-CONFIRM
           ================================================= */

        const confirmForms = detailPage.querySelectorAll(
            'form[data-confirm]'
        );

        confirmForms.forEach((form) => {
            form.addEventListener('submit', (event) => {
                const message =
                    form.dataset.confirm ||
                    'Apakah kamu yakin ingin melanjutkan tindakan ini?';

                const confirmed = window.confirm(message);

                if (!confirmed) {
                    event.preventDefault();
                }
            });
        });

        /* =================================================
           4. PENCEGAHAN SUBMIT BERULANG
           Aktif hanya pada form dengan data-disable-on-submit.
           ================================================= */

        const protectedForms = detailPage.querySelectorAll(
            'form[data-disable-on-submit]'
        );

        protectedForms.forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    return;
                }

                if (form.dataset.submitting === 'true') {
                    event.preventDefault();
                    return;
                }

                form.dataset.submitting = 'true';

                const submitButtons = form.querySelectorAll(
                    'button[type="submit"], input[type="submit"]'
                );

                submitButtons.forEach((button) => {
                    button.disabled = true;

                    if (button.tagName === 'BUTTON') {
                        button.dataset.originalText =
                            button.textContent;

                        button.textContent = 'Memproses...';
                    }
                });
            });
        });
    });

    /* =====================================================
       5. FUNGSI COPY CLIPBOARD
       Menggunakan Clipboard API dengan fallback.
       ===================================================== */

    async function copyToClipboard(text) {
        if (
            navigator.clipboard &&
            typeof navigator.clipboard.writeText === 'function'
        ) {
            try {
                await navigator.clipboard.writeText(text);
                return;
            } catch (error) {
                // Coba metode fallback jika Clipboard API gagal.
            }
        }

        const textarea = document.createElement('textarea');

        textarea.value = text;
        textarea.setAttribute('readonly', '');
        textarea.setAttribute('aria-hidden', 'true');

        textarea.style.position = 'fixed';
        textarea.style.top = '0';
        textarea.style.left = '-9999px';
        textarea.style.opacity = '0';

        document.body.appendChild(textarea);

        try {
            textarea.focus();
            textarea.select();

            const copied = document.execCommand('copy');

            if (!copied) {
                throw new Error('Browser tidak dapat menyalin teks.');
            }
        } finally {
            textarea.remove();
        }
    }
})();
