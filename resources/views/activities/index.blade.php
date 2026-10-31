<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kegiatan</title>
</head>
<body>
    <h1>Kelola Kegiatan</h1>

    <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    <br><br>

    <a href="{{ route('activities.create') }}">Tambah Kegiatan</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Tanggal Kegiatan</th>
                <th>Status Publikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $activity)
                <tr>
                    <td>{{ $activities->firstItem() + $loop->index }}</td>
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->activity_date->format('d-m-Y') }}</td>
                    <td>
                        {{ $activity->is_published ? 'Dipublikasikan' : 'Draft' }}
                    </td>
                    <td>
                        <a href="{{ route('activities.show', $activity->id) }}">
                            Detail
                        </a>

                        |

                        <a href="{{ route('activities.edit', $activity->id) }}">
                            Edit
                        </a>

                        |

                        <form
                            action="{{ route('activities.destroy', $activity->id) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada kegiatan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $activities->links() }}
</body>
</html>