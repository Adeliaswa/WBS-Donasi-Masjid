<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#294236">

    <title>Penyaluran Bantuan | Masjid Sabilillah</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin-sidebar.css',
        'resources/css/admin-distributions.css',
        'resources/js/admin-sidebar.js',
        'resources/js/admin-distributions.js'
    ])
</head>

<body class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        {{-- HEADER MOBILE --}}
        <div class="admin-mobile-header">
            <button
                type="button"
                class="admin-sidebar-toggle"
                id="openSidebar"
                aria-label="Buka menu navigasi"
                aria-controls="adminSidebar"
                aria-expanded="false"
            >
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M4 6H20M4 12H20M4 18H20"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    />
                </svg>
            </button>

            <div class="admin-mobile-header__identity">
                <span class="admin-mobile-header__title">Masjid Sabilillah</span>
                <span class="admin-mobile-header__subtitle">Panel Administrasi</span>
            </div>
        </div>

        <main class="distribution-index-page">

            {{-- HEADER HALAMAN --}}
            <header class="distribution-index-header">
                <div class="distribution-index-header__content">
                    <span class="distribution-index-header__eyebrow">
                        MASJID SABILILLAH
                    </span>

                    <h1 class="distribution-index-header__title">
                        Penyaluran Bantuan
                    </h1>

                    <p class="distribution-index-header__description">
                        Kelola penyaluran bantuan kepada penerima manfaat
                        secara tertib, tepat sasaran, dan transparan.
                    </p>
                </div>

                <a
                    href="#distribution-create-panel"
                    class="distribution-button distribution-button--primary"
                >
                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" aria-hidden="true">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Penyaluran
                </a>
            </header>


            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="distribution-alert distribution-alert--success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="distribution-alert distribution-alert--warning" role="status">
                    {{ session('warning') }}
                </div>
            @endif

            @if (session('error'))
                <div class="distribution-alert distribution-alert--error" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="distribution-alert distribution-alert--error" role="alert">
                    <div>
                        <strong>Data belum dapat disimpan.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif


            {{-- PERINGATAN DUPLIKASI --}}
            @if (session('duplicate_warning'))
                <section class="distribution-duplicate-confirmation">
                    <div class="distribution-duplicate-confirmation__header">
                        <span class="distribution-duplicate-confirmation__icon">!</span>

                        <div>
                            <h2>Peringatan Potensi Duplikasi</h2>
                            <p>
                                Ditemukan
                                <strong>{{ session('duplicate_warning.count') }}</strong>
                                catatan penyaluran untuk penerima ini pada bulan yang sama.
                            </p>
                        </div>
                    </div>

                    <div class="distribution-duplicate-confirmation__table-wrap">
                        <table class="distribution-duplicate-confirmation__table">
                            <thead>
                                <tr>
                                    <th>Penerima</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Bantuan</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('duplicate_warning.data') as $item)
                                    <tr>
                                        <td>{{ $item['beneficiary_name'] }}</td>
                                        <td>{{ $item['distribution_date'] }}</td>
                                        <td>{{ $item['assistance_type'] }}</td>
                                        <td>
                                            Rp{{ number_format((float) $item['amount'], 0, ',', '.') }}
                                        </td>
                                        <td>{{ $item['status'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="distribution-duplicate-confirmation__question">
                        Apakah kamu tetap ingin menyimpan penyaluran ini?
                    </p>

                    <form
                        action="{{ route('distributions.store') }}"
                        method="POST"
                        class="distribution-duplicate-confirmation__actions"
                    >
                        @csrf

                        @foreach (old() as $key => $value)
                            @if (is_scalar($value) && $key !== '_token' && $key !== '_method')
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <input type="hidden" name="confirm_duplicate" value="1">

                        <a
                            href="{{ route('distributions.index') }}"
                            class="distribution-button distribution-button--secondary"
                        >
                            Periksa Kembali
                        </a>

                        <button
                            type="submit"
                            class="distribution-button distribution-button--warning"
                        >
                            Tetap Simpan
                        </button>
                    </form>
                </section>
            @endif


            {{-- RINGKASAN --}}
            <section class="distribution-summary" aria-label="Ringkasan penyaluran">

                <article class="distribution-summary__card">
                    <div class="distribution-summary__top">
                        <span class="distribution-summary__icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path d="M8 9h8M8 13h8M8 17h4"/>
                            </svg>
                        </span>
                        <span class="distribution-summary__label">Total Penyaluran</span>
                    </div>

                    <strong class="distribution-summary__value">
                        {{ number_format((int) ($summary['total'] ?? 0), 0, ',', '.') }}
                    </strong>

                    <p class="distribution-summary__description">
                        Seluruh catatan penyaluran bantuan.
                    </p>
                </article>

                <article class="distribution-summary__card">
                    <div class="distribution-summary__top">
                        <span class="distribution-summary__icon distribution-summary__icon--green">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="m8 12 2.5 2.5L16 9"/>
                            </svg>
                        </span>
                        <span class="distribution-summary__label">Penyaluran Bulan Ini</span>
                    </div>

                    <strong class="distribution-summary__value">
                        {{ number_format((int) ($summary['this_month'] ?? 0), 0, ',', '.') }}
                    </strong>

                    <p class="distribution-summary__description">
                        Jumlah penyaluran pada bulan berjalan.
                    </p>
                </article>

                <article class="distribution-summary__card">
                    <div class="distribution-summary__top">
                        <span class="distribution-summary__icon distribution-summary__icon--blue">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect x="3" y="6" width="18" height="13" rx="2"/>
                                <path d="M3 10h18M7 15h4"/>
                            </svg>
                        </span>
                        <span class="distribution-summary__label">Total Nilai Bantuan</span>
                    </div>

                    <strong class="distribution-summary__value distribution-summary__value--currency">
                        Rp{{ number_format((float) ($summary['total_amount'] ?? 0), 0, ',', '.') }}
                    </strong>

                    <p class="distribution-summary__description">
                        Akumulasi nilai penyaluran bantuan.
                    </p>
                </article>

                <article class="distribution-summary__card">
                    <div class="distribution-summary__top">
                        <span class="distribution-summary__icon distribution-summary__icon--orange">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <circle cx="9" cy="8" r="3"/>
                                <path d="M3 20v-1a6 6 0 0 1 12 0v1"/>
                                <path d="M17 8h4M19 6v4"/>
                            </svg>
                        </span>
                        <span class="distribution-summary__label">Penerima Tersedia</span>
                    </div>

                    <strong class="distribution-summary__value">
                        {{ count($beneficiaries) }}
                    </strong>

                    <p class="distribution-summary__description">
                        Penerima yang tersedia pada form penyaluran.
                    </p>
                </article>

            </section>


            {{-- LAYOUT UTAMA --}}
            <div class="distribution-layout">

                {{-- KOLOM KIRI: DAFTAR --}}
                <section class="distribution-list-panel">

                    <div class="distribution-panel-header">
                        <div>
                            <h2 class="distribution-panel-title">Daftar Penyaluran</h2>
                            <p class="distribution-panel-description">
                                Pantau dan kelola riwayat penyaluran bantuan.
                            </p>
                        </div>

                        <span class="distribution-count">
                            {{ $distributions->total() }} data
                        </span>
                    </div>


                    {{-- FILTER --}}
                    <form
                        action="{{ route('distributions.index') }}"
                        method="GET"
                        class="distribution-filters"
                    >
                        <div class="distribution-filter-field distribution-filter-field--search">
                            <label for="distribution-search">Cari Penyaluran</label>

                            <div class="distribution-search-wrapper">
                                <svg class="distribution-search-icon"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" aria-hidden="true">
                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m16 16 4 4"/>
                                </svg>

                                <input
                                    type="search"
                                    id="distribution-search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama penerima atau jenis bantuan..."
                                    class="distribution-input distribution-input--search"
                                >
                            </div>
                        </div>

                        <div class="distribution-filter-field">
                            <label for="distribution-type-filter">Jenis Bantuan</label>
                            <input
                                type="text"
                                id="distribution-type-filter"
                                name="assistance_type"
                                value="{{ request('assistance_type') }}"
                                class="distribution-input"
                                placeholder="Semua jenis bantuan"
                            >
                        </div>

                        <div class="distribution-filter-field">
                            <label for="distribution-status-filter">Status</label>
                            <select
                                id="distribution-status-filter"
                                name="status"
                                class="distribution-select"
                            >
                                <option value="">Semua Status</option>
                                @foreach (['Disalurkan', 'Diproses', 'Dibatalkan'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        @selected(request('status') === $status)
                                    >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="distribution-filter-field">
                            <label for="distribution-period-filter">Periode</label>
                            <select
                                id="distribution-period-filter"
                                name="period"
                                class="distribution-select"
                            >
                                <option value="">Semua Periode</option>
                                <option value="this_month"
                                    @selected(request('period') === 'this_month')>
                                    Bulan Ini
                                </option>
                                <option value="last_month"
                                    @selected(request('period') === 'last_month')>
                                    Bulan Lalu
                                </option>
                                <option value="this_year"
                                    @selected(request('period') === 'this_year')>
                                    Tahun Ini
                                </option>
                            </select>
                        </div>

                        <div class="distribution-filter-actions">
                            <button
                                type="submit"
                                class="distribution-button distribution-button--primary"
                            >
                                Terapkan
                            </button>

                            <a
                                href="{{ route('distributions.index') }}"
                                class="distribution-button distribution-button--secondary"
                            >
                                Reset
                            </a>
                        </div>
                    </form>


                    {{-- TABEL PENYALURAN --}}
                    <div class="distribution-table-wrapper">
                        <table class="distribution-table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama Penerima</th>
                                    <th scope="col">Jenis Bantuan</th>
                                    <th scope="col">Nominal/Nilai</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($distributions as $distribution)
                                    @php
                                        $statusSlug = strtolower(
                                            str_replace(' ', '-', $distribution->status)
                                        );
                                    @endphp

                                    <tr>
                                        <td class="distribution-table__number">
                                            {{ $distributions->firstItem() + $loop->index }}
                                        </td>

                                        <td class="distribution-table__date">
                                            {{ $distribution->distribution_date?->format('d-m-Y') ?? '-' }}
                                        </td>

                                        <td class="distribution-table__person">
                                            <span class="distribution-table__name">
                                                {{ $distribution->beneficiary?->name ?? 'Penerima tidak tersedia' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="distribution-table__type">
                                                {{ $distribution->assistance_type }}
                                            </span>
                                        </td>

                                        <td class="distribution-table__amount">
                                            Rp{{ number_format((float) $distribution->amount, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <span class="distribution-status distribution-status--{{ $statusSlug }}">
                                                {{ $distribution->status }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="distribution-actions">
                                                <a
                                                    href="{{ route('distributions.show', $distribution) }}"
                                                    class="distribution-action distribution-action--detail"
                                                >
                                                    Detail
                                                </a>

                                                <a
                                                    href="{{ route('distributions.edit', $distribution) }}"
                                                    class="distribution-action distribution-action--edit"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('distributions.destroy', $distribution) }}"
                                                    method="POST"
                                                    class="distribution-delete-form"
                                                    data-delete-distribution-form
                                                    data-distribution-name="{{ $distribution->assistance_type }} - {{ $distribution->beneficiary?->name ?? 'Penerima' }}"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="distribution-action distribution-action--delete"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="distribution-empty">
                                                <span class="distribution-empty__icon">
                                                    <svg viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.7"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        aria-hidden="true">
                                                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                                                        <path d="M8 9h8M8 13h8M8 17h4"/>
                                                    </svg>
                                                </span>

                                                <strong>Belum Ada Data Penyaluran</strong>

                                                <p>
                                                    Data penyaluran yang tersimpan
                                                    akan ditampilkan di sini.
                                                </p>

                                                <a
                                                    href="#distribution-create-panel"
                                                    class="distribution-button distribution-button--primary"
                                                >
                                                    Tambah Penyaluran
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="distribution-pagination">
                        {{ $distributions->appends(request()->query())->links() }}
                    </div>

                </section>


                {{-- KOLOM KANAN: FORM TAMBAH --}}
                <aside
                    class="distribution-create-panel"
                    id="distribution-create-panel"
                >
                    <div class="distribution-create-panel__header">
                        <span class="distribution-create-panel__icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path d="M8 9h8M8 13h8M8 17h4"/>
                            </svg>
                        </span>

                        <div>
                            <h2 class="distribution-panel-title">
                                Tambah Penyaluran Bantuan
                            </h2>
                            <p class="distribution-panel-description">
                                Input data penyaluran bantuan baru.
                            </p>
                        </div>
                    </div>


                    <div
                        id="duplicate-check-result"
                        class="distribution-duplicate-result"
                        aria-live="polite"
                    ></div>


                    <form
                        id="distribution-form"
                        action="{{ route('distributions.store') }}"
                        method="POST"
                        class="distribution-form"
                        data-duplicate-check-url="{{ route('distributions.check-duplicates') }}"
                    >
                        @csrf

                        <div class="distribution-field">
                            <label for="distribution-date">
                                Tanggal Penyaluran
                                <span class="distribution-required">*</span>
                            </label>

                            <input
                                type="date"
                                id="distribution-date"
                                name="distribution_date"
                                value="{{ old('distribution_date', date('Y-m-d')) }}"
                                required
                            >

                            @error('distribution_date')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-field">
                            <label for="distribution-beneficiary">
                                Penerima Manfaat
                                <span class="distribution-required">*</span>
                            </label>

                            <select
                                id="distribution-beneficiary"
                                name="beneficiary_id"
                                required
                            >
                                <option value="">Pilih penerima</option>

                                @foreach ($beneficiaries as $beneficiary)
                                    <option
                                        value="{{ $beneficiary->id }}"
                                        @selected((string) old('beneficiary_id') === (string) $beneficiary->id)
                                    >
                                        {{ $beneficiary->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('beneficiary_id')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-field">
                            <label for="distribution-assistance-type">
                                Jenis Bantuan
                                <span class="distribution-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="distribution-assistance-type"
                                name="assistance_type"
                                value="{{ old('assistance_type') }}"
                                maxlength="255"
                                placeholder="Contoh: Bantuan sembako"
                                required
                            >

                            @error('assistance_type')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-field">
                            <label for="distribution-amount">
                                Nominal/Nilai Bantuan
                                <span class="distribution-required">*</span>
                            </label>

                            <div class="distribution-amount-wrapper">
                                <span class="distribution-amount-prefix">Rp</span>

                                <input
                                    type="number"
                                    id="distribution-amount"
                                    name="amount"
                                    min="10000"
                                    step="1"
                                    value="{{ old('amount') }}"
                                    placeholder="Masukkan nominal"
                                    required
                                >
                            </div>

                            @error('amount')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-field">
                            <label for="distribution-donation">
                                Sumber Donasi
                                <span class="distribution-optional">Opsional</span>
                            </label>

                            <select id="distribution-donation" name="donation_id">
                                <option value="">Tanpa sumber donasi</option>

                                @foreach ($donations as $donation)
                                    <option
                                        value="{{ $donation->id }}"
                                        @selected((string) old('donation_id') === (string) $donation->id)
                                    >
                                        Donasi #{{ $donation->id }}
                                        - {{ $donation->display_donor_name }}
                                        - Rp{{ number_format((float) $donation->amount, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>

                            @error('donation_id')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-field">
                            <label for="distribution-status">
                                Status
                                <span class="distribution-required">*</span>
                            </label>

                            <select id="distribution-status" name="status" required>
                                @foreach (['Disalurkan', 'Diproses', 'Dibatalkan'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        @selected(old('status', 'Disalurkan') === $status)
                                    >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-field">
                            <label for="distribution-notes">
                                Catatan
                                <span class="distribution-optional">Opsional</span>
                            </label>

                            <textarea
                                id="distribution-notes"
                                name="notes"
                                rows="3"
                                placeholder="Tambahkan keterangan jika diperlukan"
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <small class="distribution-field__error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="distribution-guidance">
                            <span class="distribution-guidance__icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 11v5M12 8h.01"/>
                                </svg>
                            </span>

                            <p>
                                Sistem memeriksa potensi penyaluran ganda
                                untuk penerima yang sama pada bulan yang sama.
                            </p>
                        </div>

                        <div class="distribution-form-actions">
                            <button
                                type="reset"
                                class="distribution-button distribution-button--secondary"
                            >
                                Reset
                            </button>

                            <button
                                type="submit"
                                class="distribution-button distribution-button--primary"
                            >
                                Simpan Penyaluran
                            </button>
                        </div>
                    </form>
                </aside>

            </div>

        </main>
    </div>


    {{-- CEK DUPLIKASI DAN KONFIRMASI HAPUS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('distribution-form');
            const result = document.getElementById('duplicate-check-result');

            if (form && result) {
                const dateInput = form.querySelector('[name="distribution_date"]');
                const beneficiaryInput = form.querySelector('[name="beneficiary_id"]');
                const csrfInput = form.querySelector('[name="_token"]');
                const checkUrl = form.dataset.duplicateCheckUrl;

                let timeout;
                let requestNumber = 0;

                function clearResult() {
                    result.replaceChildren();
                }

                function addText(parent, tag, text, className = '') {
                    const element = document.createElement(tag);
                    element.textContent = text;

                    if (className) {
                        element.className = className;
                    }

                    parent.appendChild(element);
                    return element;
                }

                async function checkDuplicates() {
                    const date = dateInput.value;
                    const beneficiaryId = beneficiaryInput.value;
                    const currentRequest = ++requestNumber;

                    clearTimeout(timeout);

                    if (!date || !beneficiaryId) {
                        clearResult();
                        return;
                    }

                    timeout = setTimeout(async function () {
                        try {
                            const response = await fetch(checkUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfInput.value
                                },
                                body: JSON.stringify({
                                    distribution_date: date,
                                    beneficiary_id: beneficiaryId
                                })
                            });

                            if (!response.ok) {
                                throw new Error('Pengecekan duplikasi gagal.');
                            }

                            const data = await response.json();

                            if (currentRequest !== requestNumber) {
                                return;
                            }

                            clearResult();

                            if (!data.has_duplicates) {
                                return;
                            }

                            const warning = document.createElement('div');
                            warning.className = 'distribution-duplicate-warning';

                            addText(
                                warning,
                                'strong',
                                'Peringatan: Potensi duplikasi penyaluran!'
                            );

                            addText(
                                warning,
                                'p',
                                'Ditemukan ' + data.count +
                                ' catatan pada bulan yang sama.'
                            );

                            const list = document.createElement('ul');

                            data.data.forEach(function (item) {
                                const entry = document.createElement('li');

                                entry.textContent =
                                    item.beneficiary_name + ' — ' +
                                    item.distribution_date + ' — ' +
                                    item.assistance_type + ' — Rp' +
                                    Number(item.amount).toLocaleString('id-ID') +
                                    ' — ' + item.status;

                                list.appendChild(entry);
                            });

                            warning.appendChild(list);

                            addText(
                                warning,
                                'p',
                                'Jika melanjutkan, sistem akan meminta konfirmasi saat menyimpan.'
                            );

                            result.appendChild(warning);
                        } catch (error) {
                            if (currentRequest !== requestNumber) {
                                return;
                            }

                            clearResult();

                            addText(
                                result,
                                'p',
                                'Tidak dapat memeriksa potensi duplikasi. Coba lagi.',
                                'distribution-duplicate-warning'
                            );
                        }
                    }, 300);
                }

                dateInput.addEventListener('change', checkDuplicates);
                beneficiaryInput.addEventListener('change', checkDuplicates);

                form.addEventListener('reset', function () {
                    clearTimeout(timeout);
                    requestNumber++;
                    clearResult();
                });

                if (dateInput.value && beneficiaryInput.value) {
                    checkDuplicates();
                }
            }

            document.querySelectorAll('[data-delete-distribution-form]')
                .forEach(function (deleteForm) {
                    deleteForm.addEventListener('submit', function (event) {
                        const name = deleteForm.dataset.distributionName || 'data ini';

                        if (!confirm('Yakin ingin menghapus penyaluran "' + name + '"?')) {
                            event.preventDefault();
                        }
                    });
                });
        });
    </script>

</body>
</html>
