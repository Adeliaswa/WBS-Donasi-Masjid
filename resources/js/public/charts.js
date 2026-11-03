
/* =========================================================
   PUBLIC CHARTS
   MASJID SABILILLAH
   CHART.JS
========================================================= */

import Chart from 'chart.js/auto';


/* =========================================================
   DESIGN COLORS
========================================================= */

const COLORS = {

    green: '#294236',
    greenDark: '#1b2b23',
    greenLight: 'rgba(41, 66, 54, 0.08)',

    blue: '#6b91cf',
    blueLight: 'rgba(107, 145, 207, 0.08)',

    muted: '#90958f',
    border: '#eceeeb',
    white: '#ffffff',

};


/* =========================================================
   CATEGORY CHART COLORS
   Formal and Professional
========================================================= */

const CATEGORY_COLORS = [

    '#294236',
    '#6688a8',
    '#8c9f8e',
    '#b49a73',
    '#8793a0',
    '#a6aaa4',

];


/* =========================================================
   MONTHS
========================================================= */

const MONTHS = [

    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'

];


/* =========================================================
   INITIALIZE ALL CHARTS
========================================================= */

export function initCharts() {

    initDonationDistributionChart();

    initDistributionCategoryChart();

}


/* =========================================================
   READ DATA FROM BLADE
========================================================= */

function getChartData(canvas) {

    if (!canvas) {
        return [];
    }

    const rawData = canvas.dataset.chart;

    if (!rawData) {

        console.warn(
            'Atribut data-chart tidak ditemukan.'
        );

        return [];

    }

    try {

        const data = JSON.parse(rawData);

        if (!Array.isArray(data)) {

            console.error(
                'Format data grafik harus berupa array.'
            );

            return [];

        }

        return data;

    } catch (error) {

        console.error(
            'Gagal membaca data grafik:',
            error
        );

        return [];

    }

}


/* =========================================================
   FORMAT RUPIAH
========================================================= */

function formatRupiah(value) {

    return new Intl.NumberFormat('id-ID', {

        style: 'currency',

        currency: 'IDR',

        maximumFractionDigits: 0

    }).format(Number(value) || 0);

}


/* =========================================================
   MONTH LABEL
========================================================= */

function getMonthLabel(month) {

    const monthNumber = Number(month);

    return MONTHS[monthNumber - 1] || 'Tidak diketahui';

}


/* =========================================================
   COMMON FONT
========================================================= */

function getCommonFont() {

    return {

        family: 'Poppins, sans-serif',

    };

}


/* =========================================================
   DONATION AND DISTRIBUTION CHART
========================================================= */

function initDonationDistributionChart() {

    const canvas = document.getElementById(
        'donationDistributionChart'
    );

    if (!canvas) {

        console.info(
            'Grafik donasi tidak ditemukan pada halaman ini.'
        );

        return;

    }


    const data = getChartData(canvas);

    if (!data.length) {

        console.warn(
            'Data grafik donasi dan penyaluran kosong.'
        );

        return;

    }


    // Mengurutkan data berdasarkan bulan

    const sortedData = [...data].sort(
        (a, b) => Number(a.month) - Number(b.month)
    );


    const labels = sortedData.map(item =>
        getMonthLabel(item.month)
    );


    const donationData = sortedData.map(item =>
        Number(item.donation) || 0
    );


    const distributionData = sortedData.map(item =>
        Number(item.distribution) || 0
    );


    // Memeriksa ketersediaan transaksi

    const hasData = [

        ...donationData,
        ...distributionData

    ].some(value => value > 0);


    if (!hasData) {

        console.info(
            'Belum terdapat transaksi pada periode grafik.'
        );

        return;

    }


    // Mencegah grafik ganda

    const existingChart = Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }


    new Chart(canvas, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [

                {

                    label: 'Donasi Masuk',

                    data: donationData,

                    borderColor: COLORS.green,

                    backgroundColor: COLORS.greenLight,

                    borderWidth: 2,

                    pointBackgroundColor: COLORS.green,

                    pointBorderColor: COLORS.white,

                    pointBorderWidth: 2,

                    pointRadius: 3,

                    pointHoverRadius: 4,

                    tension: 0.25,

                    fill: true,

                },

                {

                    label: 'Penyaluran',

                    data: distributionData,

                    borderColor: COLORS.blue,

                    backgroundColor: COLORS.blueLight,

                    borderWidth: 2,

                    pointBackgroundColor: COLORS.blue,

                    pointBorderColor: COLORS.white,

                    pointBorderWidth: 2,

                    pointRadius: 3,

                    pointHoverRadius: 4,

                    tension: 0.25,

                    fill: true,

                }

            ]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                intersect: false,

                mode: 'index',

            },


            // Tanpa animasi berlebihan

            animation: false,


            plugins: {

                legend: {

                    display: false,

                },


                tooltip: {

                    backgroundColor: COLORS.greenDark,

                    titleFont: {

                        ...getCommonFont(),

                        size: 11,

                        weight: '600',

                    },

                    bodyFont: {

                        ...getCommonFont(),

                        size: 10,

                    },

                    padding: 11,

                    cornerRadius: 5,

                    displayColors: true,

                    callbacks: {

                        label: context => {

                            return (

                                context.dataset.label +

                                ': ' +

                                formatRupiah(context.parsed.y)

                            );

                        }

                    }

                }

            },


            scales: {

                x: {

                    grid: {

                        display: false,

                    },

                    border: {

                        display: false,

                    },

                    ticks: {

                        color: COLORS.muted,

                        font: {

                            ...getCommonFont(),

                            size: 10,

                        },

                    }

                },


                y: {

                    beginAtZero: true,

                    border: {

                        display: false,

                    },

                    grid: {

                        color: COLORS.border,

                        drawTicks: false,

                    },

                    ticks: {

                        padding: 10,

                        color: COLORS.muted,

                        font: {

                            ...getCommonFont(),

                            size: 9,

                        },

                        callback: value => {

                            return new Intl.NumberFormat(

                                'id-ID',

                                {

                                    notation: 'compact',

                                    maximumFractionDigits: 1

                                }

                            ).format(value);

                        }

                    }

                }

            }

        }

    });


    console.log(
        'Grafik donasi dan penyaluran berhasil dibuat.'
    );

}


