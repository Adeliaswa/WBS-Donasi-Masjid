<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Donasi - Masjid Sabilillah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f7fa;
        }

        h1 {
            color: #245c46;
        }

        form {
            max-width: 650px;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button, .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #245c46;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            color: #b42318;
            font-size: 14px;
            margin-top: 5px;
        }

        .required {
            color: #b42318;
        }
    </style>
</head>
<body>
    <h1>Tambah Data Donasi</h1>

    <a href="{{ route('donations.index') }}">Kembali ke Daftar Donasi</a>

    @if ($errors->any())
        <div class="error">
            <p>Periksa kembali data yang kamu masukkan.</p>
        </div>
    @endif

    <form action="{{ route('donations.store') }}" method="POST">
        @csrf

        <label for="donor_name">Nama Donatur</label>
        <input
            type="text"
            id="donor_name"
            name="donor_name"
            value="{{ old('donor_name') }}"
            placeholder="Kosongkan jika ingin menjadi Hamba Allah"
        >
        @error('donor_name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="donation_date">
            Tanggal Donasi <span class="required">*</span>
        </label>
        <input
            type="date"
            id="donation_date"
            name="donation_date"
            value="{{ old('donation_date', date('Y-m-d')) }}"
            required
        >
        @error('donation_date')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="amount">
            Nominal Donasi (Rp) <span class="required">*</span>
        </label>
        <input
            type="number"
            id="amount"
            name="amount"
            value="{{ old('amount') }}"
            min="1"
            step="0.01"
            placeholder="Contoh: 100000"
            required
        >
        @error('amount')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="channel">
            Kanal Donasi <span class="required">*</span>
        </label>
        <input
            type="text"
            id="channel"
            name="channel"
            value="{{ old('channel') }}"
            placeholder="Contoh: Transfer bank"
            required
        >
        @error('channel')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="payment_method">
            Metode Pembayaran <span class="required">*</span>
        </label>
        <input
            type="text"
            id="payment_method"
            name="payment_method"
            value="{{ old('payment_method') }}"
            placeholder="Contoh: Transfer"
            required
        >
        @error('payment_method')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="category">
            Kategori Donasi <span class="required">*</span>
        </label>
        <input
            type="text"
            id="category"
            name="category"
            value="{{ old('category') }}"
            placeholder="Contoh: Operasional masjid"
            required
        >
        @error('category')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="verification_status">
            Status Verifikasi <span class="required">*</span>
        </label>
        <select id="verification_status" name="verification_status" required>
            <option value="">-- Pilih Status --</option>
            <option value="pending" @selected(old('verification_status') === 'pending')>
                Menunggu Verifikasi
            </option>
            <option value="verified" @selected(old('verification_status') === 'verified')>
                Terverifikasi
            </option>
            <option value="rejected" @selected(old('verification_status') === 'rejected')>
                Ditolak
            </option>
        </select>
        @error('verification_status')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="notes">Catatan</label>
        <textarea
            id="notes"
            name="notes"
            rows="4"
            placeholder="Catatan tambahan jika ada"
        >{{ old('notes') }}</textarea>
        @error('notes')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Simpan Donasi</button>
        <a href="{{ route('donations.index') }}" class="back">Batal</a>
    </form>
</body>
</html>