
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Tambah Donasi | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-footer.css',
        'resources/css/admin-donation-form.css',
        'resources/js/app.js',
        'resources/js/admin-donation.js',
    ])
</head>

<body class="donation-form-body">

    <main class="donation-form-page">

        {{-- ==========================================
             BREADCRUMB
        =========================================== --}}

        <nav class="donation-form__breadcrumb" aria-label="Breadcrumb">

            <a
                href="{{ route('donations.index') }}"
                class="donation-form__breadcrumb-link"
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

                <span>Data Donasi</span>
            </a>

            <svg
                class="donation-form__breadcrumb-separator"
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
                class="donation-form__breadcrumb-current"
                aria-current="page"
            >
                Tambah Donasi
            </span>

        </nav>


        {{-- ==========================================
             PAGE HEADER
        =========================================== --}}

        <header class="donation-form__header">

            <div class="donation-form__header-icon" aria-hidden="true">

                {{-- USER ROUND PLUS: SAMA DENGAN TAMBAH PENERIMA --}}

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="9" cy="8" r="3.5"/>
                    <path d="M2.5 20v-1.5a6.5 6.5 0 0 1 13 0V20"/>
                    <path d="M19 8v6"/>
                    <path d="M16 11h6"/>
                </svg>

            </div>

            <div class="donation-form__heading">

                <span class="donation-form__eyebrow">
                    ADMIN PANEL
                </span>

                <h1>Tambah Data Donasi</h1>

                <p>
                    Catat setiap amanah donatur dengan tertib,
                    akurat, dan transparan.
                </p>

            </div>

        </header>


        {{-- ==========================================
             REQUIRED INFORMATION
        =========================================== --}}

        <div class="donation-form__required-note">

            <span class="donation-form__required-symbol">
                *
            </span>

            Kolom bertanda bintang wajib diisi.

        </div>


        {{-- ==========================================
             FORM UTAMA
        =========================================== --}}

        <form
            action="{{ route('donations.store') }}"
            method="POST"
            class="donation-form"
            id="donationCreateForm"
        >

            @csrf


            {{-- ==========================================
                 VALIDATION SUMMARY
            =========================================== --}}

            @if ($errors->any())

                <div class="donation-form__alert" role="alert">

                    <div class="donation-form__alert-icon">
                        !
                    </div>

                    <div class="donation-form__alert-content">

                        <strong>
                            Data donasi belum dapat disimpan.
                        </strong>

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
                 BAGIAN 01: INFORMASI DONASI
            =========================================== --}}

            <section class="donation-form__section">

                <div class="donation-form__section-header">

                    <div class="donation-form__section-icon">

                        {{-- USER ICON: SAMA DENGAN IDENTITAS PENERIMA --}}

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

                    <div class="donation-form__section-heading">

                        <h2>Informasi Donasi</h2>

                        <p>
                            Masukkan informasi utama donasi yang diterima.
                        </p>

                    </div>

                    <span class="donation-form__step">
                        01
                    </span>

                </div>


                <div class="donation-form__grid">


                    {{-- NAMA DONATUR --}}

                    <div class="donation-form__field donation-form__field--full">

                        <label for="donor_name">

                            Nama Donatur

                            <span class="donation-form__optional">
                                Opsional
                            </span>

                        </label>

                        <input
                            type="text"
                            id="donor_name"
                            name="donor_name"
                            value="{{ old('donor_name') }}"
                            placeholder="Masukkan nama donatur"
                            autocomplete="name"
                            maxlength="255"
                            aria-describedby="donor_name_help"
                            class="@error('donor_name') is-invalid @enderror"
                        >

                        <small
                            class="donation-form__hint"
                            id="donor_name_help"
                        >
                            Nama boleh dikosongkan jika donatur ingin
                            merahasiakan identitasnya. Data akan dicatat
                            sebagai Hamba Allah.
                        </small>

                        @error('donor_name')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- TANGGAL DONASI --}}

                    <div class="donation-form__field">

                        <label for="donation_date">

                            Tanggal Donasi

                            <span class="required">*</span>

                        </label>

                        <input
                            type="date"
                            id="donation_date"
                            name="donation_date"
                            value="{{ old('donation_date', now()->format('Y-m-d')) }}"
                            required
                            class="@error('donation_date') is-invalid @enderror"
                        >

                        @error('donation_date')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- NOMINAL DONASI --}}

                    <div class="donation-form__field">

                        <label for="amount">

                            Nominal Donasi

                            <span class="required">*</span>

                        </label>

                        <div class="donation-form__amount-control">

                            <span class="donation-form__amount-prefix">
                                Rp
                            </span>

                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                value="{{ old('amount') }}"
                                placeholder="Minimal 1.000"
                                min="1000"
                                step="1"
                                inputmode="numeric"
                                oninvalid="this.setCustomValidity('Nominal donasi minimal Rp1.000.')"
                                oninput="this.setCustomValidity('')"
                                required
                                class="@error('amount') is-invalid @enderror"
                            >

                        </div>

                        <small class="donation-form__hint">
                            Masukkan nominal dalam rupiah tanpa titik atau koma.
                        </small>

                        @error('amount')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- KANAL DONASI --}}

                    <div class="donation-form__field">

                        <label for="channel">

                            Kanal Donasi

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            id="channel"
                            name="channel"
                            value="{{ old('channel') }}"
                            placeholder="Contoh: Transfer bank"
                            maxlength="255"
                            required
                            class="@error('channel') is-invalid @enderror"
                        >

                        @error('channel')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- METODE PEMBAYARAN --}}

                    <div class="donation-form__field">

                        <label for="payment_method">

                            Metode Pembayaran

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            id="payment_method"
                            name="payment_method"
                            value="{{ old('payment_method') }}"
                            placeholder="Contoh: Transfer"
                            maxlength="255"
                            required
                            class="@error('payment_method') is-invalid @enderror"
                        >

                        @error('payment_method')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- KATEGORI DONASI --}}

                    <div class="donation-form__field donation-form__field--full">

                        <label for="category">

                            Kategori Donasi

                            <span class="required">*</span>

                        </label>

                        <select
                            id="category"
                            name="category"
                            required
                            class="@error('category') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih kategori donasi
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category }}"
                                    @selected(old('category') === $category)
                                >
                                    {{ $category }}
                                </option>

                            @endforeach

                            <option
                                value="Lainnya"
                                @selected(old('category') === 'Lainnya')
                            >
                                Lainnya
                            </option>

                        </select>

                        <small class="donation-form__hint">
                            Pilih kategori yang sesuai. Pilih Lainnya
                            jika ingin menambahkan kategori baru.
                        </small>

                        @error('category')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- KATEGORI BARU --}}

                    <div
                        class="donation-form__field donation-form__field--full"
                        id="newCategoryWrapper"
                        @if (old('category') !== 'Lainnya') hidden @endif
                    >

                        <label for="new_category">

                            Nama Kategori Baru

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            id="new_category"
                            name="new_category"
                            value="{{ old('new_category') }}"
                            placeholder="Masukkan nama kategori baru"
                            maxlength="255"
                            autocomplete="off"
                            @if (old('category') === 'Lainnya') required @endif
                            class="@error('new_category') is-invalid @enderror"
                        >

                        <small class="donation-form__hint">
                            Kategori akan disimpan dan tersedia
                            untuk donasi berikutnya.
                        </small>

                        @error('new_category')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </section>


            {{-- ==========================================
                 INFORMASI AMANAH
            =========================================== --}}

            <aside class="donation-form__reminder">

                <div class="donation-form__reminder-content">

                    <h3>Jaga Amanah, Catat dengan Teliti</h3>

                    <p>
                        Pastikan tanggal, nominal, dan informasi donasi
                        sesuai dengan catatan penerimaan agar pengelolaan
                        dana masjid tetap tertib dan transparan.
                    </p>

                </div>

            </aside>


            {{-- ==========================================
                 FORM ACTIONS
            =========================================== --}}

            <div class="donation-form__actions">

                <a
                    href="{{ route('donations.index') }}"
                    class="donation-form__button donation-form__button--secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="donation-form__button donation-form__button--primary"
                    id="donationSubmitButton"
                >

                    Simpan Data Donasi

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


    {{-- ==========================================
         FOOTER GLOBAL
    =========================================== --}}

    <x-admin.footer />


</body>
</html>
