<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penerima Manfaat</title>
</head>
<body>
    <h1>Detail Penerima Manfaat</h1>

    <p><a href="{{ route('beneficiaries.index') }}">Kembali ke Daftar</a></p>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0">
        <tr><th>ID</th><td>{{ $beneficiary->id }}</td></tr>
        <tr><th>Nama</th><td>{{ $beneficiary->name }}</td></tr>
        <tr><th>NIK</th><td>{{ $beneficiary->nik }}</td></tr>
        <tr><th>Alamat</th><td>{{ $beneficiary->address }}</td></tr>
        <tr><th>Kontak</th><td>{{ $beneficiary->contact ?: '-' }}</td></tr>
        <tr>
            <th>Kategori</th>
            <td>
                {{ $beneficiary->category?->name ?? '-' }}
                @if ($beneficiary->other_category)
                    ({{ $beneficiary->other_category }})
                @endif
            </td>
        </tr>
        <tr><th>Kondisi / Kriteria</th><td>{{ $beneficiary->condition ?: '-' }}</td></tr>
        <tr><th>Status</th><td>{{ $beneficiary->status }}</td></tr>
        <tr>
            <th>Tanggal Terdaftar</th>
            <td>{{ $beneficiary->registered_at?->format('d-m-Y') }}</td>
        </tr>
        <tr><th>Catatan</th><td>{{ $beneficiary->notes ?: '-' }}</td></tr>
    </table>

    <p>
        <a href="{{ route('beneficiaries.edit', $beneficiary) }}">Edit Penerima</a>
    </p>
</body>
</html>