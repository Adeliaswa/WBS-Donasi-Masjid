
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // VALIDASI NOMINAL BANTUAN
    // ==========================================

    const amountInputs = document.querySelectorAll(
        'input[name="amount"]'
    );

    amountInputs.forEach(function (input) {

        function validateAmount() {
            if (input.validity.valueMissing) {
                input.setCustomValidity(
                    'Nominal bantuan wajib diisi.'
                );
            } else if (input.validity.badInput) {
                input.setCustomValidity(
                    'Masukkan nominal bantuan dengan angka yang valid.'
                );
            } else if (input.validity.rangeUnderflow) {
                input.setCustomValidity(
                    'Nominal bantuan minimal Rp10.000.'
                );
            } else {
                input.setCustomValidity('');
            }
        }

        input.addEventListener('input', validateAmount);
        input.addEventListener('change', validateAmount);
        input.addEventListener('invalid', validateAmount);
    });


    // ==========================================
    // NOTES CHARACTER COUNTER (MAX 500)
    // ==========================================

    const notesInput = document.getElementById(
        'distribution-notes'
    );

    const notesCounter = document.getElementById(
        'distribution-notes-count'
    );

    if (notesInput && notesCounter) {

        const maxLength = 500;

        function updateNotesCounter() {

            // Batasi jumlah karakter maksimal 500
            if (notesInput.value.length > maxLength) {
                notesInput.value = notesInput.value.substring(
                    0,
                    maxLength
                );
            }

            // Perbarui jumlah karakter
            notesCounter.textContent = notesInput.value.length;
        }

        // Hitung karakter saat halaman pertama kali dibuka
        updateNotesCounter();

        // Perbarui saat pengguna mengetik atau paste
        notesInput.addEventListener(
            'input',
            updateNotesCounter
        );
    }

});
