
{{-- Tabel Data Donasi --}}
<div class="donations-table-wrapper">
    <table class="donations-table">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nama Donatur</th>
                <th scope="col">Nominal</th>
                <th scope="col">Kanal</th>
                <th scope="col">Metode Pembayaran</th>
                <th scope="col">Kategori</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($donations as $donation)
                <tr>
                    {{-- Nomor urut --}}
                    <td class="donations-table__number">
                        {{ $donations->firstItem() + $loop->index }}
                    </td>

                    {{-- Tanggal donasi --}}
                    <td>
                        {{ $donation->donation_date->format('d-m-Y') }}
                    </td>

                    {{-- Nama donatur --}}
                    <td class="donations-table__donor">
                        {{ $donation->display_donor_name }}
                    </td>

                    {{-- Nominal --}}
                    <td class="donations-table__amount">
                        Rp {{ number_format((float) $donation->amount, 0, ',', '.') }}
                    </td>

                    {{-- Kanal --}}
                    <td>
                        {{ $donation->channel }}
                    </td>

                    {{-- Metode pembayaran --}}
                    <td>
                        {{ $donation->payment_method }}
                    </td>

                    {{-- Kategori --}}
                    <td>
                        {{ $donation->category }}
                    </td>

                    {{-- Status verifikasi --}}
                    <td>
                        @php
                            $status = strtolower($donation->verification_status);

                            $statusClass = match ($status) {
                                'pending' => 'pending',
                                'verified' => 'verified',
                                'rejected' => 'rejected',
                                default => 'unknown',
                            };

                            $statusLabel = match ($status) {
                                'pending' => 'Menunggu Verifikasi',
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                                default => ucfirst($donation->verification_status),
                            };
                        @endphp

                        <span class="donations-status donations-status--{{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="donations-table__actions">

                            {{-- Detail --}}
                            <a
                                href="{{ route('donations.show', $donation) }}"
                                class="donations-table__action donations-table__action--detail"
                                aria-label="Lihat detail donasi {{ $donation->display_donor_name }}"
                            >
                                Detail
                            </a>

                            {{-- Ubah --}}
                            <a
                                href="{{ route('donations.edit', $donation) }}"
                                class="donations-table__action donations-table__action--edit"
                                aria-label="Ubah donasi {{ $donation->display_donor_name }}"
                            >
                                Ubah
                            </a>

                            {{-- Hapus --}}
                            <button
                                type="button"
                                class="donations-table__action donations-table__action--delete"
                                data-delete-trigger
                                data-donation-name="{{ $donation->display_donor_name }}"
                                data-delete-url="{{ route('donations.destroy', $donation) }}"
                                aria-label="Hapus donasi {{ $donation->display_donor_name }}"
                            >
                                Hapus
                            </button>

                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="9" class="donations-table__empty">
                        <div class="donations-table__empty-content">

                            <span
                                class="donations-table__empty-icon"
                                aria-hidden="true"
                            >
                                ♧
                            </span>

                            <p class="donations-table__empty-title">
                                Belum Ada Data Donasi
                            </p>

                            <p class="donations-table__empty-description">
                                Data donasi yang tercatat akan ditampilkan di sini.
                            </p>

                            <a
                                href="{{ route('donations.create') }}"
                                class="donations-button donations-button--primary"
                            >
                                + Tambah Donasi
                            </a>

                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
