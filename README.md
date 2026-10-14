# WBS Donasi Masjid

Aplikasi web pengelolaan donasi masjid yang dikembangkan menggunakan Laravel.

## Persyaratan

- PHP
- Composer
- Git
- Database Supabase

## Cara Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/Adeliaswa/WBS-Donasi-Masjid.git
   cd WBS-Donasi-Masjid
   ```

2. Instal dependency:

   ```bash
   composer install
   ```

3. Buat file konfigurasi lokal:

   ```bash
   copy .env.example .env
   ```

4. Buat application key:

   ```bash
   php artisan key:generate
   ```

5. Atur konfigurasi koneksi database Supabase di file `.env`.

6. Bersihkan konfigurasi:

   ```bash
   php artisan config:clear
   ```

7. Jalankan migration:

   ```bash
   php artisan migrate
   ```

8. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

9. Buka `http://127.0.0.1:8000` di browser.

## Keamanan

Jangan mengunggah file `.env` atau membagikan kredensial database ke repository.
