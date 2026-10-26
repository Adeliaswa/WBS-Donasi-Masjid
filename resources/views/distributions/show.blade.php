<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Test Detail Penyaluran</title>
</head>
<body>
    <h1>DETAIL PENYALURAN BANTUAN</h1>

    <p><strong>ID:</strong> {{ $distribution->id }}</p>
    <p><strong>Tanggal:</strong> {{ $distribution->distribution_date->format('d-m-Y') }}</p>
    <p><strong>Penerima:</strong> {{ $distribution->beneficiary->name }}</p>
    <p><strong>Jenis bantuan:</strong> {{ $distribution->assistance_type }}</p>
    <p><strong>Nominal/nilai:</strong> Rp{{ number_format((float) $distribution->amount, 0, ',', '.') }}</p>
    <p><strong>Sumber donasi:</strong>
        {{ $distribution->donation
            ? 'Donasi #' . $distribution->donation->id
                . ' - Rp' . number_format((float) $distribution->donation->amount, 0, ',', '.')
            : 'Tidak dipilih' }}
    </p>
    <p><strong>Status:</strong> {{ $distribution->status }}</p>
    <p><strong>Catatan:</strong> {{ $distribution->notes ?: '-' }}</p>

    <a href="{{ route('distributions.index') }}">
        <button type="button">Kembali</button>
    </a>

    <a href="{{ route('distributions.edit', $distribution) }}">
        <button type="button">Edit</button>
    </a>
</body>
</html>