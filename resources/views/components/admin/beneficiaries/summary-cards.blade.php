
{{-- Ringkasan Data Penerima Manfaat --}}
<section class="beneficiaries-summary" aria-label="Ringkasan penerima manfaat">

    {{-- Total Penerima --}}
    <article class="beneficiaries-summary__card">
        <div class="beneficiaries-summary__top">
            <div class="beneficiaries-summary__icon beneficiaries-summary__icon--green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="9" cy="8" r="3"/>
                    <path d="M3 20v-1a6 6 0 0 1 12 0v1"/>
                    <path d="M16 11a3 3 0 0 0 0-6"/>
                    <path d="M18 14a5 5 0 0 1 3 5v1"/>
                </svg>
            </div>

            <span class="beneficiaries-summary__label">Total Penerima</span>
        </div>

        <p class="beneficiaries-summary__value">
            {{ number_format($summary['total'], 0, ',', '.') }}
        </p>

        <p class="beneficiaries-summary__description">
            Seluruh penerima terdaftar
        </p>
    </article>

    {{-- Penerima Aktif --}}
    <article class="beneficiaries-summary__card">
        <div class="beneficiaries-summary__top">
            <div class="beneficiaries-summary__icon beneficiaries-summary__icon--blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    <path d="m9 13 2 2 4-4"/>
                </svg>
            </div>

            <span class="beneficiaries-summary__label">Penerima Aktif</span>
        </div>

        <p class="beneficiaries-summary__value">
            {{ number_format($summary['active'], 0, ',', '.') }}
        </p>

        <p class="beneficiaries-summary__description">
            Penerima berstatus aktif
        </p>
    </article>

    {{-- Penerima Baru Bulan Ini --}}
    <article class="beneficiaries-summary__card">
        <div class="beneficiaries-summary__top">
            <div class="beneficiaries-summary__icon beneficiaries-summary__icon--orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                    <path d="M16 3v4M8 3v4M3 10h18"/>
                    <path d="M12 13v5M9.5 15.5h5"/>
                </svg>
            </div>

            <span class="beneficiaries-summary__label">Penerima Baru</span>
        </div>

        <p class="beneficiaries-summary__value">
            {{ number_format($summary['new_this_month'], 0, ',', '.') }}
        </p>

        <p class="beneficiaries-summary__description">
            Terdaftar bulan ini
        </p>
    </article>

    {{-- Penerima Tidak Aktif --}}
    <article class="beneficiaries-summary__card">
        <div class="beneficiaries-summary__top">
            <div class="beneficiaries-summary__icon beneficiaries-summary__icon--red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    <path d="m9 9 6 6M15 9l-6 6"/>
                </svg>
            </div>

            <span class="beneficiaries-summary__label">Tidak Aktif</span>
        </div>

        <p class="beneficiaries-summary__value">
            {{ number_format($summary['inactive'], 0, ',', '.') }}
        </p>

        <p class="beneficiaries-summary__description">
            Penerima berstatus tidak aktif
        </p>
    </article>

</section>
