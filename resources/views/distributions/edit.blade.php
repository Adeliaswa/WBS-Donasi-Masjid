
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Edit Penyaluran</title>
</head>
<body>
    <h1>EDIT PENYALURAN BANTUAN</h1>

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

    {{-- Konfirmasi jika duplikasi ditemukan saat menyimpan --}}
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

            <p>Apakah kamu tetap ingin menyimpan perubahan ini?</p>

            <form action="{{ route('distributions.update', $distribution) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach (old() as $key => $value)
                    @if (is_scalar($value) && $key !== '_token' && $key !== '_method')
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <input type="hidden" name="confirm_duplicate" value="1">

                <button type="submit">Tetap Simpan</button>
                <a href="{{ route('distributions.edit', $distribution) }}">Kembali</a>
            </form>
        </div>
    @endif

    {{-- Peringatan duplikasi secara otomatis --}}
    <div id="duplicate-check-result" aria-live="polite"></div>

    {{-- Form utama untuk mengedit penyaluran --}}
    <form
        id="edit-distribution-form"
        action="{{ route('distributions.update', $distribution) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <p>
            <label for="distribution_date">Tanggal penyaluran</label><br>
            <input
                type="date"
                id="distribution_date"
                name="distribution_date"
                value="{{ old('distribution_date', $distribution->distribution_date->format('Y-m-d')) }}"
                required
            >
        </p>

        <p>
            <label for="beneficiary_id">Penerima manfaat</label><br>
            <select id="beneficiary_id" name="beneficiary_id" required>
                @foreach ($beneficiaries as $beneficiary)
                    <option
                        value="{{ $beneficiary->id }}"
                        @selected(old('beneficiary_id', $distribution->beneficiary_id) == $beneficiary->id)
                    >
                        {{ $beneficiary->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="assistance_type">Jenis bantuan</label><br>
            <input
                type="text"
                id="assistance_type"
                name="assistance_type"
                value="{{ old('assistance_type', $distribution->assistance_type) }}"
                required
            >
        </p>

        <p>
            <label for="amount">Nominal/nilai bantuan</label><br>
            <input
                type="number"
                id="amount"
                name="amount"
                min="10000"
                step="1"
                value="{{ old('amount', $distribution->amount) }}"
                required
            >
        </p>

        <p>
            <label for="donation_id">Sumber donasi (opsional)</label><br>
            <select id="donation_id" name="donation_id">
                <option value="">-- Tanpa sumber donasi --</option>
                @foreach ($donations as $donation)
                    <option
                        value="{{ $donation->id }}"
                        @selected(old('donation_id', $distribution->donation_id) == $donation->id)
                    >
                        Donasi #{{ $donation->id }} - {{ $donation->display_donor_name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="status">Status</label><br>
            <select id="status" name="status" required>
                @foreach (['Disalurkan', 'Diproses', 'Dibatalkan'] as $status)
                    <option
                        value="{{ $status }}"
                        @selected(old('status', $distribution->status) == $status)
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="notes">Catatan</label><br>
            <textarea id="notes" name="notes">{{ old('notes', $distribution->notes) }}</textarea>
        </p>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <p>
        <a href="{{ route('distributions.index') }}">Kembali ke daftar penyaluran</a>
    </p>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('edit-distribution-form');
            const dateInput = document.getElementById('distribution_date');
            const beneficiaryInput = document.getElementById('beneficiary_id');
            const result = document.getElementById('duplicate-check-result');

            const csrfToken = form.querySelector('[name="_token"]').value;
            const distributionId = @json($distribution->id);
            const checkUrl = @json(route('distributions.check-duplicates'));

            let timeout;
            let requestNumber = 0;

            function showMessage(message) {
                result.replaceChildren();

                const paragraph = document.createElement('p');
                paragraph.textContent = message;
                result.appendChild(paragraph);
            }

            function showDuplicates(data) {
                result.replaceChildren();

                const box = document.createElement('div');
                box.style.border = '1px solid orange';
                box.style.padding = '12px';
                box.style.marginBottom = '12px';

                const heading = document.createElement('strong');
                heading.textContent = 'Peringatan: Potensi duplikasi penyaluran!';
                box.appendChild(heading);

                const description = document.createElement('p');
                description.textContent =
                    `Ditemukan ${data.count} catatan penyaluran untuk penerima ini pada bulan yang sama.`;
                box.appendChild(description);

                const list = document.createElement('ul');

                data.data.forEach(function (item) {
                    const listItem = document.createElement('li');

                    listItem.textContent =
                        `Penerima: ${item.beneficiary_name ?? '-'} | ` +
                        `Tanggal: ${item.distribution_date} | ` +
                        `Jenis bantuan: ${item.assistance_type} | ` +
                        `Nominal: Rp${Number(item.amount).toLocaleString('id-ID')} | ` +
                        `Status: ${item.status}`;

                    list.appendChild(listItem);
                });

                box.appendChild(list);

                const note = document.createElement('p');
                note.textContent =
                    'Jika tetap menyimpan perubahan, sistem akan meminta konfirmasi.';
                box.appendChild(note);

                result.appendChild(box);
            }

            async function checkDuplicates() {
                clearTimeout(timeout);

                const currentRequest = ++requestNumber;
                const date = dateInput.value;
                const beneficiaryId = beneficiaryInput.value;

                if (!date || !beneficiaryId) {
                    result.replaceChildren();
                    return;
                }

                timeout = setTimeout(async function () {
                    showMessage('Memeriksa potensi duplikasi...');

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

                        // Abaikan respons lama jika input sudah berubah.
                        if (currentRequest !== requestNumber) {
                            return;
                        }

                        if (data.has_duplicates) {
                            showDuplicates(data);
                        } else {
                            result.replaceChildren();
                        }
                    } catch (error) {
                        if (currentRequest === requestNumber) {
                            showMessage(
                                'Pengecekan duplikasi gagal. Silakan coba lagi.'
                            );
                        }
                    }
                }, 300);
            }

            dateInput.addEventListener('change', checkDuplicates);
            beneficiaryInput.addEventListener('change', checkDuplicates);

            // Periksa juga nilai awal ketika halaman edit dibuka.
            checkDuplicates();
        });
    </script>
</body>
</html>