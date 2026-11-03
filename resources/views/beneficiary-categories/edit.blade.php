
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Edit Kategori Penerima | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-footer.css',
        'resources/css/beneficiary-category-form.css',
        'resources/js/app.js',
        'resources/js/beneficiary-category-form.js',
    ])
</head>

<body class="beneficiary-form-body">

    <main class="beneficiary-form-page">

        {{-- BREADCRUMB --}}
        <nav class="beneficiary-form__breadcrumb" aria-label="Breadcrumb">

            <a
                href="{{ route('beneficiary-categories.index') }}"
                class="beneficiary-form__breadcrumb-link"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M19 12H5"/>
                    <path d="m12 19-7-7 7-7"/>
                </svg>

                <span>Kategori Penerima</span>
            </a>

            <svg
                class="beneficiary-form__breadcrumb-separator"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.7"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="m9 18 6-12"/>
            </svg>

            <span
                class="beneficiary-form__breadcrumb-current"
                aria-current="page"
            >
                Edit Kategori
            </span>

        </nav>

        {{-- PAGE HEADER --}}
        <header class="beneficiary-form__header">

            <div class="beneficiary-form__header-icon" aria-hidden="true">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L9 17l-4 1 1-4Z"/>
                    <path d="m15 5 4 4"/>
                </svg>

            </div>

            <div class="beneficiary-form__heading">

                <span class="beneficiary-form__eyebrow">
                    ADMIN PANEL
                </span>

                <h1>Edit Kategori Penerima Manfaat</h1>

                <p>
                    Perbarui informasi kategori penerima bantuan agar
                    pengelolaan data tetap akurat dan terstruktur.
                </p>

            </div>

        </header>

        {{-- REQUIRED INFORMATION --}}
        <div class="beneficiary-form__required-note">
            <span class="beneficiary-form__required-symbol">*</span>
            Kolom bertanda bintang wajib diisi.
        </div>

        {{-- EDIT FORM --}}
        <form
            action="{{ route('beneficiary-categories.update', $beneficiaryCategory) }}"
            method="POST"
            class="beneficiary-form"
        >
            @csrf
            @method('PUT')

            {{-- VALIDATION SUMMARY --}}
            @if ($errors->any())

                <div class="beneficiary-form__alert" role="alert">

                    <div class="beneficiary-form__alert-icon">
                        !
                    </div>

                    <div class="beneficiary-form__alert-content">

                        <strong>Perubahan belum dapat disimpan.</strong>

                        <p>
                            Periksa kembali beberapa kolom berikut.
                        </p>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            @endif

            {{-- BAGIAN 01: INFORMASI KATEGORI --}}
            <section class="beneficiary-form__section">

                <div class="beneficiary-form__section-header">

                    <div class="beneficiary-form__section-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                            <path d="M8 9h8M8 13h8M8 17h4"/>
                        </svg>

                    </div>

                    <div class="beneficiary-form__section-heading">

                        <h2>Informasi Kategori</h2>

                        <p>
                            Periksa dan perbarui informasi kategori yang tersimpan.
                        </p>

                    </div>

                    <span class="beneficiary-form__step">
                        01
                    </span>

                </div>

                <div class="beneficiary-form__grid">

                    {{-- NAMA KATEGORI --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="name">
                            Nama Kategori
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $beneficiaryCategory->name) }}"
                            placeholder="Contoh: Fakir Miskin"
                            maxlength="255"
                            autocomplete="off"
                            required
                            class="@error('name') is-invalid @enderror"
                        >

                        <small class="beneficiary-form__hint">
                            Masukkan nama kategori yang jelas dan mudah dikenali.
                        </small>

                        @error('name')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- DESKRIPSI KATEGORI --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="description">
                            Deskripsi Kategori
                            <span class="beneficiary-form__optional">
                                Opsional
                            </span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            maxlength="1000"
                            placeholder="Jelaskan kriteria atau keterangan kategori penerima manfaat..."
                            class="@error('description') is-invalid @enderror"
                        >{{ old('description', $beneficiaryCategory->description ?? '') }}</textarea>

                        <small class="beneficiary-form__hint">
                            Berikan keterangan tambahan jika diperlukan.
                        </small>

                        @error('description')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </section>

            {{-- FORM ACTIONS --}}
            <div class="beneficiary-form__actions">

                <a
                    href="{{ route('beneficiary-categories.index') }}"
                    class="beneficiary-form__button beneficiary-form__button--secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="beneficiary-form__button beneficiary-form__button--primary"
                >
                    Simpan Perubahan

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                </button>

            </div>

        </form>

    </main>

    {{-- FOOTER GLOBAL --}}
    <x-admin.footer />

</body>
</html>
