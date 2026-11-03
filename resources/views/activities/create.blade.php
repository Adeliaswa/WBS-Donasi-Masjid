<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Tambah Kegiatan | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-footer.css',
        'resources/css/admin-activity-form.css',
        'resources/js/app.js',
    ])
</head>

<body class="activity-form-body">

    <main class="activity-form-page">

        {{-- ==========================================
             BREADCRUMB
        =========================================== --}}

        <nav class="activity-form__breadcrumb" aria-label="Breadcrumb">

            <a
                href="{{ route('activities.index') }}"
                class="activity-form__breadcrumb-link"
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

                <span>Data Kegiatan</span>
            </a>

            <svg
                class="activity-form__breadcrumb-separator"
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
                class="activity-form__breadcrumb-current"
                aria-current="page"
            >
                Tambah Kegiatan
            </span>

        </nav>


        {{-- ==========================================
             PAGE HEADER
        =========================================== --}}

        <header class="activity-form__header">

            <div class="activity-form__header-icon" aria-hidden="true">

                {{-- KALENDER DENGAN TANDA TAMBAH --}}

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                    <path d="M3.5 10H20.5M8 3V6.5M16 3V6.5"/>
                    <path d="M12 13v5M9.5 15.5h5"/>
                </svg>

            </div>

            <div class="activity-form__heading">

                <span class="activity-form__eyebrow">
                    ADMIN PANEL
                </span>

                <h1>Tambah Kegiatan</h1>

                <p>
                    Catat kegiatan Masjid Sabilillah agar informasinya
                    tertata rapi dan mudah dibagikan kepada jamaah.
                </p>

            </div>

        </header>


        {{-- ==========================================
             REQUIRED INFORMATION
        =========================================== --}}

        <div class="activity-form__required-note">

            <span class="activity-form__required-symbol">
                *
            </span>

            Kolom bertanda bintang wajib diisi.

        </div>


        {{-- ==========================================
             FORM UTAMA
        =========================================== --}}

        <form
            action="{{ route('activities.store') }}"
            method="POST"
            class="activity-form"
            id="activityCreateForm"
        >

            @csrf


            {{-- ==========================================
                 VALIDATION SUMMARY
            =========================================== --}}

            @if ($errors->any())

                <div class="activity-form__alert" role="alert">

                    <div class="activity-form__alert-icon">
                        !
                    </div>

                    <div class="activity-form__alert-content">

                        <strong>
                            Data kegiatan belum dapat disimpan.
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
                 BAGIAN 01: INFORMASI KEGIATAN
            =========================================== --}}

            <section class="activity-form__section">

                <div class="activity-form__section-header">

                    <div class="activity-form__section-icon">

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

                    <div class="activity-form__section-heading">

                        <h2>Informasi Kegiatan</h2>

                        <p>
                            Masukkan judul, deskripsi, tanggal, dan status
                            publikasi kegiatan.
                        </p>

                    </div>

                    <span class="activity-form__step">
                        01
                    </span>

                </div>


                <div class="activity-form__grid">


                    {{-- JUDUL KEGIATAN --}}

                    <div class="activity-form__field activity-form__field--full">

                        <label for="title">

                            Judul Kegiatan

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Kajian Rutin Ahad Pagi"
                            maxlength="255"
                            autocomplete="off"
                            required
                            class="@error('title') is-invalid @enderror"
                        >

                        @error('title')
                            <small class="activity-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DESKRIPSI KEGIATAN --}}

                    <div class="activity-form__field activity-form__field--full">

                        <label for="description">

                            Deskripsi Kegiatan

                            <span class="required">*</span>

                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            placeholder="Jelaskan kegiatan, waktu, tempat, dan hal lain yang perlu diketahui jamaah"
                            required
                            class="@error('description') is-invalid @enderror"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <small class="activity-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- TANGGAL KEGIATAN --}}

                    <div class="activity-form__field">

                        <label for="activity_date">

                            Tanggal Kegiatan

                            <span class="required">*</span>

                        </label>

                        <input
                            type="date"
                            id="activity_date"
                            name="activity_date"
                            value="{{ old('activity_date', now()->format('Y-m-d')) }}"
                            required
                            class="@error('activity_date') is-invalid @enderror"
                        >

                        @error('activity_date')
                            <small class="activity-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- STATUS PUBLIKASI --}}

                    <div class="activity-form__field">

                        <label for="is_published">

                            Status Publikasi

                            <span class="required">*</span>

                        </label>

                        <select
                            id="is_published"
                            name="is_published"
                            required
                            class="@error('is_published') is-invalid @enderror"
                        >

                            <option
                                value="0"
                                @selected((string) old('is_published', '0') === '0')
                            >
                                Draft
                            </option>

                            <option
                                value="1"
                                @selected((string) old('is_published', '0') === '1')
                            >
                                Dipublikasikan
                            </option>

                        </select>

                        <small class="activity-form__hint">
                            Pilih Draft jika kegiatan belum siap dipublikasikan.
                        </small>

                        @error('is_published')
                            <small class="activity-form__error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </section>


            {{-- ==========================================
                 INFORMASI AMANAH
            =========================================== --}}

            <aside class="activity-form__reminder">

                <div class="activity-form__reminder-content">

                    <h3>Periksa Kembali Sebelum Menyimpan</h3>

                    <p>
                        Pastikan judul, tanggal, dan deskripsi kegiatan
                        sudah benar agar informasi yang sampai kepada
                        jamaah akurat dan jelas.
                    </p>

                </div>

            </aside>


            {{-- ==========================================
                 FORM ACTIONS
            =========================================== --}}

            <div class="activity-form__actions">

                <a
                    href="{{ route('activities.index') }}"
                    class="activity-form__button activity-form__button--secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="activity-form__button activity-form__button--primary"
                    id="activitySubmitButton"
                >

                    Simpan Kegiatan

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
         CEGAH DOUBLE SUBMIT
    =========================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('activityCreateForm');
            const button = document.getElementById('activitySubmitButton');

            if (!form || !button) {
                return;
            }

            form.addEventListener('submit', function () {
                button.disabled = true;
            });

            window.addEventListener('pageshow', function () {
                button.disabled = false;
            });

        });
    </script>

</body>
</html>