
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Edit Donasi | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-footer.css',
        'resources/css/admin-donation-form.css',
        'resources/js/app.js',
        'resources/js/admin-donation.js',
        'resources/js/admin-donation-form.js',
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
                Edit Donasi
            </span>

        </nav>


        {{-- ==========================================
             PAGE HEADER
        =========================================== --}}

        <header class="donation-form__header">

            <div class="donation-form__header-icon" aria-hidden="true">

                {{-- IKON EDIT SAMA DENGAN EDIT PENERIMA --}}

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

            <div class="donation-form__heading">

                <span class="donation-form__eyebrow">
                    ADMIN PANEL
                </span>

                <h1>Edit Data Donasi</h1>

                <p>
                    Perbarui informasi donasi yang telah tersimpan
                    agar data tetap akurat dan terstruktur.
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
             FORM EDIT DONASI
        =========================================== --}}

        <form
            action="{{ route('donations.update', $donation) }}"
            method="POST"
            class="donation-form"
            id="donationEditForm"
        >

            @csrf
            @method('PUT')


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
                            Perubahan belum dapat disimpan.
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

                        {{-- IKON SECTION GAYA EDIT PENERIMA --}}

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

                    <div class="donation-form__section-heading">

                        <h2>Informasi Donasi</h2>

                        <p>
                            Periksa dan perbarui informasi utama donasi yang diterima.
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
                            value="{{ old('donor_name', $donation->donor_name) }}"
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
                            value="{{ old(
                                'donation_date',
                                $donation->donation_date instanceof \Carbon\Carbon
                                    ? $donation->donation_date->format('Y-m-d')
                                    : \Carbon\Carbon::parse($donation->donation_date)->format('Y-m-d')
                            ) }}"
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
                                value="{{ old('amount', (int) $donation->amount) }}"
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
                            value="{{ old('channel', $donation->channel) }}"
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
                            value="{{ old('payment_method', $donation->payment_method) }}"
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
                                    @selected(
                                        old('category', $donation->category) === $category
                                    )
                                >
                                    {{ $category }}
                                </option>

                            @endforeach

                            <option
                                value="Lainnya"
                                @selected(
                                    old('category', $donation->category) === 'Lainnya'
                                )
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
                        @if (old('category', $donation->category) !== 'Lainnya') hidden @endif
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
                            @if (old('category', $donation->category) === 'Lainnya') required @endif
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


                    {{-- STATUS VERIFIKASI --}}

                    <div class="donation-form__field donation-form__field--full">

                        <label for="verification_status">

                            Status Verifikasi

                            <span class="required">*</span>

                        </label>

                        <select
                            id="verification_status"
                            name="verification_status"
                            required
                            class="@error('verification_status') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih status verifikasi
                            </option>

                            <option
                                value="pending"
                                @selected(
                                    old('verification_status', $donation->verification_status) === 'pending'
                                )
                            >
                                Menunggu Verifikasi
                            </option>

                            <option
                                value="verified"
                                @selected(
                                    old('verification_status', $donation->verification_status) === 'verified'
                                )
                            >
                                Terverifikasi
                            </option>

                            <option
                                value="rejected"
                                @selected(
                                    old('verification_status', $donation->verification_status) === 'rejected'
                                )
                            >
                                Ditolak
                            </option>

                        </select>

                        @error('verification_status')
                            <small class="donation-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- CATATAN --}}

                    <div class="donation-form__field donation-form__field--full">

                        <label for="notes">

                            Catatan

                            <span class="donation-form__optional">
                                Opsional
                            </span>

                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Tambahkan catatan jika diperlukan"
                            class="@error('notes') is-invalid @enderror"
                        >{{ old('notes', $donation->notes) }}</textarea>

                        @error('notes')
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


    {{-- ==========================================
         FOOTER GLOBAL
    =========================================== --}}

    <x-admin.footer />


    {{-- ==========================================
         KATEGORI LAINNYA
    =========================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const categorySelect = document.getElementById('category');
            const newCategoryWrapper = document.getElementById('newCategoryWrapper');
            const newCategoryInput = document.getElementById('new_category');

            if (!categorySelect || !newCategoryWrapper || !newCategoryInput) {
                return;
            }

            function toggleNewCategory() {

                const isOther = categorySelect.value === 'Lainnya';

                newCategoryWrapper.hidden = !isOther;
                newCategoryInput.required = isOther;

                if (!isOther) {
                    newCategoryInput.value = '';
                }

            }

            categorySelect.addEventListener('change', toggleNewCategory);

            toggleNewCategory();

        });
    </script>

</body>
</html>
