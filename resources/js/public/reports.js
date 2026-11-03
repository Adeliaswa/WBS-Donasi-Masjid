
/* =========================================================
   PUBLIC REPORTS JAVASCRIPT
   MASJID SABILILLAH
========================================================= */

export function initReports() {

    initReportTabs();

    initReportDownloads();

}


/* =========================================================
   REPORT TABS
========================================================= */

function initReportTabs() {

    const tabs = document.querySelectorAll(
        '.public-report-tab'
    );

    if (!tabs.length) {
        return;
    }


    tabs.forEach(tab => {

        const href = tab.getAttribute('href');

        if (!href) {
            return;
        }


        tab.addEventListener('click', () => {

            // Navigasi tab menggunakan URL GET Laravel.
            // Filter dan data tetap diproses oleh backend.

        });

    });

}


/* =========================================================
   REPORT PDF DOWNLOAD
========================================================= */

function initReportDownloads() {

    const downloadLinks = document.querySelectorAll(
        '[data-report-download]'
    );


    downloadLinks.forEach(link => {

        link.addEventListener('click', event => {

            const startDate = document.querySelector(
                '[name="start_date"]'
            );

            const endDate = document.querySelector(
                '[name="end_date"]'
            );


            if (
                !startDate ||
                !endDate ||
                !startDate.value ||
                !endDate.value
            ) {
                return;
            }


            if (startDate.value > endDate.value) {

                event.preventDefault();

                alert(
                    'Tanggal awal tidak boleh melebihi tanggal akhir.'
                );

            }

        });

    });

}