/* =========================================================
   DISTRIBUTION CATEGORY DOUGHNUT CHART
   FORMAL AND STATIC DESIGN
========================================================= */

function initDistributionCategoryChart() {

    const canvas = document.getElementById(
        'distributionCategoryChart'
    );

    if (!canvas) {

        console.info(
            'Grafik kategori tidak ditemukan pada halaman ini.'
        );

        return;

    }


    const data = getChartData(canvas);

    if (!data.length) {

        console.warn(
            'Data kategori penyaluran kosong.'
        );

        return;

    }


    // Hanya mengambil kategori dengan nominal positif

    const filteredData = data.filter(item =>
        Number(item.total) > 0
    );


    if (!filteredData.length) {

        console.info(
            'Belum ada nominal penyaluran untuk ditampilkan.'
        );

        return;

    }


    const labels = filteredData.map(item =>
        item.category
    );


    const values = filteredData.map(item =>
        Number(item.total) || 0
    );


    // Menentukan warna setiap kategori

    const colors = labels.map(
        (_, index) =>
            CATEGORY_COLORS[index % CATEGORY_COLORS.length]
    );


    // Menghapus grafik sebelumnya jika tersedia

    const existingChart = Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }


    // Membuat grafik donat

    new Chart(canvas, {

        type: 'doughnut',

        data: {

            labels: labels,

            datasets: [

                {

                    label: 'Total Penyaluran',

                    data: values,

                    backgroundColor: colors,

                    borderColor: '#ffffff',

                    // Pemisah antarbagian

                    borderWidth: 3,

                    borderAlign: 'inner',

                    // Jarak antarbagian sangat kecil

                    spacing: 1,

                    // Tidak ada efek membesar saat hover

                    hoverOffset: 0,

                    // Bentuk potongan tetap tegas

                    borderRadius: 0,

                    // Sudut awal lingkaran

                    rotation: -90,

                }

            ]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,


            // Ketebalan donat

            cutout: '62%',


            // Mengoptimalkan ukuran lingkaran

            radius: '96%',


            // Tidak menggunakan animasi

            animation: false,


            // Tidak menggunakan efek interaksi berlebihan

            events: [
                'mousemove',
                'mouseout',
                'click',
                'touchstart',
                'touchmove'
            ],


            plugins: {

                // Legenda menggunakan HTML Blade

                legend: {

                    display: false,

                },


                // Tooltip sederhana

                tooltip: {

                    enabled: true,

                    backgroundColor: COLORS.greenDark,

                    titleFont: {

                        ...getCommonFont(),

                        size: 11,

                        weight: '600',

                    },

                    bodyFont: {

                        ...getCommonFont(),

                        size: 10,

                    },

                    padding: 11,

                    cornerRadius: 5,

                    displayColors: true,

                    boxPadding: 4,

                    callbacks: {

                        label: context => {

                            return (

                                context.label +

                                ': ' +

                                formatRupiah(context.parsed)

                            );

                        },


                        afterLabel: context => {

                            const total = values.reduce(

                                (sum, value) => sum + value,

                                0

                            );


                            const percentage = total > 0

                                ? (context.parsed / total) * 100

                                : 0;


                            return (

                                percentage.toFixed(1) +

                                '% dari total penyaluran'

                            );

                        }

                    }

                }

            }

        }

    });


    // Menyamakan warna indikator dengan grafik

    updateCategoryLegendColors(colors);


    console.log(
        'Grafik kategori penyaluran berhasil dibuat.'
    );

}


/* =========================================================
   UPDATE CATEGORY LEGEND COLORS
========================================================= */

function updateCategoryLegendColors(colors) {

    const legend = document.querySelector(
        '.public-category-card__legend'
    );

    if (!legend) {
        return;
    }


    const items = legend.querySelectorAll(
        '.public-category-legend-item'
    );


    items.forEach((item, index) => {

        const dot = item.querySelector(
            '.public-category-legend-item__dot'
        );

        if (dot) {

            dot.style.backgroundColor =
                colors[index % colors.length];

        }

    });

}
