
<section class="public-data-card">

    <div class="public-data-card__header">

        <div>
            <span class="public-eyebrow">
                DATA DONASI
            </span>

            <h2>Rekap Donasi</h2>

            <p>
                Data donasi yang diterima Masjid Sabilillah
                pada periode yang dipilih.
            </p>
        </div>

        <a
            href="{{ route('public.reports.pdf.donations', [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]) }}"
            class="public-button public-button--download"
            target="_blank"
        >

            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M10 2V13M6 9L10 13L14 9M3 16V18H17V16"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>

            Download PDF

        </a>

    </div>

    <div class="public-table-wrapper">

        <table class="public-table">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($donations as $donation)

                    <tr>

                        <td class="public-table__number">
                            {{ $donations->firstItem() + $loop->index }}
                        </td>

                        <td class="public-table__date">
                            {{ \Carbon\Carbon::parse($donation->donation_date)->translatedFormat('d M Y') }}
                        </td>

                        <td>
                            <span class="public-table__category">
                                {{ $donation->category }}
                            </span>
                        </td>

                        <td class="public-table__amount">
                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $donation->payment_method }}
                        </td>

                        <td>
                            <span class="public-table__description">
                                -
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6">

                            <div class="public-table-empty">

                                <span class="public-table-empty__icon">
                                    <svg viewBox="0 0 32 32" fill="none" aria-hidden="true">
                                        <path d="M8 4H20L25 9V28H8V4Z"
                                              stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M20 4V9H25M12 15H21M12 20H21"
                                              stroke="currentColor" stroke-width="1.5"
                                              stroke-linecap="round"/>
                                    </svg>
                                </span>

                                <strong>Belum Ada Data Donasi</strong>

                                <span>
                                    Tidak ditemukan data donasi pada periode ini.
                                </span>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if ($donations->total() > 0)

        <div class="public-table-footer">

            <p>
                Menampilkan
                {{ $donations->firstItem() }}
                -
                {{ $donations->lastItem() }}
                dari
                {{ $donations->total() }}
                data
            </p>

            <div class="public-pagination">
                {{ $donations->links() }}
            </div>

        </div>

    @endif

</section>
