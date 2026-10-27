
{{-- Pencarian dan Filter Penerima Manfaat --}}
<form
    action="{{ route('beneficiaries.index') }}"
    method="GET"
    class="beneficiary-filters"
    id="beneficiaryFilterForm"
>
    {{-- Pencarian --}}
    <div class="beneficiary-filters__search">
        <label for="beneficiarySearch">
            Cari Penerima
        </label>

        <div class="beneficiary-filters__search-box">
            <svg
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="11" cy="11" r="7"/>
                <path d="m16 16 4 4"/>
            </svg>

            <input
                type="search"
                id="beneficiarySearch"
                name="search"
                placeholder="Cari nama, NIK, atau alamat..."
                value="{{ request('search') }}"
            >
        </div>
    </div>

    {{-- Filter Kategori --}}
    <div class="beneficiary-filters__field">
        <label for="beneficiaryCategory">
            Kategori
        </label>

        <select
            id="beneficiaryCategory"
            name="category_id"
        >
            <option value="">Semua Kategori</option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(
                        (string) request('category_id') ===
                        (string) $category->id
                    )
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Filter Status --}}
    <div class="beneficiary-filters__field">
        <label for="beneficiaryStatus">
            Status Penerima
        </label>

        <select
            id="beneficiaryStatus"
            name="status"
        >
            <option value="">Semua Status</option>

            <option
                value="Aktif"
                @selected(request('status') === 'Aktif')
            >
                Aktif
            </option>

            <option
                value="Tidak Aktif"
                @selected(request('status') === 'Tidak Aktif')
            >
                Tidak Aktif
            </option>
        </select>
    </div>

    {{-- Tombol Filter --}}
    <div class="beneficiary-filters__actions">
        <button
            type="submit"
            class="beneficiary-filters__submit"
        >
            Terapkan
        </button>

        <a
            href="{{ route('beneficiaries.index') }}"
            class="beneficiary-filters__reset"
        >
            Reset
        </a>
    </div>
</form>
