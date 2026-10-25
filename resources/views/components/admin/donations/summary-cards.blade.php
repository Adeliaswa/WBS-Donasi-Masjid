{{-- Ringkasan Pengelolaan Donasi --}}
<section class="donations-summary" aria-label="Ringkasan donasi">

    {{-- Total Donasi --}}
    <article class="donations-summary__card">
        <div class="donations-summary__top">
            <div class="donations-summary__icon donations-summary__icon--green">
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <rect x="3" y="6" width="18" height="14" rx="2"/>
                    <path d="M3 10h18"/>
                    <path d="M7 15h3"/>
                </svg>
            </div>

            <span class="donations-summary__label">Total Donasi</span>
        </div>

        <p class="donations-summary__value">
            {{ $totalDonasi }}
        </p>

        <p class="donations-summary__description">
            Jumlah seluruh catatan donasi
        </p>
    </article>

    {{-- Menunggu Verifikasi --}}
    <article class="donations-summary__card">
        <div class="donations-summary__top">
            <div class="donations-summary__icon donations-summary__icon--blue">
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>

            <span class="donations-summary__label">Menunggu Verifikasi</span>
        </div>

        <p class="donations-summary__value">
            {{ $totalMenunggu }}
        </p>

        <p class="donations-summary__description">
            Data menunggu verifikasi
        </p>
    </article>

    {{-- Donasi Terverifikasi --}}
    <article class="donations-summary__card">
        <div class="donations-summary__top">
            <div class="donations-summary__icon donations-summary__icon--green">
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="m8 12 2.5 2.5L16 9"/>
                </svg>
            </div>

            <span class="donations-summary__label">Terverifikasi</span>
        </div>

        <p class="donations-summary__value">
            {{ $totalTerverifikasi }}
        </p>

        <p class="donations-summary__description">
            Donasi yang telah diverifikasi
        </p>
    </article>

    {{-- Donasi Ditolak --}}
    <article class="donations-summary__card">
        <div class="donations-summary__top">
            <div class="donations-summary__icon donations-summary__icon--red">
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="m9 9 6 6"/>
                    <path d="m15 9-6 6"/>
                </svg>
            </div>

            <span class="donations-summary__label">Ditolak</span>
        </div>

        <p class="donations-summary__value">
            {{ $totalDitolak }}
        </p>

        <p class="donations-summary__description">
            Donasi yang ditolak
        </p>
    </article>

</section>