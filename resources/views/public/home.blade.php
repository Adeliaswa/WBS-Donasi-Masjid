<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Publik - Donasi Masjid</title>
</head>
<body>
    <h1>Informasi Publik Donasi Masjid</h1>

    <h2>Ringkasan Dana</h2>

    <p>Total Donasi:
        Rp {{ number_format($totalDonation, 0, ',', '.') }}
    </p>

    <p>Total Penyaluran:
        Rp {{ number_format($totalDistribution, 0, ',', '.') }}
    </p>

    <p>Jumlah Penerima:
        {{ number_format($totalRecipients, 0, ',', '.') }}
    </p>

    <p>Saldo:
        Rp {{ number_format($balance, 0, ',', '.') }}
    </p>

    <h2>Rekap Bulanan</h2>

    @foreach ($monthlyChart as $item)
        <p>
            Bulan {{ $item['month'] }}:
            Donasi Rp {{ number_format($item['donation'], 0, ',', '.') }},
            Penyaluran Rp {{ number_format($item['distribution'], 0, ',', '.') }}
        </p>
    @endforeach

    <h2>Penyaluran Berdasarkan Kategori</h2>

    @foreach ($distributionCategoryChart as $item)
        <p>
            {{ $item['category'] }}:
            Rp {{ number_format($item['total'], 0, ',', '.') }}
        </p>
    @endforeach

    <h2>Kegiatan Terbaru</h2>

    @forelse ($latestActivities as $activity)
        <article>
            <h3>{{ $activity->title }}</h3>
            <p>{{ $activity->activity_date->format('d-m-Y') }}</p>
            <p>{{ $activity->description }}</p>
        </article>
    @empty
        <p>Belum ada kegiatan yang dipublikasikan.</p>
    @endforelse

    <a href="{{ route('public.reports.index') }}">
        Lihat Laporan Transparansi
    </a>
</body>
</html>