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

                // CSS halaman donasi
                'resources/css/admin-donations.css',

                // CSS halaman tambah donasi
                'resources/css/admin-donation-form.css',

                // JavaScript utama
                'resources/js/app.js',

                // JavaScript halaman login
                'resources/js/auth.js',

                // JavaScript halaman donasi
                'resources/js/admin-donations.js',
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