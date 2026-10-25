<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerima Manfaat</title>
</head>
<body>
    <h1>Data Penerima Manfaat</h1>

    <p><a href="{{ route('dashboard') }}">Kembali ke Dashboard</a></p>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <p>
        <a href="{{ route('beneficiaries.create') }}">Tambah Penerima</a>
    </p>

    <form method="GET" action="{{ route('beneficiaries.index') }}">
        <input
            type="text"
            name="search"
            placeholder="Cari nama, NIK, atau alamat"
            value="{{ request('search') }}"
        >

        <select name="category_id">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(request('category_id') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">Semua Status</option>
            <option value="Aktif" @selected(request('status') === 'Aktif')>
                Aktif
            </option>
            <option value="Tidak Aktif" @selected(request('status') === 'Tidak Aktif')>
                Tidak Aktif
            </option>
        </select>

        <button type="submit">Cari / Filter</button>
        <a href="{{ route('beneficiaries.index') }}">Reset</a>
    </form>

    <p>Total data pada halaman ini: {{ $beneficiaries->count() }}</p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Kategori</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Tanggal Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($beneficiaries as $beneficiary)
                <tr>
                    <td>{{ $beneficiaries->firstItem() + $loop->index }}</td>
                    <td>{{ $beneficiary->name }}</td>
                    <td>{{ $beneficiary->nik }}</td>
                    <td>
                        {{ $beneficiary->beneficiaryCategory?->name ?? '-' }}

                        @if (strtolower($beneficiary->beneficiaryCategory?->name ?? '') === 'lainnya')
                            @if ($beneficiary->other_category)
                                ({{ $beneficiary->other_category }})
                            @endif
                        @endif
                    </td>
                    <td>{{ $beneficiary->address }}</td>
                    <td>{{ $beneficiary->status }}</td>
                    <td>{{ $beneficiary->registered_at?->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('beneficiaries.show', $beneficiary) }}">Detail</a>
                        |
                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}">Edit</a>
                        |
                        <form
                            action="{{ route('beneficiaries.destroy', $beneficiary) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Yakin ingin menghapus penerima ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data penerima manfaat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $beneficiaries->links() }}
    </div>
</body>
</html>