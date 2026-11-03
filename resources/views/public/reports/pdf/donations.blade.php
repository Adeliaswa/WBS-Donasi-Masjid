<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transparansi Donasi</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,400&display=swap');

        @page {
            margin: 35px 40px 40px 40px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'DejaVu Sans', sans-serif;
            color: #263027;
            font-size: 8pt;
            line-height: 1.4;
            background-color: #ffffff;
        }

        /* Helper Table */
        .table-full {
            width: 100%;
            border-collapse: collapse;
        }

        /* Header / Kop Laporan Formal */
        .header-container {
            border-bottom: 2.5px solid #294236;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        .brand-title {
            font-size: 13pt;
            font-weight: 700;
            color: #294236;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            color: #5d6e61;
            font-size: 7.5pt;
            margin-top: 2px;
        }

        .doc-title {
            font-size: 10.5pt;
            font-weight: 700;
            color: #294236;
            text-transform: uppercase;
            text-align: right;
        }

        .doc-subtitle {
            font-size: 7.5pt;
            color: #5d6e61;
            text-align: right;
            margin-top: 2px;
        }

        /* Metadata / Informasi Periode */
        .info-box {
            background-color: #f4f8f5;
            border: 1px solid #c8d8cc;
            margin-bottom: 16px;
            padding: 6px 10px;
        }

        .info-table td {
            padding: 2px 4px;
            font-size: 7.5pt;
            vertical-align: middle;
        }

        .info-label {
            font-weight: 700;
            color: #294236;
            text-transform: uppercase;
        }

        .info-value {
            color: #263027;
        }

        /* Section Title */
        .section-title {
            font-size: 8.5pt;
            font-weight: 700;
            color: #294236;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
            border-left: 3px solid #294236;
            padding-left: 6px;
        }

        /* Data Table Konsisten */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .report-table th {
            background-color: #294236;
            color: #ffffff;
            padding: 6px 8px;
            font-size: 7.5pt;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid #294236;
            text-align: left;
        }

        .report-table td {
            padding: 6px 8px;
            border: 1px solid #d5dfd7;
            font-size: 7.5pt;
            color: #263027;
        }

        .report-table tbody tr:nth-child(even) {
            background-color: #f7faf8;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Total Row Standard */
        .total-row td {
            background-color: #edf4ee !important;
            font-weight: 700;
            color: #294236;
            border-top: 2px solid #294236;
            border-bottom: 2px solid #294236;
            font-size: 8pt;
            padding: 6px 8px;
        }

        /* Note Section */
        .note-box {
            border: 1px solid #d5dfd7;
            border-left: 3px solid #294236;
            background-color: #ffffff;
            padding: 8px;
            margin-top: 16px;
        }

        .note-title {
            font-weight: 700;
            color: #294236;
            font-size: 7pt;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .note-content {
            color: #556358;
            font-size: 7pt;
            line-height: 1.3;
        }

        /* Footer */
        .footer {
            margin-top: 24px;
            padding-top: 6px;
            border-top: 1px solid #d5dfd7;
            color: #718075;
            font-size: 6.5pt;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Header / Kop -->
    <div class="header-container">
        <table class="table-full">
            <tr>
                <td width="55%" style="vertical-align: bottom;">
                    <div class="brand-title">MASJID SABILILLAH</div>
                    <div class="brand-subtitle">Layanan Informasi Donasi & Bantuan Sosial</div>
                </td>
                <td width="45%" style="vertical-align: bottom;">
                    <div class="doc-title">LAPORAN DONASI</div>
                    <div class="doc-subtitle">Rekapitulasi Transparansi Penerimaan</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Metadata Periode -->
    <div class="info-box">
        <table class="table-full info-table">
            <tr>
                <td width="15%" class="info-label">PERIODE</td>
                <td width="2%" class="info-label">:</td>
                <td width="43%" class="info-value">
                    {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
                    s.d.
                    {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                </td>
                <td width="18%" class="info-label">TANGGAL CETAK</td>
                <td width="2%" class="info-label">:</td>
                <td width="20%" class="info-value">
                    {{ now()->translatedFormat('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Judul Bagian -->
    <div class="section-title">RINCIAN PENERIMAAN DONASI</div>

    <!-- Tabel Data -->
    <table class="report-table">
        <thead>
            <tr>
                <th width="6%" class="text-center">NO.</th>
                <th width="18%">TANGGAL</th>
                <th width="28%">KATEGORI</th>
                <th width="20%">METODE</th>
                <th width="28%" class="text-right">NOMINAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donations as $index => $donation)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($donation->donation_date)->translatedFormat('d M Y') }}</td>
                    <td>{{ $donation->category }}</td>
                    <td>{{ $donation->payment_method }}</td>
                    <td class="text-right">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 12px; color: #666666;">
                        Tidak ada data donasi pada periode ini.
                    </td>
                </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL DONASI</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Catatan Tambahan -->
    <div class="note-box">
        <div class="note-title">Catatan:</div>
        <div class="note-content">
            Dokumen ini merupakan rekapitulasi resmi penerimaan donasi yang tercatat pada sistem Masjid Sabilillah. Demi menjaga privasi donatur, data identitas personal tidak dipublikasikan.
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dokumen Transparansi Publik &bull; Masjid Sabilillah &bull; Dicetak pada {{ now()->translatedFormat('d F Y H:i') }}
    </div>

</body>
</html>