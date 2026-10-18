<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Donasi - Masjid Sabilillah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f7fa;
        }

        h1 {
            color: #245c46;
        }

        .button {
            display: inline-block;
            padding: 9px 14px;
            background-color: #245c46;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #245c46;
            color: white;
        }

        .message {
            margin-top: 15px;
            padding: 12px;
            background-color: #d4edda;
            color: #155724;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .delete-button {
            background-color: #b42318;
        }

        .empty {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Data Donasi Masjid Sabilillah</h1>

    <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    <br><br>

    <a href="{{ route('donations.create') }}" class="button">
        + Tambah Donasi
    </a>

    @if (session('success'))
        <div class="message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama Donatur</th>
                <th>Nominal</th>
                <th>Kanal</th>
                <th>Metode Pembayaran</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($donations as $donation)
                <tr>
                    <td>{{ $donations->firstItem() + $loop->index }}</td>
                    <td>{{ $donation->donation_date->format('d-m-Y') }}</td>
                    <td>{{ $donation->display_donor_name }}</td>
                    <td>Rp {{ number_format((float) $donation->amount, 0, ',', '.') }}</td>
                    <td>{{ $donation->channel }}</td>
                    <td>{{ $donation->payment_method }}</td>
                    <td>{{ $donation->category }}</td>
                    <td>{{ $donation->verification_status }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('donations.edit', $donation) }}">
                                Ubah
                            </a>

                            <form
                                action="{{ route('donations.destroy', $donation) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data donasi ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="button delete-button">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="empty">
                        Belum ada data donasi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $donations->links() }}
    </div>
</body>
</html>