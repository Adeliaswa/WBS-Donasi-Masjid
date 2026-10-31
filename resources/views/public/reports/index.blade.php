<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transparansi - Donasi Masjid</title>
</head>
<body>
    <h1>Laporan Transparansi Donasi dan Penyaluran</h1>

    <a href="{{ route('public.home') }}">Kembali ke Halaman Utama</a>

    <h2>Filter Laporan</h2>

    <form action="{{ route('public.reports.index') }}" method="GET">
        <label for="start_date">Dari Tanggal</label>
        <input
            type="date"
            id="start_date"
            name="start_date"
            value="{{ $startDate }}"
        >

        <label for="end_date">Sampai Tanggal</label>
        <input
            type="date"
            id="end_date"
            name="end_date"
            value="{{ $endDate }}"
        >

        <label for="report_type">Jenis Laporan</label>
        <select name="report_type" id="report_type">
            <option value="semua" {{ $reportType === 'semua' ? 'selected' : '' }}>
                Semua
            </option>
            <option value="donasi" {{ $reportType === 'donasi' ? 'selected' : '' }}>
                Donasi
            </option>
            <option value="penyaluran" {{ $reportType === 'penyaluran' ? 'selected' : '' }}>
                Penyaluran
            </option>
        </select>

        <input type="hidden" name="tab" value="{{ $tab }}">

        <button type="submit">Tampilkan Laporan</button>
    </form>

    <h2>Ringkasan</h2>

    <p>Total Donasi: Rp {{ number_format($totalDonation, 0, ',', '.') }}</p>
    <p>Total Penyaluran: Rp {{ number_format($totalDistribution, 0, ',', '.') }}</p>
    <p>Jumlah Penerima: {{ number_format($totalRecipients, 0, ',', '.') }}</p>
    <p>Saldo: Rp {{ number_format($balance, 0, ',', '.') }}</p>

    <h2>Unduh Laporan PDF</h2>

    <a href="{{ route('public.reports.pdf.donations', [
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]) }}">
        Unduh Rekap Donasi PDF
    </a>

    <br><br>

    <a href="{{ route('public.reports.pdf.distributions', [
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]) }}">
        Unduh Rekap Penyaluran PDF
    </a>

    <h2>Jenis Rekap</h2>

    <nav>
        @foreach ([
            'donasi' => 'Rekap Donasi',
            'penyaluran' => 'Rekap Penyaluran',
            'kategori' => 'Rekap Kategori',
            'bulanan' => 'Rekap Bulanan',
        ] as $key => $label)
            <a href="{{ route('public.reports.index', array_merge(request()->query(), ['tab' => $key])) }}">
                {{ $label }}
            </a>
        @endforeach
    </nav>

    @if ($tab === 'donasi')
        <h2>Rekap Donasi</h2>

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Metode Pembayaran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donations as $donation)
                    <tr>
                        <td>{{ $donation->donation_date->format('d-m-Y') }}</td>
                        <td>{{ $donation->category }}</td>
                        <td>{{ $donation->payment_method }}</td>
                        <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td>-</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data donasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $donations->links() }}

    @elseif ($tab === 'penyaluran')
        <h2>Rekap Penyaluran</h2>

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori Bantuan</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($distributions as $distribution)
                    <tr>
                        <td>{{ $distribution->distribution_date->format('d-m-Y') }}</td>
                        <td>{{ $distribution->assistance_type }}</td>
                        <td>Rp {{ number_format($distribution->amount, 0, ',', '.') }}</td>
                        <td>-</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data penyaluran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $distributions->links() }}

    @elseif ($tab === 'kategori')
        <h2>Rekap Berdasarkan Kategori</h2>

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Total Nominal</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categoryRecap as $item)
                    <tr>
                        <td>{{ $item['category'] }}</td>
                        <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                        <td>{{ $item['percentage'] }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada data penyaluran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($tab === 'bulanan')
        <h2>Rekap Bulanan</h2>

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Total Donasi</th>
                    <th>Total Penyaluran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monthlyRecap as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $item['month'])->translatedFormat('F Y') }}</td>
                        <td>Rp {{ number_format($item['donation'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item['distribution'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada data laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>