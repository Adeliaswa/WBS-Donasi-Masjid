
<section class="public-data-card">

    <div class="public-data-card__header">

        <div>
            <span class="public-eyebrow">
                STATISTIK PERIODE
            </span>

            <h2>Rekap Bulanan</h2>

            <p>
                Perbandingan total donasi dan penyaluran
                berdasarkan bulan dalam periode terpilih.
            </p>
        </div>

    </div>

    <div class="public-table-wrapper">

        <table class="public-table">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Bulan</th>
                    <th>Total Donasi</th>
                    <th>Total Penyaluran</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($monthlyRecap as $item)

                    <tr>

                        <td class="public-table__number">
                            {{ $loop->iteration }}
                        </td>

                        <td class="public-table__date">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $item['month'])->translatedFormat('F Y') }}
                        </td>

                        <td class="public-table__amount">
                            Rp {{ number_format($item['donation'], 0, ',', '.') }}
                        </td>

                        <td class="public-table__amount">
                            Rp {{ number_format($item['distribution'], 0, ',', '.') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4">

                            <div class="public-table-empty">

                                <strong>Belum Ada Data Bulanan</strong>

                                <span>
                                    Belum tersedia rekap transaksi untuk periode ini.
                                </span>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>
