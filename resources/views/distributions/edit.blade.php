
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Edit Penyaluran Bantuan | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-beneficiaries-form.css',
        'resources/css/admin-distribution-form.css',
        'resources/js/app.js'
    ])
</head>

<body class="beneficiary-form-body distribution-form-body">

    <main class="beneficiary-form-page">

        {{-- Breadcrumb --}}
        <nav class="beneficiary-form__breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('distributions.show', $distribution) }}">
                <span aria-hidden="true">←</span>
                Detail Penyaluran
            </a>

            <span class="beneficiary-form__breadcrumb-separator">/</span>

            <span aria-current="page">Edit Penyaluran</span>
        </nav>

        {{-- Header halaman --}}
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
                    <path d="M3 21h18"/>
                    <path d="M5 21V10l7-6 7 6v11"/>
                    <path d="M9 21v-6a3 3 0 0 1 6 0v6"/>
                    <path d="M12 2v2"/>
                </svg>
            </div>

            <div class="beneficiary-form__heading">
                <span class="beneficiary-form__eyebrow">
                    ADMIN PANEL · MASJID SABILILLAH
                </span>

                <h1>Edit Data Penyaluran Bantuan</h1>

                <p>
                    Perbarui informasi penyaluran bantuan agar data tetap
                    akurat, tertib, dan transparan.
                </p>
            </div>
        </header>

        {{-- Keterangan kolom wajib --}}
        <p class="beneficiary-form__required-note">
            <span aria-hidden="true">*</span>
            Kolom bertanda bintang wajib diisi.
        </p>

        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div
                class="distribution-edit-alert distribution-edit-alert--success"
                role="status"
            >
                <strong>Berhasil.</strong>
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan error validasi --}}
        @if ($errors->any())
            <div
                class="beneficiary-form__alert distribution-edit-alert--error"
                role="alert"
            >
                <strong>Perubahan belum dapat disimpan.</strong>
                <p>Periksa kembali kolom yang ditandai berikut.</p>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Konfirmasi jika duplikasi ditemukan saat menyimpan --}}
        @if (session('duplicate_warning'))
            <section
                class="distribution-edit-duplicate distribution-edit-duplicate--server"
                aria-labelledby="duplicate-warning-title"
            >
                <div class="distribution-edit-duplicate__heading">
                    <span
                        class="distribution-edit-duplicate__icon"
                        aria-hidden="true"
                    >!</span>

                    <div>
                        <h2 id="duplicate-warning-title">
                            Periksa Potensi Duplikasi
                        </h2>

                        <p>
                            Ditemukan
                            <strong>
                                {{ session('duplicate_warning.count') }}
                                catatan penyaluran
                            </strong>
                            untuk penerima ini pada bulan yang sama.
                        </p>
                    </div>
                </div>

                <div class="distribution-edit-duplicate__list-wrapper">
                    <ul class="distribution-edit-duplicate__list">
                        @foreach (session('duplicate_warning.data', []) as $item)
                            <li>
                                <span>
                                    <strong>Penerima:</strong>
                                    {{ $item['beneficiary_name'] ?? '-' }}
                                </span>

                                <span>
                                    <strong>Tanggal:</strong>
                                    {{ $item['distribution_date'] ?? '-' }}
                                </span>

                                <span>
                                    <strong>Jenis bantuan:</strong>
                                    {{ $item['assistance_type'] ?? '-' }}
                                </span>

                                <span>
                                    <strong>Nominal:</strong>
                                    Rp{{ number_format(
                                        (float) ($item['amount'] ?? 0),
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </span>

                                <span>
                                    <strong>Status:</strong>
                                    {{ $item['status'] ?? '-' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <p class="distribution-edit-duplicate__note">
                    Pastikan data tersebut bukan penyaluran yang sama
                    sebelum melanjutkan.
                </p>

                <div class="distribution-edit-duplicate__actions">
                    <a
                        href="{{ route('distributions.edit', $distribution) }}"
                        class="beneficiary-form__button beneficiary-form__button--secondary"
                    >
                        Periksa Kembali
                    </a>

                    <form
                        action="{{ route('distributions.update', $distribution) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        @foreach (old() as $key => $value)
                            @if (
                                is_scalar($value) &&
                                !in_array(
                                    $key,
                                    ['_token', '_method', 'confirm_duplicate'],
                                    true
                                )
                            )
                                <input
                                    type="hidden"
                                    name="{{ $key }}"
                                    value="{{ $value }}"
                                >
                            @endif
                        @endforeach

                        <input
                            type="hidden"
                            name="confirm_duplicate"
                            value="1"
                        >

                        <button
                            type="submit"
                            class="beneficiary-form__button beneficiary-form__button--primary distribution-edit-button--warning"
                        >
                            Tetap Simpan
                        </button>
                    </form>
                </div>
            </section>
        @endif

        {{-- Form edit penyaluran --}}
        <form
            id="edit-distribution-form"
            action="{{ route('distributions.update', $distribution) }}"
            method="POST"
            class="beneficiary-form distribution-form"
        >
            @csrf
            @method('PUT')

            {{-- Hasil pengecekan duplikasi otomatis --}}
            <div
                id="duplicate-check-result"
                class="distribution-edit-duplicate-result"
                aria-live="polite"
            ></div>

            {{-- BAGIAN 01: INFORMASI UTAMA --}}
            <section class="beneficiary-form__section">

                <div class="beneficiary-form__section-header">
                    <div
                        class="beneficiary-form__section-icon"
                        aria-hidden="true"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect x="3.5" y="5" width="17" height="16" rx="2"/>
                            <path d="M7.5 3v4M16.5 3v4M3.5 10h17"/>
                            <path d="m8.5 15 2.2 2.2 4.8-4.8"/>
                        </svg>
                    </div>

                    <div class="beneficiary-form__section-heading">
                        <h2>Informasi Utama</h2>
                        <p>Perbarui tanggal dan penerima bantuan.</p>
                    </div>

                    <span class="beneficiary-form__step">BAGIAN 01</span>
                </div>

                <div class="beneficiary-form__grid">

                    {{-- Tanggal penyaluran --}}
                    <div class="beneficiary-form__field">
                        <label for="distribution_date">
                            Tanggal Penyaluran
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            id="distribution_date"
                            name="distribution_date"
                            value="{{ old(
                                'distribution_date',
                                $distribution->distribution_date
                                    ? $distribution->distribution_date->format('Y-m-d')
                                    : ''
                            ) }}"
                            required
                            aria-describedby="distribution-date-help"
                            class="@error('distribution_date') is-invalid @enderror"
                        >

                        <small
                            id="distribution-date-help"
                            class="beneficiary-form__hint"
                        >
                            Pilih tanggal penyaluran bantuan.
                        </small>

                        @error('distribution_date')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Penerima manfaat --}}
                    <div class="beneficiary-form__field">
                        <label for="beneficiary_id">
                            Penerima Manfaat
                            <span class="required">*</span>
                        </label>

                        <select
                            id="beneficiary_id"
                            name="beneficiary_id"
                            required
                            class="@error('beneficiary_id') is-invalid @enderror"
                        >
                            <option value="">Pilih penerima manfaat</option>

                            @foreach ($beneficiaries as $beneficiary)
                                <option
                                    value="{{ $beneficiary->id }}"
                                    @selected(
                                        (string) old(
                                            'beneficiary_id',
                                            $distribution->beneficiary_id
                                        ) === (string) $beneficiary->id
                                    )
                                >
                                    {{ $beneficiary->name }}
                                </option>
                            @endforeach
                        </select>

                        <small class="beneficiary-form__hint">
                            Pilih penerima yang mendapatkan bantuan.
                        </small>

                        @error('beneficiary_id')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                </div>
            </section>

            {{-- BAGIAN 02: DETAIL BANTUAN --}}
            <section class="beneficiary-form__section">

                <div class="beneficiary-form__section-header">
                    <div
                        class="beneficiary-form__section-icon"
                        aria-hidden="true"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect x="4" y="3.5" width="16" height="17" rx="2"/>
                            <path d="M8 8h8M8 12h8M8 16h4"/>
                        </svg>
                    </div>

                    <div class="beneficiary-form__section-heading">
                        <h2>Detail Bantuan</h2>
                        <p>
                            Perbarui jenis, nominal, sumber, dan status bantuan.
                        </p>
                    </div>

                    <span class="beneficiary-form__step">BAGIAN 02</span>
                </div>

                <div class="beneficiary-form__grid">

                    {{-- Jenis bantuan --}}
                    <div class="beneficiary-form__field">
                        <label for="assistance_type">
                            Jenis Bantuan
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="assistance_type"
                            name="assistance_type"
                            value="{{ old(
                                'assistance_type',
                                $distribution->assistance_type
                            ) }}"
                            maxlength="255"
                            placeholder="Contoh: Uang, sembako, atau pendidikan"
                            required
                            class="@error('assistance_type') is-invalid @enderror"
                        >

                        <small class="beneficiary-form__hint">
                            Tuliskan jenis bantuan yang disalurkan.
                        </small>

                        @error('assistance_type')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Nominal bantuan --}}
                    <div class="beneficiary-form__field">
                        <label for="amount">
                            Nominal/Nilai Bantuan
                            <span class="required">*</span>
                        </label>

                        <div class="distribution-edit-input-group">
                            <span class="distribution-edit-input-prefix">
                                Rp
                            </span>

                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                min="10000"
                                step="1"
                                value="{{ old('amount', $distribution->amount) }}"
                                placeholder="Masukkan nominal"
                                required
                                class="@error('amount') is-invalid @enderror"
                            >
                        </div>

                        <small class="beneficiary-form__hint">
                            Masukkan nominal dalam rupiah tanpa pemisah ribuan.
                        </small>

                        @error('amount')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Sumber donasi --}}
                    <div class="beneficiary-form__field">
                        <label for="donation_id">
                            Sumber Donasi
                            <span class="beneficiary-form__optional">
                                Opsional
                            </span>
                        </label>

                        <select
                            id="donation_id"
                            name="donation_id"
                            class="@error('donation_id') is-invalid @enderror"
                        >
                            <option value="">Tanpa sumber donasi</option>

                            @foreach ($donations as $donation)
                                <option
                                    value="{{ $donation->id }}"
                                    @selected(
                                        (string) old(
                                            'donation_id',
                                            $distribution->donation_id
                                        ) === (string) $donation->id
                                    )
                                >
                                    Donasi #{{ $donation->id }}
                                    - {{ $donation->display_donor_name }}
                                </option>
                            @endforeach
                        </select>

                        <small class="beneficiary-form__hint">
                            Pilih sumber dana jika penyaluran terkait donasi tertentu.
                        </small>

                        @error('donation_id')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Status penyaluran --}}
                    <div class="beneficiary-form__field">
                        <label for="status">
                            Status Penyaluran
                            <span class="required">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="@error('status') is-invalid @enderror"
                        >
                            <option value="">Pilih status penyaluran</option>

                            @foreach (['Disalurkan', 'Diproses', 'Dibatalkan'] as $status)
                                <option
                                    value="{{ $status }}"
                                    @selected(
                                        old('status', $distribution->status) === $status
                                    )
                                >
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        <small class="beneficiary-form__hint">
                            Sesuaikan dengan kondisi penyaluran saat ini.
                        </small>

                        @error('status')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div
                        class="beneficiary-form__field beneficiary-form__field--full"
                    >
                        <label for="notes">
                            Catatan
                            <span class="beneficiary-form__optional">
                                Opsional
                            </span>
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            maxlength="1000"
                            placeholder="Tambahkan keterangan jika diperlukan..."
                            class="@error('notes') is-invalid @enderror"
                        >{{ old('notes', $distribution->notes) }}</textarea>

                        <div class="distribution-edit-field__bottom">
                            <small class="beneficiary-form__hint">
                                Tambahkan informasi pendukung jika diperlukan.
                            </small>

                            <small class="beneficiary-form__hint">
                                <span id="notes-count">{{ mb_strlen(old('notes', $distribution->notes ?? '')) }}</span>/1000 karakter
                            </small>
                        </div>

                        @error('notes')
                            <small class="beneficiary-form__error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                </div>
            </section>

            {{-- Informasi pencegahan duplikasi --}}
            <div class="distribution-edit-guidance">
                <span
                    class="distribution-edit-guidance__icon"
                    aria-hidden="true"
                >
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />
                        <path
                            d="M12 11V16M12 8H12.01"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </span>

                <div>
                    <strong>Periksa data sebelum menyimpan</strong>
                    <p>
                        Sistem akan memeriksa kemungkinan penyaluran ganda
                        untuk penerima yang sama pada bulan yang sama.
                        Periksa peringatannya jika muncul.
                    </p>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <footer class="beneficiary-form__footer">
                <a
                    href="{{ route('distributions.show', $distribution) }}"
                    class="beneficiary-form__button beneficiary-form__button--secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="beneficiary-form__button beneficiary-form__button--primary"
                >
                    Simpan Perubahan
                    <span aria-hidden="true">→</span>
                </button>
            </footer>

        </form>

        {{-- Footer halaman --}}
        <p class="beneficiary-form__footer-note">
            Masjid Sabilillah <span>•</span> Admin Panel
        </p>

    </main>

    {{-- Pengecekan duplikasi penyaluran --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('edit-distribution-form');
            const dateInput = document.getElementById('distribution_date');
            const beneficiaryInput = document.getElementById('beneficiary_id');
            const result = document.getElementById('duplicate-check-result');
            const notesInput = document.getElementById('notes');
            const notesCount = document.getElementById('notes-count');

            if (!form || !dateInput || !beneficiaryInput || !result) {
                return;
            }

            const tokenInput = form.querySelector('[name="_token"]');

            if (!tokenInput) {
                return;
            }

            const csrfToken = tokenInput.value;
            const distributionId = @json($distribution->id);
            const checkUrl = @json(route('distributions.check-duplicates'));

            let timeout;
            let requestNumber = 0;

            function clearResult() {
                result.replaceChildren();
                result.className = 'distribution-edit-duplicate-result';
            }

            function showMessage(message) {
                result.replaceChildren();

                result.className =
                    'distribution-edit-duplicate-result ' +
                    'distribution-edit-alert distribution-edit-alert--info';

                const paragraph = document.createElement('p');
                paragraph.textContent = message;

                result.appendChild(paragraph);
            }

            function showDuplicates(data) {
                result.replaceChildren();

                result.className =
                    'distribution-edit-duplicate-result ' +
                    'distribution-edit-duplicate';

                const headingWrapper = document.createElement('div');
                headingWrapper.className =
                    'distribution-edit-duplicate__heading';

                const icon = document.createElement('span');
                icon.className = 'distribution-edit-duplicate__icon';
                icon.setAttribute('aria-hidden', 'true');
                icon.textContent = '!';

                const headingContent = document.createElement('div');

                const heading = document.createElement('h3');
                heading.textContent =
                    'Peringatan: Potensi Duplikasi Penyaluran';

                const description = document.createElement('p');
                description.textContent =
                    `Ditemukan ${data.count} catatan penyaluran ` +
                    'untuk penerima ini pada bulan yang sama.';

                headingContent.append(heading, description);
                headingWrapper.append(icon, headingContent);
                result.appendChild(headingWrapper);

                const list = document.createElement('ul');
                list.className = 'distribution-edit-duplicate__list';

                if (Array.isArray(data.data)) {
                    data.data.forEach(function (item) {
                        const listItem = document.createElement('li');

                        listItem.textContent =
                            `Penerima: ${item.beneficiary_name ?? '-'} | ` +
                            `Tanggal: ${item.distribution_date ?? '-'} | ` +
                            `Jenis bantuan: ${item.assistance_type ?? '-'} | ` +
                            `Nominal: Rp${Number(item.amount ?? 0).toLocaleString('id-ID')} | ` +
                            `Status: ${item.status ?? '-'}`;

                        list.appendChild(listItem);
                    });
                }

                result.appendChild(list);

                const note = document.createElement('p');
                note.className = 'distribution-edit-duplicate__note';
                note.textContent =
                    'Periksa catatan di atas sebelum menyimpan perubahan.';

                result.appendChild(note);
            }

            async function checkDuplicates() {
                clearTimeout(timeout);

                const currentRequest = ++requestNumber;
                const date = dateInput.value;
                const beneficiaryId = beneficiaryInput.value;

                if (!date || !beneficiaryId) {
                    clearResult();
                    return;
                }

                timeout = setTimeout(async function () {
                    showMessage('Memeriksa potensi duplikasi penyaluran...');

                    try {
                        const response = await fetch(checkUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                distribution_date: date,
                                beneficiary_id: beneficiaryId,
                                distribution_id: distributionId
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Pengecekan duplikasi gagal.');
                        }

                        const data = await response.json();

                        // Abaikan respons lama jika input telah berubah.
                        if (currentRequest !== requestNumber) {
                            return;
                        }

                        if (data.has_duplicates) {
                            showDuplicates(data);
                        } else {
                            clearResult();
                        }
                    } catch (error) {
                        if (currentRequest === requestNumber) {
                            showMessage(
                                'Pengecekan duplikasi gagal. ' +
                                'Silakan coba kembali sebelum menyimpan.'
                            );
                        }
                    }
                }, 300);
            }

            dateInput.addEventListener('change', checkDuplicates);
            beneficiaryInput.addEventListener('change', checkDuplicates);

            // Penghitung karakter catatan.
            if (notesInput && notesCount) {
                function updateNotesCount() {
                    notesCount.textContent = notesInput.value.length;
                }

                notesInput.addEventListener('input', updateNotesCount);
                updateNotesCount();
            }

            // Periksa tanggal dan penerima yang sudah terisi.
            checkDuplicates();
        });
    </script>

</body>
</html>
