document.addEventListener('DOMContentLoaded', function () {
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
});