document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. TOMBOL LIHAT / SEMBUNYIKAN PASSWORD
    // ==========================================

    const togglePassword = document.querySelector('[data-password-toggle]');
    const passwordInput = document.querySelector('#password');

    const eyeOpen = document.querySelector('[data-eye-open]');
    const eyeClosed = document.querySelector('[data-eye-closed]');

    if (togglePassword && passwordInput && eyeOpen && eyeClosed) {
        togglePassword.addEventListener('click', () => {
            // Cek apakah password sedang tersembunyi.
            const passwordIsHidden = passwordInput.type === 'password';

            if (passwordIsHidden) {
                // Password ditampilkan.
                passwordInput.type = 'text';

                // Tampilkan mata terbuka saja.
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';

                togglePassword.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

                togglePassword.setAttribute(
                    'title',
                    'Sembunyikan password'
                );

                togglePassword.setAttribute('aria-pressed', 'true');
            } else {
                // Password disembunyikan.
                passwordInput.type = 'password';

                // Tampilkan mata bersilang saja.
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';

                togglePassword.setAttribute(
                    'aria-label',
                    'Tampilkan password'
                );

                togglePassword.setAttribute(
                    'title',
                    'Tampilkan password'
                );

                togglePassword.setAttribute('aria-pressed', 'false');
            }
        });
    }


    // ==========================================
    // 2. FEEDBACK KETIKA FORM DIKIRIM
    // ==========================================

    const loginForm = document.querySelector('.login-form');
    const loginButton = document.querySelector('[data-login-button]');
    const buttonText = document.querySelector('[data-button-text]');

    if (loginForm && loginButton && buttonText) {
        loginForm.addEventListener('submit', (event) => {
            // Periksa validasi bawaan browser.
            if (!loginForm.checkValidity()) {
                event.preventDefault();
                loginForm.reportValidity();
                return;
            }

            // Cegah pengiriman berulang.
            if (loginButton.disabled) {
                event.preventDefault();
                return;
            }

            // Tampilkan status proses.
            loginButton.disabled = true;
            buttonText.textContent = 'Memproses...';
        });
    }
});