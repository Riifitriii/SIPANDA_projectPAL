# SIPANDA

**Sistem Informasi Pengajuan dan Pendataan UMKM Kecamatan Cicalengka**

SIPANDA adalah sebuah platform berbasis web yang digunakan untuk mengelola proses pengajuan izin usaha dan pendataan pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) secara digital di wilayah Kecamatan Cicalengka. Aplikasi ini dirancang untuk mempermudah masyarakat dalam melakukan pendaftaran dan membantu admin kecamatan dalam mengelola data UMKM secara terstruktur.

---

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern berikut:
*   **Backend & Frontend Engine:** [Laravel 12](https://laravel.com/)
*   **Tampilan (UI):** [Tailwind CSS](https://tailwindcss.com/) & [Blade Templating Engine](https://laravel.com/docs/12.x/blade)
*   **Database:** MariaDB / MySQL (atau SQLite untuk pengembangan lokal cepat)

---

## 🚀 Panduan Instalasi (Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan project SIPANDA di mesin lokal Anda:

### Prasyarat
Sebelum memulai, pastikan perangkat Anda sudah terpasang:
*   PHP >= 8.2
*   [Composer](https://getcomposer.org/)
*   [Node.js & npm](https://nodejs.org/)
*   Server Database (MySQL/MariaDB, XAMPP, atau Laragon)

### Langkah-Langkah

1.  **Clone / Download Repository**
    Unduh source code proyek ini ke perangkat Anda.

2.  **Instalasi Dependensi PHP**
    Jalankan perintah berikut di terminal untuk memasang semua dependensi Composer:
    ```bash
    composer install
    ```

3.  **Salin File Environment**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    *(Di Windows CMD: `copy .env.example .env`)*

4.  **Generate Application Key**
    Buat key enkripsi untuk aplikasi Laravel Anda:
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` yang baru dibuat dan sesuaikan konfigurasi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sipanda
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    *Pastikan Anda sudah membuat database kosong bernama `sipanda` di server MySQL/MariaDB Anda.*

6.  **Jalankan Migrasi & Seeding**
    Buat tabel-tabel database beserta data awal (seeding) dengan perintah:
    ```bash
    php artisan migrate --seed
    ```

7.  **Instalasi & Build Aset Frontend**
    Instal dependensi Node.js lalu compile aset menggunakan Vite:
    ```bash
    npm install
    npm run build
    ```

8.  **Jalankan Server Lokal**
    Jalankan server pengembangan Laravel:
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang dapat diakses di browser melalui alamat: [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 📂 Struktur Proyek Utama
*   `app/` - Logika utama aplikasi (Controllers, Models, Middleware).
*   `database/` - Migrasi database, factory, dan seeder data awal.
*   `resources/views/` - File tampilan antarmuka (Blade Views).
*   `routes/web.php` - Definisi rute/URL aplikasi web.