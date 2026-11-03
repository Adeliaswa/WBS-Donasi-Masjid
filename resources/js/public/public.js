
/* =========================================================
   PUBLIC JAVASCRIPT
   MASJID SABILILLAH
========================================================= */

import { initHome } from './home.js';
import { initReports } from './reports.js';
import { initCharts } from './charts.js';
import { initFilters } from './filters.js';


/* =========================================================
   INITIALIZE PUBLIC APPLICATION
========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    initHome();

    initReports();

    initCharts();

    initFilters();

    console.log('Public application berhasil dijalankan.');

});
