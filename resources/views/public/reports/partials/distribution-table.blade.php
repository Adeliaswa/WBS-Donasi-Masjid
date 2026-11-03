
<section class="public-data-card">

    <div class="public-data-card__header">

        <div>
            <span class="public-eyebrow">
                DATA PENYALURAN
            </span>

            <h2>Rekap Penyaluran Bantuan</h2>

            <p>
                Data penyaluran bantuan sosial Masjid Sabilillah
                pada periode yang dipilih.
            </p>
        </div>

        <a
            href="{{ route('public.reports.pdf.distributions', [
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
                    <th>Jenis Bantuan</th>
                    <th>Jumlah Penerima</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($distributions as $distribution)

                    <tr>

                        <td class="public-table__number">
                            {{ $distributions->firstItem() + $loop->index }}
                        </td>

                        <td class="public-table__date">
                            {{ \Carbon\Carbon::parse($distribution->distribution_date)->translatedFormat('d M Y') }}
                        </td>

                        <td>
                            <span class="public-table__category">
                                {{ $distribution->assistance_type }}
                            </span>
                        </td>

                        <td>
                            <span class="public-recipient-count">
                                {{ number_format($distribution->recipient_count, 0, ',', '.') }}
                                orang
                            </span>
                        </td>

                        <td class="public-table__amount">
                            Rp {{ number_format($distribution->amount, 0, ',', '.') }}
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
                                        <path d="M4 10L16 4L28 10V27H4V10Z"
                                              stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M4 10H28M16 4V27"
                                              stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                </span>

                                <strong>Belum Ada Data Penyaluran</strong>

                                <span>
                                    Tidak ditemukan data penyaluran pada periode ini.
                                </span>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if ($distributions->total() > 0)

        <div class="public-table-footer">

            <p>
                Menampilkan
                {{ $distributions->firstItem() }}
                -
                {{ $distributions->lastItem() }}
                dari
                {{ $distributions->total() }}
                data
            </p>

            <div class="public-pagination">
                {{ $distributions->links() }}
            </div>

        </div>

    @endif

</section>
