<form action="{{ route('login.process') }}" method="POST" class="login-form">
    @csrf

    {{-- INPUT EMAIL --}}
    <div class="form-group">
        <label for="email">Alamat Email</label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="nama@email.com"
            autocomplete="username"
            required
            autofocus
            class="@error('email') input-error @enderror"
        >

        @error('email')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>


    {{-- INPUT PASSWORD --}}
    <div class="form-group">
        <label for="password">Password</label>

        <div class="password-wrapper">

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
                class="@error('password') input-error @enderror"
            >

            {{-- Tombol mata --}}
            <button
                type="button"
                class="toggle-password"
                data-password-toggle
                aria-label="Tampilkan password"
                aria-pressed="false"
                title="Tampilkan password"
            >

                {{-- Mata terbuka: password terlihat --}}
                <svg
                    data-eye-open
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    style="display: none;"
                >
                    <path
                        d="M2.5 12C4.4 8.4 7.8 6 12 6C16.2 6 19.6 8.4 21.5 12C19.6 15.6 16.2 18 12 18C7.8 18 4.4 15.6 2.5 12Z"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        stroke="currentColor"
                        stroke-width="1.8"
                    />
                </svg>


                {{-- Mata bersilang: password tersembunyi --}}
                <svg
                    data-eye-closed
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M3 3L21 21"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <path
                        d="M10.6 6.2C11.1 6.1 11.5 6 12 6C16.2 6 19.6 8.4 21.5 12C20.8 13.3 19.9 14.4 18.7 15.2"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M6.2 6.8C4.7 8 3.5 9.7 2.5 12C4.4 15.6 7.8 18 12 18C13.3 18 14.5 17.7 15.6 17.2"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M9.9 9.9C8.7 11.1 8.7 12.9 9.9 14.1C11.1 15.3 12.9 15.3 14.1 14.1"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

            </button>

        </div>

        @error('password')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>


    {{-- TOMBOL MASUK --}}
    <button type="submit" class="btn-login" data-login-button>
        <span data-button-text>Masuk</span>
    </button>

</form>