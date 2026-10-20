<!DOCTYPE html>
<html lang="id">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">




    <title>Tambah Donasi | Masjid Sabilillah</title>




    @vite([
        'resources/css/app.css',
        'resources/css/admin-donation-form.css'
    ])


    <style>
        /* Halaman Tambah Donasi berdiri sendiri tanpa layout/sidebar admin. */
        body.donation-form-body {
            display: block !important;
            width: 100%;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        body.donation-form-body > .admin-main {
            display: block !important;
            width: 100% !important;
            max-width: none !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
        }
        body.donation-form-body .donation-form-page {
            width: min(100% - 32px, 1120px);
            max-width: 1120px;
            margin: 0 auto;
            padding: 32px 0 24px;
            box-sizing: border-box;
        }
        @media (max-width: 640px) {
            body.donation-form-body .donation-form-page {
                width: calc(100% - 24px);
                padding-top: 20px;
            }
        }
    </style>


</head>




<body class="donation-form-body">




    {{-- Konten utama: sama seperti halaman Data Donasi --}}
    <div class="admin-main">


        <main class="donation-form-page">




                {{-- Breadcrumb navigasi --}}
        <nav class="donation-form-breadcrumb" aria-label="Breadcrumb">


            <a
                href="{{ route('donations.index') }}"
                class="donation-form-breadcrumb__link"
            >
                <span aria-hidden="true">&larr;</span>
                Data Donasi
            </a>


            <span
                class="donation-form-breadcrumb__separator"
                aria-hidden="true"
            >
                /
            </span>


            <span
                class="donation-form-breadcrumb__current"
                aria-current="page"
            >
                Tambah Donasi
            </span>


        </nav>




                {{-- Header halaman --}}
                <header class="donation-form-header">




                    <div class="donation-form-header__content">




                        <div class="donation-form-header__icon" aria-hidden="true">
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




                        <div>
                            <span class="donation-form-header__eyebrow">
                                ADMIN PANEL · MASJID SABILILLAH
                            </span>




                            <h1 class="donation-form-header__title">
                                Tambah Data Donasi
                            </h1>




                            <p class="donation-form-header__description">
                                Catat setiap amanah donatur dengan tertib,
                                akurat, dan transparan.
                            </p>
                        </div>




                    </div>




                    <div class="donation-form-header__ornament" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>




                </header>




                {{-- Notifikasi validasi --}}
                @if ($errors->any())
                    <div class="donation-form-alert" role="alert">




                        <div class="donation-form-alert__icon" aria-hidden="true">
                            !
                        </div>




                        <div>
                            <strong>Periksa kembali data yang dimasukkan.</strong>




                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>




                    </div>
                @endif




                {{-- Keterangan wajib --}}
                <div class="donation-form-note">
                    <span class="donation-form-note__mark" aria-hidden="true">*</span>




                    <span>
                        Kolom bertanda bintang wajib diisi.
                    </span>
                </div>




                {{-- Form utama --}}
                <form
                    action="{{ route('donations.store') }}"
                    method="POST"
                    class="donation-form"
                    id="donationCreateForm"
                >
                    @csrf




                    <section class="donation-form-card">




                        <div class="donation-form-card__header">




                            <div class="donation-form-card__heading">




                                <div class="donation-form-card__icon" aria-hidden="true">
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                                        <path d="M8 8h8"/>
                                        <path d="M8 12h8"/>
                                        <path d="M8 16h4"/>
                                    </svg>
                                </div>




                                <div>
                                    <h2>Informasi Donasi</h2>
                                    <p>Masukkan informasi utama donasi yang diterima.</p>
                                </div>




                            </div>




                            <span class="donation-form-card__step">
                                BAGIAN 01
                            </span>




                        </div>




                        <div class="donation-form-grid">




                            {{-- Nama donatur --}}
                            <div class="donation-field donation-field--full">
                                <label for="donor_name">
                                    Nama Donatur
                                    <span class="donation-field__optional">Opsional</span>
                                </label>




                                <div class="donation-field__control">
                                    <span class="donation-field__icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                                        </svg>
                                    </span>




                                    <input
                                        type="text"
                                        id="donor_name"
                                        name="donor_name"
                                        value="{{ old('donor_name') }}"
                                        placeholder="Kosongkan jika ingin menjadi Hamba Allah"
                                        autocomplete="name"
                                        aria-describedby="donor_name_help"
                                    >
                                </div>




                                <small class="donation-field__help" id="donor_name_help">
                                    Nama boleh dikosongkan jika donatur ingin merahasiakan identitasnya.
                                </small>




                                @error('donor_name')
                                    <small class="donation-field__error">{{ $message }}</small>
                                @enderror
                            </div>




                            {{-- Tanggal donasi --}}
                            <div class="donation-field">
                                <label for="donation_date">
                                    Tanggal Donasi
                                    <span class="donation-field__required">*</span>
                                </label>




                                <div class="donation-field__control">
                                    <span class="donation-field__icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="16" rx="2"/>
                                            <path d="M16 3v4"/>
                                            <path d="M8 3v4"/>
                                            <path d="M3 10h18"/>
                                        </svg>
                                    </span>




                                    <input
                                        type="date"
                                        id="donation_date"
                                        name="donation_date"
                                        value="{{ old('donation_date', now()->format('Y-m-d')) }}"
                                        required
                                    >
                                </div>




                                @error('donation_date')
                                    <small class="donation-field__error">{{ $message }}</small>
                                @enderror
                            </div>




                            {{-- Nominal donasi --}}
                            <div class="donation-field">
                                <label for="amount">
                                    Nominal Donasi
                                    <span class="donation-field__required">*</span>
                                </label>




                                <div class="donation-field__control donation-field__control--amount">
                                    <span class="donation-field__prefix">Rp</span>




                                    <input
                                        type="number"
                                        id="amount"
                                        name="amount"
                                        value="{{ old('amount') }}"
                                        placeholder="Contoh: 100000"
                                        min="1"
                                        step="1"
                                        inputmode="numeric"
                                        required
                                    >
                                </div>




                                <small class="donation-field__help">
                                    Masukkan nominal dalam rupiah tanpa titik atau koma.
                                </small>




                                @error('amount')
                                    <small class="donation-field__error">{{ $message }}</small>
                                @enderror
                            </div>




                            {{-- Kanal donasi --}}
                            <div class="donation-field">
                                <label for="channel">
                                    Kanal Donasi
                                    <span class="donation-field__required">*</span>
                                </label>




                                <div class="donation-field__control">
                                    <span class="donation-field__icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                                            <path d="M3 10h18"/>
                                            <path d="M7 15h3"/>
                                        </svg>
                                    </span>




                                    <input
                                        type="text"
                                        id="channel"
                                        name="channel"
                                        value="{{ old('channel') }}"
                                        placeholder="Contoh: Transfer bank"
                                        required
                                    >
                                </div>




                                @error('channel')
                                    <small class="donation-field__error">{{ $message }}</small>
                                @enderror
                            </div>




                            {{-- Metode pembayaran --}}
                            <div class="donation-field">
                                <label for="payment_method">
                                    Metode Pembayaran
                                    <span class="donation-field__required">*</span>
                                </label>




                                <div class="donation-field__control">
                                    <span class="donation-field__icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2.5" y="5" width="19" height="14" rx="2"/>
                                            <path d="M2.5 10h19"/>
                                            <path d="M7 15h3"/>
                                        </svg>
                                    </span>




                                    <input
                                        type="text"
                                        id="payment_method"
                                        name="payment_method"
                                        value="{{ old('payment_method') }}"
                                        placeholder="Contoh: Transfer"
                                        required
                                    >
                                </div>




                                @error('payment_method')
                                    <small class="donation-field__error">{{ $message }}</small>
                                @enderror
                            </div>




                            {{-- Kategori donasi --}}
                            <div class="donation-field donation-field--full">
                                <label for="category">
                                    Kategori Donasi
                                    <span class="donation-field__required">*</span>
                                </label>

                                <div class="donation-field__control">
                                    <span class="donation-field__icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h7v7H4z"/>
                                            <path d="M13 4h7v7h-7z"/>
                                            <path d="M4 13h7v7H4z"/>
                                            <path d="M13 13h7v7h-7z"/>
                                        </svg>
                                    </span>

                                    <select id="category" name="category" required>
                                        <option value="">-- Pilih Kategori Donasi --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" @selected(old('category') === $category)>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                        <option value="Lainnya" @selected(old('category') === 'Lainnya')>Lainnya</option>
                                    </select>
                                </div>

                                <small class="donation-field__help">
                                    Pilih kategori yang sesuai. Pilih Lainnya jika ingin menambahkan kategori baru.
                                </small>

                                @error('category')
                                    <small class="donation-field__error">{{ $message }}</small>
                                @enderror

                                <div class="donation-field donation-field--full" id="newCategoryWrapper" style="display: none; margin-top: 16px;">
                                    <label for="new_category">
                                        Nama Kategori Baru
                                        <span class="donation-field__required">*</span>
                                    </label>
                                    <div class="donation-field__control">
                                        <input
                                            type="text"
                                            id="new_category"
                                            name="new_category"
                                            value="{{ old('new_category') }}"
                                            placeholder="Masukkan nama kategori baru"
                                            maxlength="255"
                                            autocomplete="off"
                                        >
                                    </div>
                                    <small class="donation-field__help">
                                        Kategori akan disimpan dan tersedia untuk donasi berikutnya.
                                    </small>
                                    @error('new_category')
                                        <small class="donation-field__error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>




                        </div>
                    </section>




                    {{-- Panel informasi amanah --}}
                    <aside class="donation-form-reminder">
                        <div class="donation-form-reminder__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7l-8-4z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </div>




                        <div>
                            <h3>Jaga Amanah, Catat dengan Teliti</h3>




                            <p>
                                Pastikan tanggal, nominal, dan informasi donasi
                                sesuai dengan catatan penerimaan agar pengelolaan
                                dana masjid tetap tertib dan transparan.
                            </p>
                        </div>
                    </aside>




                    {{-- Tombol aksi --}}
                    <footer class="donation-form-footer">
                        <a
                            href="{{ route('donations.index') }}"
                            class="donation-form-button donation-form-button--secondary"
                        >
                            Batal
                        </a>




                        <button
                            type="submit"
                            class="donation-form-button donation-form-button--primary"
                            id="donationSubmitButton"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 3h12l4 4v14H3V3z"/>
                                <path d="M7 3v6h10V3"/>
                                <path d="M7 21v-8h10v8"/>
                            </svg>




                            Simpan Data Donasi
                        </button>
                    </footer>




                </form>




                <p class="donation-form-page__footer">
                    Masjid Sabilillah
                    <span aria-hidden="true">·</span>
                    Panel Administrasi
                </p>


        </div>


        </main>


    </div>




    @vite([
        'resources/js/admin-donation-form.js'
    ])

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category');
            const newCategoryWrapper = document.getElementById('newCategoryWrapper');
            const newCategoryInput = document.getElementById('new_category');

            function toggleNewCategory() {
                const isOther = categorySelect.value === 'Lainnya';
                newCategoryWrapper.style.display = isOther ? 'block' : 'none';
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