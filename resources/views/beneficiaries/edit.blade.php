<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Edit Penerima Manfaat | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-footer.css',
        'resources/css/admin-beneficiaries-form.css',
        'resources/js/app.js',
        'resources/js/admin-beneficiaries-form.js',
    ])
</head>

<body class="beneficiary-form-body">

    <main class="beneficiary-form-page">

        {{-- BREADCRUMB --}}
        <nav class="beneficiary-form__breadcrumb" aria-label="Breadcrumb">

            <a
                href="{{ route('beneficiaries.show', $beneficiary) }}"
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

                <span>Detail Penerima</span>
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
                Edit Penerima
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

                <h1>Edit Data Penerima Manfaat</h1>

                <p>
                    Perbarui identitas dan informasi penerima bantuan
                    agar data tetap akurat dan terstruktur.
                </p>

            </div>

        </header>


        {{-- REQUIRED INFORMATION --}}
        <div class="beneficiary-form__required-note">
            <span class="beneficiary-form__required-symbol">*</span>
            Kolom bertanda bintang wajib diisi.
        </div>


        {{-- CATEGORY DATA --}}
        @php

            $selectedCategoryId = old(
                'category_id',
                $beneficiary->category_id
            );

            $regularCategories = $categories
                ->filter(fn ($category) =>
                    strtolower(trim($category->name)) !== 'lainnya'
                )
                ->sortBy('name');

            $otherCategories = $categories
                ->filter(fn ($category) =>
                    strtolower(trim($category->name)) === 'lainnya'
                );

            $selectedCategory = $categories->first(
                fn ($category) =>
                    (string) $category->id === (string) $selectedCategoryId
            );

            $isOtherCategorySelected =
                strtolower(trim($selectedCategory?->name ?? '')) === 'lainnya';

        @endphp


        {{-- EDIT FORM --}}
        <form
            action="{{ route('beneficiaries.update', $beneficiary) }}"
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


            {{-- ==========================================
                 BAGIAN 01: IDENTITAS PENERIMA
            =========================================== --}}

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
                            <circle cx="12" cy="8" r="3.5"/>
                            <path d="M5 20v-1.5a7 7 0 0 1 14 0V20"/>
                        </svg>

                    </div>

                    <div class="beneficiary-form__section-heading">

                        <h2>Identitas Penerima</h2>

                        <p>
                            Periksa dan perbarui data diri serta informasi kontak penerima.
                        </p>

                    </div>

                    <span class="beneficiary-form__step">
                        01
                    </span>

                </div>


                <div class="beneficiary-form__grid">


                    {{-- NAMA PENERIMA --}}
                    <div class="beneficiary-form__field">

                        <label for="name">
                            Nama Penerima
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $beneficiary->name) }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="name"
                            maxlength="255"
                            required
                            class="@error('name') is-invalid @enderror"
                        >

                        @error('name')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- NIK --}}
                    <div class="beneficiary-form__field">

                        <label for="nik">
                            NIK
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            value="{{ old('nik', $beneficiary->nik) }}"
                            placeholder="Masukkan NIK penerima"
                            maxlength="32"
                            autocomplete="off"
                            required
                            class="@error('nik') is-invalid @enderror"
                        >

                        <small class="beneficiary-form__hint">
                            Pastikan NIK sesuai dengan identitas penerima.
                        </small>

                        @error('nik')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- ALAMAT --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="address">
                            Alamat
                            <span class="required">*</span>
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            placeholder="Masukkan alamat lengkap penerima"
                            required
                            class="@error('address') is-invalid @enderror"
                        >{{ old('address', $beneficiary->address) }}</textarea>

                        @error('address')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- NOMOR KONTAK --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="contact">
                            Nomor Kontak
                            <span class="beneficiary-form__optional">
                                Opsional
                            </span>
                        </label>

                        <input
                            type="text"
                            id="contact"
                            name="contact"
                            value="{{ old('contact', $beneficiary->contact) }}"
                            placeholder="Contoh: 08xxxxxxxxxx"
                            maxlength="255"
                            autocomplete="tel"
                            class="@error('contact') is-invalid @enderror"
                        >

                        @error('contact')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </section>


            {{-- ==========================================
                 BAGIAN 02: INFORMASI BANTUAN DAN STATUS
            =========================================== --}}

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

                        <h2>Informasi Bantuan &amp; Status</h2>

                        <p>
                            Perbarui kategori, kondisi, dan status penerima.
                        </p>

                    </div>

                    <span class="beneficiary-form__step">
                        02
                    </span>

                </div>


                <div class="beneficiary-form__grid">


                    {{-- KATEGORI PENERIMA --}}
                    <div class="beneficiary-form__field">

                        <label for="category_id">
                            Kategori Penerima
                            <span class="required">*</span>
                        </label>

                        <select
                            id="category_id"
                            name="category_id"
                            required
                            class="@error('category_id') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih kategori penerima
                            </option>

                            {{-- KATEGORI BIASA --}}
                            @foreach ($regularCategories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ (string) $selectedCategoryId === (string) $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach


                            {{-- KATEGORI LAINNYA --}}
                            @foreach ($otherCategories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ (string) $selectedCategoryId === (string) $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('category_id')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- NAMA KATEGORI LAINNYA --}}
                    <div
                        id="other-category-field"
                        class="beneficiary-form__field"
                        @if (!$isOtherCategorySelected) hidden @endif
                    >

                        <label for="other_category">
                            Nama Kategori Lainnya
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="other_category"
                            name="other_category"
                            value="{{ old('other_category', $beneficiary->other_category) }}"
                            maxlength="255"
                            placeholder="Tuliskan kategori penerima"
                            class="@error('other_category') is-invalid @enderror"
                        >

                        @error('other_category')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- KONDISI / KRITERIA --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="condition">
                            Kondisi / Kriteria
                            <span class="beneficiary-form__optional">
                                Opsional
                            </span>
                        </label>

                        <textarea
                            id="condition"
                            name="condition"
                            rows="3"
                            placeholder="Jelaskan kondisi atau kriteria penerima"
                            class="@error('condition') is-invalid @enderror"
                        >{{ old('condition', $beneficiary->condition) }}</textarea>

                        @error('condition')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- STATUS PENERIMA --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="status">
                            Status Penerima
                            <span class="required">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="@error('status') is-invalid @enderror"
                        >

                            <option
                                value="Aktif"
                                {{ old('status', $beneficiary->status) === 'Aktif' ? 'selected' : '' }}
                            >
                                Aktif
                            </option>

                            <option
                                value="Tidak Aktif"
                                {{ old('status', $beneficiary->status) === 'Tidak Aktif' ? 'selected' : '' }}
                            >
                                Tidak Aktif
                            </option>

                        </select>

                        <small class="beneficiary-form__hint">
                            Sesuaikan status dengan kondisi penerima saat ini.
                        </small>

                        @error('status')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- CATATAN TAMBAHAN --}}
                    <div class="beneficiary-form__field beneficiary-form__field--full">

                        <label for="notes">
                            Catatan Tambahan
                            <span class="beneficiary-form__optional">
                                Opsional
                            </span>
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Tambahkan catatan jika diperlukan"
                            class="@error('notes') is-invalid @enderror"
                        >{{ old('notes', $beneficiary->notes) }}</textarea>

                        @error('notes')
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
                    href="{{ route('beneficiaries.show', $beneficiary) }}"
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