document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('deleteDonationModal');
    const deleteForm = document.getElementById('deleteDonationForm');
    const donationName = document.getElementById('deleteDonationName');

    if (!modal || !deleteForm || !donationName) {
        return;
    }

    const openModal = (button) => {
        const deleteUrl = button.dataset.deleteUrl;
        const name = button.dataset.donationName || 'ini';

        if (!deleteUrl) {
            return;
        }

        deleteForm.action = deleteUrl;
        donationName.textContent = name;

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('donations-modal-open');

        const cancelButton = modal.querySelector('[data-close-modal]');

        if (cancelButton) {
            cancelButton.focus();
        }
    };

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('donations-modal-open');
    };

    document.querySelectorAll('[data-delete-trigger]').forEach((button) => {
        button.addEventListener('click', () => {
            openModal(button);
        });
    });

    modal.querySelectorAll('[data-close-modal]').forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
});