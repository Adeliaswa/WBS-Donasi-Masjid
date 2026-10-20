{{-- Pencarian dan Filter Data Donasi --}}
<form
    action="{{ route('donations.index') }}"
    method="GET"
    class="donations-filters"
    id="donationsFilterForm"
>
    {{-- Pencarian Donatur --}}
    <div class="donations-filters__field donations-filters__field--search">
        <label
            for="donationSearch"
            class="donations-filters__label"
        >
            Cari Donasi
        </label>

        <div class="donations-filters__search-wrapper">
            <svg
                class="donations-filters__search-icon"
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
                id="donationSearch"
                name="search"
                class="donations-filters__input donations-filters__input--search"
                placeholder="Cari nama donatur..."
                value="{{ request('search') }}"
            >
        </div>
    </div>

    {{-- Filter Kategori Donasi --}}
    <div class="donations-filters__field">
        <label
            for="donationCategory"
            class="donations-filters__label"
        >
            Kategori Donasi
        </label>

        <select
            id="donationCategory"
            name="category"
            class="donations-filters__select"
        >
            <option value="">Semua Kategori</option>

            @foreach (($categories ?? collect()) as $category)
                @php
                    $categoryName = is_string($category)
                        ? $category
                        : $category->name;
                @endphp

                <option
                    value="{{ $categoryName }}"
                    @selected(request('category') === $categoryName)
                >
                    {{ $categoryName }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Filter Status Verifikasi --}}
    <div class="donations-filters__field">
        <label
            for="donationStatus"
            class="donations-filters__label"
        >
            Status Verifikasi
        </label>

        <select
            id="donationStatus"
            name="verification_status"
            class="donations-filters__select"
        >
            <option value="">Semua Status</option>

            <option
                value="pending"
                @selected(request('verification_status') === 'pending')
            >
                Menunggu Verifikasi
            </option>

            <option
                value="verified"
                @selected(request('verification_status') === 'verified')
            >
                Terverifikasi
            </option>

            <option
                value="rejected"
                @selected(request('verification_status') === 'rejected')
            >
                Ditolak
            </option>
        </select>
    </div>

    {{-- Tombol Aksi --}}
    <div class="donations-filters__actions">
        <button
            type="submit"
            class="donations-button donations-button--primary"
        >
            Terapkan
        </button>

        <a
            href="{{ route('donations.index') }}"
            class="donations-button donations-button--secondary"
        >
            Reset
        </a>
    </div>
</form>