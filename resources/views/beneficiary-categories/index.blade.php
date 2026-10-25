<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Penerima Manfaat</title>
</head>
<body>
    <h1>Kategori Penerima Manfaat</h1>

    <p><a href="{{ route('dashboard') }}">Kembali ke Dashboard</a></p>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>
        <a href="{{ route('beneficiary-categories.create') }}">
            Tambah Kategori
        </a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Penerima</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>{{ $category->beneficiaries_count }}</td>
                    <td>{{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td>
                        <a href="{{ route('beneficiary-categories.edit', $category) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('beneficiary-categories.toggle-status', $category) }}"
                            method="POST"
                            style="display: inline;"
                        >
                            @csrf
                            @method('PATCH')

                            <button type="submit">
                                {{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        <form
                            action="{{ route('beneficiary-categories.destroy', $category) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada kategori penerima manfaat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $categories->links() }}
    </div>
</body>
</html>