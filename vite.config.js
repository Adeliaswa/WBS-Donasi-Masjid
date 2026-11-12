
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [

                // ==========================================
                // CSS UTAMA
                // ==========================================
                'resources/css/app.css',

                // ==========================================
                // CSS AUTHENTICATION
                // ==========================================
                'resources/css/auth.css',

                // ==========================================
                // CSS ADMIN
                // ==========================================
                'resources/css/admin-sidebar.css',
                'resources/css/admin-dashboard.css',
                'resources/css/admin-layout.css',
                'resources/css/admin-footer.css',

                // ==========================================
                // CSS DONASI
                // ==========================================
                'resources/css/admin-donations.css',
                'resources/css/admin-donation-form.css',
                'resources/css/admin-donation-show.css',

                // ==========================================
                // CSS PENERIMA MANFAAT
                // ==========================================
                'resources/css/admin-beneficiaries.css',
                'resources/css/admin-beneficiaries-form.css',
                'resources/css/admin-beneficiaries-show.css',
                'resources/css/beneficiary-categories.css',
                'resources/css/beneficiary-category-form.css',

                // ==========================================
                // CSS PENYALURAN
                // ==========================================
                'resources/css/admin-distributions.css',
                'resources/css/admin-distribution-form.css',
                'resources/css/admin-distribution-show.css',

                // ==========================================
                // CSS KEGIATAN
                // ==========================================
                'resources/css/admin-activities.css',
                'resources/css/admin-activity-form.css',
                'resources/css/admin-activity-show.css',

                // ==========================================
                // CSS LAPORAN
                // ==========================================
                'resources/css/admin-reports.css',

                // ==========================================
                // CSS TRANSPARANSI PUBLIK
                // ==========================================
                'resources/css/public/public.css',
                'resources/css/public/base.css',
                'resources/css/public/components.css',
                'resources/css/public/header.css',
                'resources/css/public/footer.css',
                'resources/css/public/hero.css',
                'resources/css/public/home.css',
                'resources/css/public/reports.css',
                'resources/css/public/responsive.css',

                // ==========================================
                // JAVASCRIPT UTAMA
                // ==========================================
                'resources/js/app.js',
                'resources/js/bootstrap.js',

                // ==========================================
                // JAVASCRIPT AUTHENTICATION
                // ==========================================
                'resources/js/auth.js',

                // ==========================================
                // JAVASCRIPT ADMIN
                // ==========================================
                'resources/js/admin-sidebar.js',
                'resources/js/admin-dashboard.js',

                // ==========================================
                // JAVASCRIPT DONASI
                // ==========================================
                'resources/js/admin-donations.js',

                // ==========================================
                // JAVASCRIPT PENERIMA MANFAAT
                // ==========================================
                'resources/js/admin-beneficiaries-show.js',
                'resources/js/admin-beneficiaries-form.js',
                'resources/js/beneficiary-categories.js',
                'resources/js/beneficiary-category-form.js',

                // ==========================================
                // JAVASCRIPT PENYALURAN
                // ==========================================
                'resources/js/admin-distributions.js',

                // ==========================================
                // JAVASCRIPT TRANSPARANSI PUBLIK
                // ==========================================
                'resources/js/public/public.js',
                'resources/js/public/header.js',
                'resources/js/public/home.js',
                'resources/js/public/reports.js',
                'resources/js/public/charts.js',
                'resources/js/public/filters.js',

                // ==========================================
                // IMAGES PUBLIC
                // ==========================================
                'resources/images/public/masjid-hero.webp',
                'resources/images/public/kajian.webp',

            ],

            refresh: true,
        }),

        tailwindcss(),
    ],

    server: {
        watch: {
            ignored: [
                '**/storage/framework/views/**',
            ],
        },
    },
});
