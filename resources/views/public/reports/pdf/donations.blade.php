<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Donasi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2, p {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 7px;
        }

        th {
            background-color: #eeeeee;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>LAPORAN TRANSPARANSI DONASI</h2>
    <p>Informasi Donasi Masjid</p>

    <p>
        Periode:
        {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}
        sampai
        {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
    </p>

    <p>
        Dicetak pada:
        {{ now()->format('d-m-Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Metode Pembayaran</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donations as $index => $donation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $donation->donation_date->format('d-m-Y') }}</td>
                    <td>{{ $donation->category }}</td>
                    <td>{{ $donation->payment_method }}</td>
                    <td class="right">
                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">
                        Tidak ada data donasi pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Donasi</th>
                <th class="right">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>
</body>
</html>