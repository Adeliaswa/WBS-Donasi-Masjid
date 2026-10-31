
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS utama
                'resources/css/app.css',

                // CSS halaman login
                'resources/css/auth.css',

                // CSS sidebar admin
                'resources/css/admin-sidebar.css',
                
                'resources/css/admin-dashboard.css',

                'resources/css/admin-layout.css',

                // CSS halaman donasi
                'resources/css/admin-donations.css',

                // CSS halaman tambah donasi
                'resources/css/admin-donation-form.css',

                // CSS halaman penerima manfaat
                'resources/css/beneficiaries.css',

                // CSS halaman menampilkan penerima manfaat
                'resources/css/admin-beneficiaries-show.css',

                'resources/css/beneficiary-categories.css',

                'resources/css/beneficiary-category-form.css',

                'resources/css/admin-distributions.css',

                'resources/css/admin-distribution-form.css',
                'resources/css/admin-footer.css',

                // JavaScript utama
                'resources/js/app.js',

                // JavaScript halaman login
                'resources/js/auth.js',

                // JavaScript sidebar admin
                'resources/js/admin-sidebar.js',

                'resources/js/admin-dashboard.js',

                // JavaScript halaman donasi
                'resources/js/admin-donations.js',

                'resources/js/admin-beneficiaries-show.js',

                'resources/js/admin-beneficiaries-form.js',

                'resources/js/beneficiary-categories.js',
        
                'resources/js/beneficiary-category-form.js',
                
                'resources/js/admin-distributions.js'
                
                
            ],
            refresh: true,
        }),

        tailwindcss(),
    ],

    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
