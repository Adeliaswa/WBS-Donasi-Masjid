
<section class="public-activities" id="kegiatan">

    <div class="public-container">

        <div class="public-section-heading public-section-heading--row">

            <div>
                <span class="public-eyebrow">
                    DOKUMENTASI KEGIATAN
                </span>

                <h2 class="public-section-title">
                    Kegiatan Terbaru
                </h2>

                <p class="public-section-description">
                    Dokumentasi kegiatan penyaluran bantuan
                    sosial Masjid Sabilillah.
                </p>
            </div>

        </div>

        @if ($latestActivities->isNotEmpty())

            <div class="public-activities__grid">

                @foreach ($latestActivities as $activity)

                    <article class="public-activity-card">

                        <div class="public-activity-card__image">

                            @if ($activity->image_path)

                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($activity->image_path) }}"
                                    alt="Dokumentasi {{ $activity->title }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="public-activity-card__placeholder">
                                    <svg viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                        <rect x="5" y="8" width="38" height="32" rx="4"
                                              stroke="currentColor" stroke-width="1.5"/>
                                        <circle cx="17" cy="19" r="4"
                                                stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M7 35L19 25L27 32L34 25L42 33"
                                              stroke="currentColor" stroke-width="1.5"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>

                                    <span>Dokumentasi Kegiatan</span>
                                </div>

                            @endif

                        </div>

                        <div class="public-activity-card__content">

                            <span class="public-activity-card__date">
                                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <rect x="3" y="4" width="14" height="13" rx="2"
                                          stroke="currentColor" stroke-width="1.4"/>
                                    <path d="M6 2V6M14 2V6M3 8H17"
                                          stroke="currentColor" stroke-width="1.4"
                                          stroke-linecap="round"/>
                                </svg>

                                {{ $activity->activity_date->translatedFormat('d F Y') }}
                            </span>

                            <h3>
                                {{ $activity->title }}
                            </h3>

                            <p>
                                {{ $activity->description ?: 'Dokumentasi kegiatan sosial Masjid Sabilillah.' }}
                            </p>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="public-empty-state">

                <div class="public-empty-state__icon">
                    <svg viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect x="7" y="7" width="34" height="34" rx="5"
                              stroke="currentColor" stroke-width="1.7"/>
                        <path d="M15 17H33M15 24H33M15 31H26"
                              stroke="currentColor" stroke-width="1.7"
                              stroke-linecap="round"/>
                    </svg>
                </div>

                <h3>Belum Ada Kegiatan</h3>

                <p>
                    Dokumentasi kegiatan terbaru akan ditampilkan
                    di halaman ini setelah dipublikasikan.
                </p>

            </div>

        @endif

    </div>

</section>
