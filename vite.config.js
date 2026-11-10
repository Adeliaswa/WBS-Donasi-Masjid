
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
                'resources/css/admin-reports.css',
                'resources/css/admin-activities.css',

                // ==========================================
                // CSS PENERIMA MANFAAT
                // ==========================================
                'resources/css/admin-beneficiaries.css',
                'resources/css/admin-beneficiaries-show.css',
                'resources/css/beneficiary-categories.css',
                'resources/css/beneficiary-category-form.css',

                // ==========================================
                // CSS PENYALURAN
                // ==========================================
                'resources/css/admin-distributions.css',
                'resources/css/admin-distribution-form.css',

                // ==========================================
                // CSS TRANSPARANSI PUBLIK
                // ==========================================
                'resources/css/public/public.css',

                // ==========================================
                // JAVASCRIPT UTAMA
                // ==========================================
                'resources/js/app.js',

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
