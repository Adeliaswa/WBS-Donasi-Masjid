
<section class="donations-summary" aria-label="Ringkasan donasi">

    {{-- TOTAL DONASI --}}
    <article class="donations-summary__card">

        <div class="donations-summary__top">

            <div class="donations-summary__icon donations-summary__icon--green">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <rect x="3" y="6" width="18" height="14" rx="2"/>
                    <path d="M3 10h18"/>
                    <path d="M7 15h3"/>
                </svg>
            </div>

            <span class="donations-summary__label">
                Total Donasi
            </span>

        </div>

        <div class="donations-summary__body">
            <h3>{{ $totalDonasi }}</h3>
            <p>Jumlah seluruh catatan donasi</p>
        </div>

    </article>


    {{-- MENUNGGU VERIFIKASI --}}
    <article class="donations-summary__card">

        <div class="donations-summary__top">

            <div class="donations-summary__icon donations-summary__icon--blue">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>

            <span class="donations-summary__label">
                Menunggu Verifikasi
            </span>

        </div>

        <div class="donations-summary__body">
            <h3>{{ $totalMenunggu }}</h3>
            <p>Data menunggu verifikasi</p>
        </div>

    </article>


    {{-- TERVERIFIKASI --}}
    <article class="donations-summary__card">

        <div class="donations-summary__top">

            <div class="donations-summary__icon donations-summary__icon--green">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="m8 12 2.5 2.5L16 9"/>
                </svg>
            </div>

            <span class="donations-summary__label">
                Terverifikasi
            </span>

        </div>

        <div class="donations-summary__body">
            <h3>{{ $totalTerverifikasi }}</h3>
            <p>Donasi yang telah diverifikasi</p>
        </div>

    </article>


    {{-- DITOLAK --}}
    <article class="donations-summary__card">

        <div class="donations-summary__top">

            <div class="donations-summary__icon donations-summary__icon--red">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="m9 9 6 6"/>
                    <path d="m15 9-6 6"/>
                </svg>
            </div>

            <span class="donations-summary__label">
                Ditolak
            </span>

        </div>

        <div class="donations-summary__body">
            <h3>{{ $totalDitolak }}</h3>
            <p>Donasi yang ditolak</p>
        </div>

    </article>

</section>
