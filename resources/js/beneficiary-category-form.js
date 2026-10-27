/* =====================================================
   MASJID SABILILLAH
   FORM KATEGORI PENERIMA MANFAAT
   ===================================================== */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("beneficiaryCategoryForm");

    if (!form) {
        return;
    }

    const nameInput = form.querySelector("#name");
    const descriptionInput = form.querySelector("#description");

    const submitButton = document.getElementById(
        "submitCategoryButton"
    );

    const submitLabel = form.querySelector("[data-submit-label]");

    /* =================================================
       1. CHARACTER COUNTER
       ================================================= */

    function updateCounter(input) {
        if (!input) {
            return;
        }

        const counter = form.querySelector(
            '[data-counter-for="' + input.id + '"]'
        );

        if (!counter) {
            return;
        }

        const length = input.value.length;

        if (input.id === "name") {
            const maxLength = Number(input.getAttribute("maxlength"));

            counter.textContent = length + "/" + maxLength;

            counter.classList.remove(
                "is-near-limit",
                "is-at-limit"
            );

            if (length >= maxLength) {
                counter.classList.add("is-at-limit");
            } else if (length >= maxLength * 0.9) {
                counter.classList.add("is-near-limit");
            }

            return;
        }

        counter.textContent = length + " karakter";
    }

    if (nameInput) {
        updateCounter(nameInput);

        nameInput.addEventListener("input", function () {
            updateCounter(nameInput);
        });
    }

    if (descriptionInput) {
        updateCounter(descriptionInput);

        descriptionInput.addEventListener("input", function () {
            updateCounter(descriptionInput);
        });
    }

    /* =================================================
       2. AUTO RESIZE TEXTAREA
       ================================================= */

    const autoResizeFields = form.querySelectorAll(
        "textarea[data-autoresize]"
    );

    function resizeTextarea(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }

    autoResizeFields.forEach(function (textarea) {
        resizeTextarea(textarea);

        textarea.addEventListener("input", function () {
            resizeTextarea(textarea);
        });
    });

    /* =================================================
       3. SUBMIT FEEDBACK
       Mencegah pengiriman form berulang
       ================================================= */

    form.addEventListener("submit", function (event) {
        if (form.dataset.submitting === "true") {
            event.preventDefault();
            return;
        }

        if (!form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
            return;
        }

        form.dataset.submitting = "true";

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.setAttribute("aria-busy", "true");
            submitButton.classList.add("is-loading");
        }

        if (submitLabel) {
            submitLabel.textContent = "Menyimpan...";
        }
    });
});