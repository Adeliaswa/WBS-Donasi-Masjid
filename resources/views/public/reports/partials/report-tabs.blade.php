
<section class="public-report-tabs-section">

    <div class="public-report-tabs-section__heading">

        <div>
            <h2>Jenis Rekap</h2>

            <p>
                Pilih jenis rekapitulasi untuk melihat detail
                informasi donasi dan penyaluran.
            </p>
        </div>

    </div>

    <nav class="public-report-tabs" aria-label="Jenis rekap">

        @php
            $tabs = [
                'donasi' => [
                    'label' => 'Rekap Donasi',
                    'icon' => 'document'
                ],
                'penyaluran' => [
                    'label' => 'Rekap Penyaluran',
                    'icon' => 'box'
                ],
                'kategori' => [
                    'label' => 'Rekap Kategori',
                    'icon' => 'chart'
                ],
                'bulanan' => [
                    'label' => 'Rekap Bulanan',
                    'icon' => 'calendar'
                ],
            ];
        @endphp

        @foreach ($tabs as $key => $item)

            <a
                href="{{ route('public.reports.index', array_merge(request()->query(), ['tab' => $key])) }}"
                class="public-report-tab {{ $tab === $key ? 'active' : '' }}"
                @if ($tab === $key) aria-current="page" @endif
            >

                @if ($key === 'donasi')
                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M5 2H12L16 6V18H5V2Z"
                              stroke="currentColor" stroke-width="1.5"/>
                        <path d="M12 2V6H16M8 10H13M8 13H13"
                              stroke="currentColor" stroke-width="1.5"/>
                    </svg>

                @elseif ($key === 'penyaluran')
                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M2 6L10 2L18 6V17H2V6Z"
                              stroke="currentColor" stroke-width="1.5"/>
                        <path d="M2 6H18M10 2V17"
                              stroke="currentColor" stroke-width="1.5"/>
                    </svg>

                @elseif ($key === 'kategori')
                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M3 16V10M8 16V5M13 16V8M18 16V2"
                              stroke="currentColor" stroke-width="1.7"
                              stroke-linecap="round"/>
                    </svg>

                @else
                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <rect x="3" y="4" width="14" height="14" rx="2"
                              stroke="currentColor" stroke-width="1.5"/>
                        <path d="M6 2V6M14 2V6M3 8H17"
                              stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                @endif

                {{ $item['label'] }}

            </a>

        @endforeach

    </nav>

</section>
