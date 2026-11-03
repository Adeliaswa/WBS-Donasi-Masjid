/* =========================================================
   MASJID SABILILLAH
   ADMIN — CREATE PENERIMA MANFAAT
   File: resources/js/admin-beneficiaries-form.js
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       1. ELEMENT KATEGORI
       ===================================================== */

    const categorySelect = document.getElementById('category_id');
    const otherField = document.getElementById('other-category-field');
    const otherInput = document.getElementById('other_category');


    if (!categorySelect || !otherField || !otherInput) {
        return;
    }


    /* =====================================================
       2. TOGGLE KATEGORI LAINNYA
       ===================================================== */

    function toggleOtherCategory() {

        const selectedOption =
            categorySelect.options[categorySelect.selectedIndex];

        const isOther = selectedOption &&
            selectedOption.textContent.trim().toLowerCase() === 'lainnya';

        // Tampilkan atau sembunyikan field.
        otherField.hidden = !isOther;

        // Atur status wajib isi.
        otherInput.required = Boolean(isOther);

        // Input tidak dikirim ketika tidak digunakan.
        otherInput.disabled = !isOther;

        // Hapus nilai ketika kategori lainnya tidak dipilih.
        if (!isOther) {
            otherInput.value = '';
        }
    }


    /* =====================================================
       3. EVENT LISTENER
       ===================================================== */

    categorySelect.addEventListener('change', function () {

        toggleOtherCategory();

        const selectedOption =
            categorySelect.options[categorySelect.selectedIndex];

        const isOther = selectedOption &&
            selectedOption.textContent.trim().toLowerCase() === 'lainnya';

        if (isOther) {
            otherInput.focus();
        }

    });


    /* =====================================================
       4. INITIAL STATE
       ===================================================== */

    toggleOtherCategory();

});