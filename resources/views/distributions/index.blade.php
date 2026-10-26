<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Backend Penyaluran Bantuan</title>
</head>
<body>
    <h1>TEST BACKEND PENYALURAN BANTUAN</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('warning'))
        <p style="color: orange;">{{ session('warning') }}</p>
    @endif
    
    @if (session('duplicate_warning'))
        <div style="border: 1px solid orange; padding: 12px; margin-bottom: 16px;">
            <h3>Peringatan Potensi Duplikasi</h3>

            <p>
                Ditemukan {{ session('duplicate_warning.count') }}
                catatan penyaluran untuk penerima ini pada bulan yang sama.
            </p>

            <ul>
                @foreach (session('duplicate_warning.data') as $item)
                    <li>
                        Penerima: {{ $item['beneficiary_name'] }} |
                        Tanggal: {{ $item['distribution_date'] }} |
                        Jenis bantuan: {{ $item['assistance_type'] }} |
                        Nominal: Rp{{ number_format((float) $item['amount'], 0, ',', '.') }} |
                        Status: {{ $item['status'] }}
                    </li>
                @endforeach
            </ul>

            <p>Apakah kamu tetap ingin menyimpan penyaluran ini?</p>

            <form action="{{ route('distributions.store') }}" method="POST">
                @csrf

                @foreach (old() as $key => $value)
                    @if (is_scalar($value) && $key !== '_token' && $key !== '_method')
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <input type="hidden" name="confirm_duplicate" value="1">

                <button type="submit">Tetap Simpan</button>
                <a href="{{ route('distributions.index') }}">Kembali</a>
            </form>
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <strong>Validasi gagal:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Ringkasan</h2>
    <p>Total penyaluran: {{ $summary['total'] }}</p>
    <p>Penyaluran bulan ini: {{ $summary['this_month'] }}</p>
    <p>Total nilai bantuan: Rp{{ number_format($summary['total_amount'], 0, ',', '.') }}</p>

    <hr>

        <h2>Tambah Penyaluran</h2>

        <div id="duplicate-check-result"></div>

        <form id="distribution-form" action="{{ route('distributions.store') }}" method="POST">
        @csrf

        <p>
            <label>Tanggal penyaluran</label><br>
            <input type="date" name="distribution_date"
                   value="{{ old('distribution_date', date('Y-m-d')) }}" required>
        </p>

        <p>
            <label>Penerima manfaat</label><br>
            <select name="beneficiary_id" required>
                <option value="">-- Pilih penerima --</option>
                @foreach ($beneficiaries as $beneficiary)
                    <option value="{{ $beneficiary->id }}"
                        @selected(old('beneficiary_id') == $beneficiary->id)>
                        {{ $beneficiary->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Jenis bantuan</label><br>
            <input type="text" name="assistance_type"
                   value="{{ old('assistance_type') }}" required>
        </p>

        <p>
            <label>Nominal/nilai bantuan</label><br>
            <input type="number" name="amount" min="10000" step="1"
                   value="{{ old('amount') }}" required>
        </p>

        <p>
            <label>Sumber donasi (opsional)</label><br>
            <select name="donation_id">
                <option value="">-- Tanpa sumber donasi --</option>
                @foreach ($donations as $donation)
                    <option value="{{ $donation->id }}"
                        @selected(old('donation_id') == $donation->id)>
                        Donasi #{{ $donation->id }}
                        - {{ $donation->display_donor_name }}
                        - Rp{{ number_format((float) $donation->amount, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Status</label><br>
            <select name="status" required>
                @foreach (['Disalurkan', 'Diproses', 'Dibatalkan'] as $status)
                    <option value="{{ $status }}"
                        @selected(old('status', 'Disalurkan') == $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Catatan (opsional)</label><br>
            <textarea name="notes">{{ old('notes') }}</textarea>
        </p>

        <button type="submit">Simpan Penyaluran</button>
    </form>

    <hr>

    <h2>Daftar Penyaluran</h2>

    @forelse ($distributions as $distribution)
        <div style="border: 1px solid #999; padding: 10px; margin-bottom: 10px;">
            <p>ID: {{ $distribution->id }}</p>
            <p>Tanggal: {{ $distribution->distribution_date->format('d-m-Y') }}</p>
            <p>Penerima: {{ $distribution->beneficiary->name }}</p>
            <p>Jenis bantuan: {{ $distribution->assistance_type }}</p>
            <p>Nilai: Rp{{ number_format((float) $distribution->amount, 0, ',', '.') }}</p>
            <p>Status: {{ $distribution->status }}</p>
            <p>
                Sumber donasi:
                {{ $distribution->donation
                    ? 'Donasi #' . $distribution->donation->id
                        . ' - Rp' . number_format((float) $distribution->donation->amount, 0, ',', '.')
                    : 'Tidak dipilih' }}
            </p>

            <a href="{{ route('distributions.show', $distribution) }}">
                <button type="button">Detail</button>
            </a>

            <a href="{{ route('distributions.edit', $distribution) }}">
                <button type="button">Edit</button>
            </a>

            <form action="{{ route('distributions.destroy', $distribution) }}"
                  method="POST" style="display: inline;"
                  onsubmit="return confirm('Yakin ingin menghapus penyaluran ini?')">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </div>
    @empty
        <p>Belum ada data penyaluran.</p>
    @endforelse

    {{ $distributions->links() }}
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('distribution-form');
        const dateInput = form.querySelector('[name="distribution_date"]');
        const beneficiaryInput = form.querySelector('[name="beneficiary_id"]');
        const result = document.getElementById('duplicate-check-result');

        let timeout;

        async function checkDuplicates() {
            const date = dateInput.value;
            const beneficiaryId = beneficiaryInput.value;

            if (!date || !beneficiaryId) {
                result.innerHTML = '';
                return;
            }

            clearTimeout(timeout);

            timeout = setTimeout(async () => {
                try {
                    const response = await fetch(@json(route('distributions.check-duplicates')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
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

                    if (!data.has_duplicates) {
                        result.innerHTML = '';
                        return;
                    }

                    result.innerHTML = `
                        <div style="border: 1px solid orange; padding: 12px; margin-bottom: 12px;">
                            <strong>Peringatan: Potensi duplikasi penyaluran!</strong>
                            <p>Ditemukan ${data.count} catatan pada bulan yang sama.</p>
                            <ul>
                                ${data.data.map(item => `
                                    <li>
                                        ${item.beneficiary_name} —
                                        ${item.distribution_date} —
                                        ${item.assistance_type} —
                                        Rp${Number(item.amount).toLocaleString('id-ID')} —
                                        ${item.status}
                                    </li>
                                `).join('')}
                            </ul>
                            <p>Jika melanjutkan, sistem akan meminta konfirmasi saat menyimpan.</p>
                        </div>
                    `;
                } catch (error) {
                    result.textContent = 'Tidak dapat memeriksa potensi duplikasi. Coba lagi.';
                }
            }, 300);
        }

        dateInput.addEventListener('change', checkDuplicates);
        beneficiaryInput.addEventListener('change', checkDuplicates);
    });
    </script>
</body>
</html>