<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penerima Manfaat</title>
</head>
<body>
    <h1>Edit Penerima Manfaat</h1>

    <p>
        <a href="{{ route('beneficiaries.show', $beneficiary) }}">Kembali ke Detail</a>
    </p>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Periksa kembali input berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label for="name">Nama Penerima *</label><br>
            <input id="name" type="text" name="name"
                   value="{{ old('name', $beneficiary->name) }}" required>
        </p>

        <p>
            <label for="nik">NIK *</label><br>
            <input id="nik" type="text" name="nik" maxlength="32"
                   value="{{ old('nik', $beneficiary->nik) }}" required>
        </p>

        <p>
            <label for="address">Alamat *</label><br>
            <textarea id="address" name="address" required>{{ old('address', $beneficiary->address) }}</textarea>
        </p>

        <p>
            <label for="contact">Kontak</label><br>
            <input id="contact" type="text" name="contact"
                   value="{{ old('contact', $beneficiary->contact) }}">
        </p>

        <p>
            <label for="category_id">Kategori *</label><br>
            <select id="category_id" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $beneficiary->category_id) == $category->id)>
                        {{ $category->name }}
                        {{ !$category->is_active ? '(Nonaktif)' : '' }}
                    </option>
                @endforeach
            </select>
        </p>

        <p id="other-category-field" style="display: none;">
            <label for="other_category">Nama Kategori Lainnya *</label><br>
            <input id="other_category" type="text" name="other_category"
                   value="{{ old('other_category', $beneficiary->other_category) }}">
        </p>

        <p>
            <label for="condition">Kondisi / Kriteria</label><br>
            <textarea id="condition" name="condition">{{ old('condition', $beneficiary->condition) }}</textarea>
        </p>

        <p>
            <label for="status">Status *</label><br>
            <select id="status" name="status" required>
                <option value="Aktif" @selected(old('status', $beneficiary->status) === 'Aktif')>Aktif</option>
                <option value="Tidak Aktif" @selected(old('status', $beneficiary->status) === 'Tidak Aktif')>Tidak Aktif</option>
            </select>
        </p>

        <p>
            <label for="notes">Catatan</label><br>
            <textarea id="notes" name="notes">{{ old('notes', $beneficiary->notes) }}</textarea>
        </p>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <script>
        const categorySelect = document.getElementById('category_id');
        const otherField = document.getElementById('other-category-field');
        const otherInput = document.getElementById('other_category');

        function toggleOtherCategory() {
            const selectedText = categorySelect.options[
                categorySelect.selectedIndex
            ]?.text.trim().replace(' (Nonaktif)', '').toLowerCase();

            const isOther = selectedText === 'lainnya';

            otherField.style.display = isOther ? 'block' : 'none';
            otherInput.required = isOther;

            if (!isOther) {
                otherInput.value = '';
            }
        }

        categorySelect.addEventListener('change', toggleOtherCategory);
        toggleOtherCategory();
    </script>
</body>
</html>