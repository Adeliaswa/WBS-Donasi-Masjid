<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kegiatan</title>
</head>
<body>
    <h1>Detail Kegiatan</h1>

    <a href="{{ route('activities.index') }}">Kembali ke Daftar Kegiatan</a>

    <h2>{{ $activity->title }}</h2>

    <p>
        <strong>Tanggal Kegiatan:</strong>
        {{ $activity->activity_date->format('d-m-Y') }}
    </p>

    <p>
        <strong>Status Publikasi:</strong>
        {{ $activity->is_published ? 'Dipublikasikan' : 'Draft' }}
    </p>

    <p><strong>Deskripsi:</strong></p>
    <p>{{ $activity->description }}</p>

    <br>

    <a href="{{ route('activities.edit', $activity->id) }}">
        Edit Kegiatan
    </a>
</body>
</html>