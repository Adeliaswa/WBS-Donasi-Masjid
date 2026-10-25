<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori Penerima</title>
</head>
<body>
    <h1>Tambah Kategori Penerima</h1>

    <p>
        <a href="{{ route('beneficiary-categories.index') }}">
            Kembali ke Daftar Kategori
        </a>
    </p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('beneficiary-categories.store') }}" method="POST">
        @csrf

        <p>
            <label for="name">Nama Kategori</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                maxlength="255"
                required
            >
        </p>

        <p>
            <label for="description">Deskripsi</label><br>
            <textarea
                id="description"
                name="description"
                rows="4"
                cols="40"
            >{{ old('description') }}</textarea>
        </p>

        <button type="submit">Simpan Kategori</button>
        <a href="{{ route('beneficiary-categories.index') }}">Batal</a>
    </form>
</body>
</html>