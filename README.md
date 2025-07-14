**##Deskripsi Proyek **
Proyek ini adalah sistem yang mendukung untuk implementasi lingkungan keberlanjutan yaitu tentang perhitungan dan pelaporan emisi karbon dari perjalanan bisnis. Pada sistem ini pengguna dapat melakukan perhitungan emisi karbon yang dikeluarkan selama perjalanan bisnis, hasilnya langsung dapat dijadikan laporan dalam berbagai format. Di sistem ini memungkinkan bagi pengguna untuk melihat pelaporan emisi yang dikeluarkan selama perjalanan bisnis secara real time.

**## Library yang digunakan**

Berikut adalah beberapa library utama yang digunakan dalam proyek Laravel ini:

- **Laravel Framework:** `laravel/framework`, `laravel/ui`, `livewire/livewire`
- **PDF & Excel Export:** `barryvdh/laravel-dompdf`, `maatwebsite/excel`
- **Role & Permission:** `spatie/laravel-permission`
- **Modularisasi:** `nwidart/laravel-modules`
- **Testing & Debugging:** `phpunit/phpunit`, `fakerphp/faker`, `filp/whoops`
- **HTTP Client:** `guzzlehttp/guzzle`
- **Utilities:** `nesbot/carbon`, `brick/math`, `egulias/email-validator`
- **Environment Management:** `vlucas/phpdotenv`

## Langkah Langkah Instalasi Proyek

Persyaratan Sistem
Sebelum memulai, pastikan Anda sudah menginstall:

PHP >= 8.3
Composer
MySQL atau MariaDB
Node.js & NPM


### 1. Clone repository ini
[git clone https://github.com/DikaJefrianto/Agile_D4.git
cd Agile_D4

### 2. Install dependency PHP
composer install atau composer Update

### 3. Install dependency JavaScript
npm install

### 4. Copy dan sesuaikan file .env
cp .env.example .env

### 5. Generate APP_KEY
php artisan key:generate

### 6. Buat dan migrasi database
php artisan migrate

### 7. Jalankan seeder 
php artisan db:seed --> UserSeeder,RolePermissionSeeder, PerusahaanSeeder,KaryawanSeeder,SettingsSeeder

### 8. Compile assets
npm run dev   # untuk development

### 9. Jalankan Server
php artisan serve

