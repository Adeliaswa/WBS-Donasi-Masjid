
<section class="public-filter-card">

    <div class="public-filter-card__heading">

        <div>
            <h2>Filter Laporan</h2>

            <p>
                Pilih periode dan jenis laporan yang ingin dilihat.
            </p>
        </div>

        <div class="public-filter-card__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 5H20L14 12V19L10 17V12L4 5Z"
                      stroke="currentColor" stroke-width="1.7"
                      stroke-linejoin="round"/>
            </svg>
        </div>

    </div>

    <form
        action="{{ route('public.reports.index') }}"
        method="GET"
        class="public-filter-form"
    >

        <div class="public-filter-form__group">

            <label for="start_date">
                Dari Tanggal
            </label>

            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ $startDate }}"
                required
            >

        </div>

        <div class="public-filter-form__group">

            <label for="end_date">
                Sampai Tanggal
            </label>

            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ $endDate }}"
                required
            >

        </div>

        <div class="public-filter-form__group">

            <label for="report_type">
                Jenis Laporan
            </label>

            <select id="report_type" name="report_type">

                <option value="semua"
                    {{ $reportType === 'semua' ? 'selected' : '' }}>
                    Semua Laporan
                </option>

                <option value="donasi"
                    {{ $reportType === 'donasi' ? 'selected' : '' }}>
                    Donasi
                </option>

                <option value="penyaluran"
                    {{ $reportType === 'penyaluran' ? 'selected' : '' }}>
                    Penyaluran
                </option>

            </select>

        </div>

        <input type="hidden" name="tab" value="{{ $tab }}">

        <div class="public-filter-form__action">

            <button
                type="submit"
                class="public-button public-button--primary"
            >

                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <path
                        d="M4 10H16M10 4L16 10L10 16"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                Tampilkan Laporan

            </button>

        </div>

    </form>

</section>
