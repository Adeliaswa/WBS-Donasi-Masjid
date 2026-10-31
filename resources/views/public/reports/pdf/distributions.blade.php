<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Penyaluran</title>
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
    <h2>LAPORAN TRANSPARANSI PENYALURAN</h2>
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
                <th>Kategori Bantuan</th>
                <th>Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($distributions as $index => $distribution)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $distribution->distribution_date->format('d-m-Y') }}</td>
                    <td>{{ $distribution->public_category }}</td>
                    <td class="right">
                        Rp {{ number_format($distribution->amount, 0, ',', '.') }}
                    </td>
                    <td>-</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">
                        Tidak ada data penyaluran pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Penyaluran</th>
                <th class="right">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>