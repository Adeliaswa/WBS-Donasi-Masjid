
<section class="public-data-card">

    <div class="public-data-card__header">

        <div>
            <span class="public-eyebrow">
                DISTRIBUSI DANA
            </span>

            <h2>Rekap Berdasarkan Kategori</h2>

            <p>
                Rincian total dana penyaluran berdasarkan
                kategori bantuan sosial.
            </p>
        </div>

    </div>

    <div class="public-table-wrapper">

        <table class="public-table">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kategori Bantuan</th>
                    <th>Total Nominal</th>
                    <th>Persentase</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($categoryRecap as $item)

                    <tr>

                        <td class="public-table__number">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <span class="public-table__category">
                                {{ $item['category'] }}
                            </span>
                        </td>

                        <td class="public-table__amount">
                            Rp {{ number_format($item['total'], 0, ',', '.') }}
                        </td>

                        <td>

                            <div class="public-percentage">

                                <div class="public-percentage__bar">
                                    <span style="width: {{ min(100, max(0, $item['percentage'])) }}%"></span>
                                </div>

                                <strong>
                                    {{ number_format($item['percentage'], 2, ',', '.') }}%
                                </strong>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4">

                            <div class="public-table-empty">
                                <strong>Belum Ada Data Kategori</strong>

                                <span>
                                    Belum tersedia data penyaluran berdasarkan kategori.
                                </span>
                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>
