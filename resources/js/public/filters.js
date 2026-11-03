
/* =========================================================
   PUBLIC REPORT FILTERS
   MASJID SABILILLAH
========================================================= */

export function initFilters() {

    initDateFilter();

    initReportTypeFilter();

}


/* =========================================================
   DATE FILTER
========================================================= */

function initDateFilter() {

    const form = document.querySelector(
        '.public-filter-form'
    );

    if (!form) {
        return;
    }


    const startDate = form.querySelector(
        '[name="start_date"]'
    );

    const endDate = form.querySelector(
        '[name="end_date"]'
    );


    if (!startDate || !endDate) {
        return;
    }


    function validateDateRange() {

        const start = startDate.value;

        const end = endDate.value;


        if (start) {

            endDate.min = start;

        } else {

            endDate.removeAttribute('min');

        }


        if (end) {

            startDate.max = end;

        } else {

            startDate.removeAttribute('max');

        }

    }


    startDate.addEventListener(
        'change',
        validateDateRange
    );


    endDate.addEventListener(
        'change',
        validateDateRange
    );


    form.addEventListener('submit', event => {

        const start = startDate.value;

        const end = endDate.value;


        if (!start || !end) {

            event.preventDefault();

            alert(
                'Silakan lengkapi tanggal awal dan tanggal akhir laporan.'
            );

            if (!start) {

                startDate.focus();

            } else {

                endDate.focus();

            }

            return;

        }


        if (start > end) {

            event.preventDefault();

            alert(
                'Tanggal awal tidak boleh melebihi tanggal akhir. Silakan periksa kembali periode laporan.'
            );

            startDate.focus();

        }

    });


    validateDateRange();

}


/* =========================================================
   REPORT TYPE FILTER
========================================================= */

function initReportTypeFilter() {

    const form = document.querySelector(
        '.public-filter-form'
    );

    if (!form) {
        return;
    }


    const reportType = form.querySelector(
        '[name="report_type"]'
    );

    if (!reportType) {
        return;
    }


    reportType.addEventListener('change', () => {

        reportType.dataset.changed = 'true';

    });

}
