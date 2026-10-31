@extends('layouts.admin')

@section('title', 'Laporan Donasi dan Penyaluran')

@section('content')
<div style="padding: 24px;">
    <h1>Laporan Donasi dan Penyaluran</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Filter Laporan</h2>

    <form action="{{ route('reports.index') }}" method="GET">
        <div>
            <label for="report_type">Jenis Laporan:</label>
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
        </div>

        <div>
            <label for="category">Kategori:</label>
            <select name="category" id="category">
                <option value="">Semua Kategori</option>

                <optgroup label="Kategori Donasi">
                    @foreach ($donationCategories as $item)
                        <option value="{{ $item }}"
                            {{ $category === $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </optgroup>

                <optgroup label="Jenis Bantuan">
                    @foreach ($distributionCategories as $item)
                        <option value="{{ $item }}"
                            {{ $category === $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
        </div>

        <div>
            <label for="start_date">Tanggal Mulai:</label>
            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ $startDate }}"
                required
            >
        </div>

        <div>
            <label for="end_date">Tanggal Akhir:</label>
            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ $endDate }}"
                required
            >
        </div>

        <button type="submit">Tampilkan Laporan</button>
        <a href="{{ route('reports.index') }}">Reset</a>
    </form>

    <h2>Ringkasan</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Total Donasi Masuk</th>
                <th>Total Penyaluran</th>
                <th>Jumlah Penerima</th>
                <th>Saldo Donasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rp {{ number_format($totalDonation, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($totalDistribution, 0, ',', '.') }}</td>
                <td>{{ $totalRecipients }}</td>
                <td>Rp {{ number_format($balance, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Rekap Donasi</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Nominal</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donations as $donation)
                <tr>
                    <td>{{ $donations->firstItem() + $loop->index }}</td>
                    <td>{{ $donation->donation_date->format('d-m-Y') }}</td>
                    <td>{{ $donation->category }}</td>
                    <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                    <td>{{ $donation->payment_method }}</td>
                    <td>{{ $donation->verification_status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data donasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $donations->links() }}

    <h2>Rekap Penyaluran</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Bantuan</th>
                <th>Jumlah Penerima</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($distributions as $distribution)
                <tr>
                    <td>{{ $distributions->firstItem() + $loop->index }}</td>
                    <td>{{ $distribution->distribution_date->format('d-m-Y') }}</td>
                    <td>{{ $distribution->assistance_type }}</td>
                    <td>1</td>
                    <td>Rp {{ number_format($distribution->amount, 0, ',', '.') }}</td>
                    <td>{{ $distribution->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data penyaluran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $distributions->links() }}
</div>
@endsection