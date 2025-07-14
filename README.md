## Deskripsi Proyek
Proyek ini merupakan sistem digital yang mendukung implementasi prinsip keberlanjutan lingkungan, khususnya dalam hal perhitungan dan pelaporan emisi karbon dari perjalanan bisnis. Sistem ini memungkinkan pengguna untuk menghitung emisi karbon yang dihasilkan selama perjalanan, serta menyajikan hasil perhitungan tersebut dalam berbagai format laporan secara otomatis.
Dirancang untuk mempermudah perusahaan dalam menghitung, memantau, dan mengelola emisi karbon secara efisien dan akurat. Solusi ini hadir untuk menggantikan proses pelaporan manual yang selama ini memakan waktu hingga 3–7 bulan, dengan pelaporan harian oleh karyawan dan output laporan yang telah terstandar GRI dalam hitungan detik.

## Library yang digunakan

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

PHP >= 8.3,
Composer,
MySQL atau MariaDB,
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

### 5. Buat dan migrasi database
php artisan migrate

### 6. Jalankan seeder 
php artisan db:seed --> UserSeeder,RolePermissionSeeder, PerusahaanSeeder,KaryawanSeeder,SettingsSeeder

### 7. Compile assets
npm run dev   # untuk development

### 8. Jalankan Server
php artisan serve





### Akun untuk Akses Login
Email : superadmin@example.com
password : 12345678
