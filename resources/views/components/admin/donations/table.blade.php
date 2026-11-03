
<div class="donations-table-wrapper">

    <table class="donations-table">

        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama Donatur</th>
                <th>Nominal</th>
                <th>Kanal</th>
                <th>Metode Pembayaran</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($donations as $donation)

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

                <tr>

                    {{-- NUMBER --}}
                    <td class="donations-table__number">
                        {{ ($donations->firstItem() ?? 0) + $loop->index }}
                    </td>


                    {{-- DATE --}}
                    <td>
                        {{ $donation->donation_date->format('d-m-Y') }}
                    </td>


                    {{-- DONOR --}}
                    <td>

                        <div class="donations-table__donor">

                            <span class="donations-table__avatar">
                                {{ strtoupper(substr($donation->display_donor_name, 0, 1)) }}
                            </span>

                            <span>
                                {{ $donation->display_donor_name }}
                            </span>

                        </div>

                    </td>


                    {{-- AMOUNT --}}
                    <td class="donations-table__amount">
                        Rp {{ number_format((float) $donation->amount, 0, ',', '.') }}
                    </td>


                    {{-- CHANNEL --}}
                    <td>
                        {{ $donation->channel }}
                    </td>


                    {{-- PAYMENT METHOD --}}
                    <td>
                        {{ $donation->payment_method }}
                    </td>


                    {{-- CATEGORY --}}
                    <td>

                        <span class="donations-category">
                            {{ $donation->category }}
                        </span>

                    </td>


                    {{-- VERIFICATION STATUS --}}
                    <td>

                        <span class="donations-status donations-status--{{ $statusClass }}">

                            <span class="donations-status__dot"></span>

                            {{ $statusLabel }}

                        </span>

                    </td>


                    {{-- ACTIONS --}}
                    <td>

                        <div class="donations-table__actions">

                            <a
                                href="{{ route('donations.show', $donation) }}"
                                class="donations-table__action donations-table__action--detail"
                                aria-label="Lihat detail donasi {{ $donation->display_donor_name }}"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('donations.edit', $donation) }}"
                                class="donations-table__action donations-table__action--edit"
                                aria-label="Ubah donasi {{ $donation->display_donor_name }}"
                            >
                                Ubah
                            </a>

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

                {{-- EMPTY STATE --}}
                <tr>

                    <td colspan="9">

                        <div class="donations-table__empty">

                            <div class="donations-table__empty-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                                    <path d="M8 10h8M8 14h5"/>
                                </svg>

                            </div>

                            <h3>
                                Belum Ada Data Donasi
                            </h3>

                            <p>
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
