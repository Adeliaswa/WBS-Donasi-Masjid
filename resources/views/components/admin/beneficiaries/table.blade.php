
{{-- Tabel Data Penerima Manfaat --}}
<div class="beneficiaries-table-wrap">
    <table class="beneficiaries-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Penerima</th>
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
                    {{-- Nomor urut --}}
                    <td>
                        {{ $beneficiaries->firstItem() + $loop->index }}
                    </td>

                    {{-- Nama --}}
                    <td>
                        <span class="beneficiaries-table__name">
                            {{ $beneficiary->name }}
                        </span>
                    </td>

                    {{-- NIK --}}
                    <td>{{ $beneficiary->nik }}</td>

                    {{-- Kategori --}}
                    <td>
                        @php
                            $categoryName = $beneficiary
                                ->beneficiaryCategory?->name;

                            $displayCategory = $categoryName ?? '-';

                            if (
                                strtolower($categoryName ?? '') === 'lainnya'
                                && $beneficiary->other_category
                            ) {
                                $displayCategory = $beneficiary->other_category;
                            }
                        @endphp

                        <span class="beneficiaries-category">
                            {{ $displayCategory }}
                        </span>
                    </td>

                    {{-- Alamat --}}
                    <td>
                        <span class="beneficiaries-table__address">
                            {{ $beneficiary->address }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if ($beneficiary->status === 'Aktif')
                            <span class="beneficiaries-status beneficiaries-status--active">
                                Aktif
                            </span>
                        @else
                            <span class="beneficiaries-status beneficiaries-status--inactive">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>

                    {{-- Tanggal terdaftar --}}
                    <td>
                        {{ $beneficiary->registered_at?->format('d-m-Y') ?? '-' }}
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="beneficiaries-table__actions">
                            <a
                                href="{{ route('beneficiaries.show', $beneficiary) }}"
                                class="beneficiaries-action-button"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('beneficiaries.edit', $beneficiary) }}"
                                class="beneficiaries-action-button"
                            >
                                Ubah
                            </a>

                            <form
                                action="{{ route('beneficiaries.destroy', $beneficiary) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data penerima ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="beneficiaries-action-button beneficiaries-action-button--delete"
                                >
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="beneficiaries-empty">
                            <div class="beneficiaries-empty__icon">
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <circle cx="9" cy="8" r="3"/>
                                    <path d="M3 20v-1a6 6 0 0 1 12 0v1"/>
                                    <path d="M16 11a3 3 0 0 0 0-6"/>
                                    <path d="M18 14a5 5 0 0 1 3 5v1"/>
                                </svg>
                            </div>

                            <strong>Belum ada data penerima</strong>

                            <p>
                                Data penerima manfaat belum tersedia
                                atau tidak ditemukan berdasarkan pencarian
                                dan filter yang dipilih.
                            </p>

                            @if (
                                request()->filled('search')
                                || request()->filled('category_id')
                                || request()->filled('status')
                            )
                                <a href="{{ route('beneficiaries.index') }}">
                                    Reset pencarian dan filter
                                </a>
                            @else
                                <a href="{{ route('beneficiaries.create') }}">
                                    Tambah penerima manfaat
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
