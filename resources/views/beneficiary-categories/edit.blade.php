
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Edit Kategori Penerima | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/beneficiary-category-form.css',
        'resources/js/beneficiary-category-form.js',
    ])
</head>

<body class="beneficiary-category-form-body">

    <main class="beneficiary-category-form-page">

        {{-- Breadcrumb --}}
        <nav class="beneficiary-category-form__breadcrumb"
             aria-label="Breadcrumb">

            <a href="{{ route('beneficiary-categories.index') }}"
               class="beneficiary-category-form__breadcrumb-back">

                <span class="beneficiary-category-form__breadcrumb-arrow"
                      aria-hidden="true">←</span>

                <span>Kategori Penerima</span>
            </a>

            <span class="beneficiary-category-form__breadcrumb-separator"
                  aria-hidden="true">/</span>

            <span class="beneficiary-category-form__breadcrumb-current"
                  aria-current="page">
                Edit Kategori
            </span>

        </nav>

        {{-- Header --}}
        <header class="beneficiary-category-form__header">

            <div class="beneficiary-category-form__header-icon"
                aria-hidden="true">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M3 21h18"/>
                    <path d="M5 21V10l7-6 7 6v11"/>
                    <path d="M9 21v-6a3 3 0 0 1 6 0v6"/>
                    <path d="M12 2v2"/>
                </svg>
            </div>

            <div class="beneficiary-category-form__heading">

                <span class="beneficiary-category-form__eyebrow">
                    ADMIN PANEL · MASJID SABILILLAH
                </span>

                <h1>Edit Kategori Penerima Manfaat</h1>

                <p>
                    Perbarui informasi kategori penerima bantuan agar
                    pengelolaan data tetap akurat dan terstruktur.
                </p>

            </div>

        </header>

        {{-- Keterangan kolom wajib --}}
        <p class="beneficiary-category-form__required-note">
            <span aria-hidden="true">*</span>
            Kolom bertanda bintang wajib diisi.
        </p>

        {{-- Pesan kesalahan --}}
        @if ($errors->any())
            <div class="beneficiary-category-form__alert beneficiary-category-form__alert--error"
                 role="alert">

                <strong>Perubahan belum dapat disimpan.</strong>

                <p>Periksa kembali data yang kamu masukkan.</p>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- Form Edit --}}
        <form
            action="{{ route('beneficiary-categories.update', $beneficiaryCategory) }}"
            method="POST"
            class="beneficiary-category-form"
        >

            @csrf
            @method('PUT')

            <section class="beneficiary-category-form__card"
                     aria-labelledby="category-section-title">

                {{-- Header bagian --}}
                <div class="beneficiary-category-form__card-header">

                    <div class="beneficiary-category-form__section-icon"
                         aria-hidden="true">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.7"
                             stroke-linecap="round"
                             stroke-linejoin="round">

                            <path d="M4 5.5h16v13H4z"/>
                            <path d="M8 9h8M8 13h5"/>
                            <path d="M8 2.5v3M16 2.5v3"/>

                        </svg>

                    </div>

                    <div class="beneficiary-category-form__section-heading">

                        <h2 id="category-section-title">
                            Informasi Kategori
                        </h2>

                        <p>
                            Periksa dan perbarui informasi kategori yang tersimpan.
                        </p>

                    </div>

                    <span class="beneficiary-category-form__step">
                        BAGIAN 1
                    </span>

                </div>

                {{-- Isi form --}}
                <div class="beneficiary-category-form__body">

                    <div class="beneficiary-category-form__grid">

                        {{-- Nama kategori --}}
                        <div class="beneficiary-category-form__field beneficiary-category-form__field--full">

                            <label for="name">
                                Nama Kategori
                                <span class="required" aria-hidden="true">*</span>
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
                                class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                @if ($errors->has('name'))
                                    aria-invalid="true"
                                    aria-describedby="name-error"
                                @endif
                            >

                            <span class="beneficiary-category-form__hint">
                                Masukkan nama kategori yang jelas dan mudah dikenali.
                            </span>

                            @error('name')
                                <span id="name-error"
                                      class="beneficiary-category-form__error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        {{-- Deskripsi --}}
                        <div class="beneficiary-category-form__field beneficiary-category-form__field--full">

                            <label for="description">
                                Deskripsi Kategori
                                <span class="beneficiary-category-form__optional">
                                    Opsional
                                </span>
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                maxlength="1000"
                                placeholder="Jelaskan kriteria atau keterangan kategori penerima manfaat..."
                                class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                                @if ($errors->has('description'))
                                    aria-invalid="true"
                                    aria-describedby="description-error"
                                @endif
                            >{{ old('description', $beneficiaryCategory->description ?? '') }}</textarea>

                            <div class="beneficiary-category-form__field-meta">

                                <span class="beneficiary-category-form__hint">
                                    Berikan keterangan tambahan jika diperlukan.
                                </span>

                                <span class="beneficiary-category-form__counter"
                                      id="description-counter"
                                      aria-live="off">0/1000</span>

                            </div>

                            @error('description')
                                <span id="description-error"
                                      class="beneficiary-category-form__error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>

                {{-- Tombol --}}
                <div class="beneficiary-category-form__footer">

                    <a href="{{ route('beneficiary-categories.index') }}"
                       class="beneficiary-category-form__button beneficiary-category-form__button--secondary">
                        Batal
                    </a>

                    <button type="submit"
                            class="beneficiary-category-form__button beneficiary-category-form__button--primary">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             aria-hidden="true">

                            <path d="m5 12 4 4L19 6"/>

                        </svg>

                        Simpan Perubahan

                    </button>

                </div>

            </section>

        </form>

        <p class="beneficiary-category-form__footer-note">
            Masjid Sabilillah
            <span aria-hidden="true">•</span>
            Pengelolaan Data Penerima Manfaat
        </p>

    </main>

</body>
</html>
