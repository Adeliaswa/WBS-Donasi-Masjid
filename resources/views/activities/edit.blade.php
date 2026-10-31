<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan</title>
</head>
<body>
    <h1>Edit Kegiatan</h1>

    <a href="{{ route('activities.index') }}">Kembali ke Daftar Kegiatan</a>

    @if ($errors->any())
        <div>
            <p>Terjadi kesalahan:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Judul Kegiatan</label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $activity->title) }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="description">Deskripsi Kegiatan</label>
            <textarea
                id="description"
                name="description"
                required
            >{{ old('description', $activity->description) }}</textarea>
        </div>

        <br>

        <div>
            <label for="activity_date">Tanggal Kegiatan</label>
            <input
                type="date"
                id="activity_date"
                name="activity_date"
                value="{{ old('activity_date', $activity->activity_date->format('Y-m-d')) }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="is_published">Status Publikasi</label>
            <select id="is_published" name="is_published" required>
                <option value="0" {{ old('is_published', (string) (int) $activity->is_published) == '0' ? 'selected' : '' }}>
                    Draft
                </option>
                <option value="1" {{ old('is_published', (string) (int) $activity->is_published) == '1' ? 'selected' : '' }}>
                    Dipublikasikan
                </option>
            </select>
        </div>

        <br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>