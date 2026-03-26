# 🏥 Klinik Pratama Orinda — Sistem Manajemen Klinik Laravel 12

> Sistem informasi klinik modern berbasis Laravel 12 dengan fitur booking online, manajemen dokter, payment gateway Midtrans, chat real-time, CRM analitik premium, dan SPK pemeringkatan dokter.

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Panduan Instalasi Lokal](#-panduan-instalasi-lokal)
- [Konfigurasi Payment Gateway](#-konfigurasi-payment-gateway-midtrans)
- [Deploy ke Production](#-deploy-ke-production)
- [Akun Default](#-akun-default-seeder)
- [Dokumentasi Sistem](#-dokumentasi-sistem)
- [Kontak & Lisensi](#-kontak--lisensi)

---

## 📖 Tentang Proyek

**Klinik Pratama Orinda** versi Laravel 12 adalah pembaruan besar dari versi PHP Native. Proyek ini mengedepankan keamanan sesi yang ketat, desain UI premium dengan standar modern (*Inter & Outfit fonts*), serta arsitektur yang lebih *scalable*.

Sistem ini mengelola tiga jenis pengguna: **Admin**, **Dokter**, dan **Pasien**, dengan proteksi route berbasis middleware dan sistem anti-cache untuk keamanan data pasca-logout.

---

## ✨ Fitur Utama (Edisi Premium)

### 👨‍💼 Panel Admin (Premium UI)
| Fitur | Deskripsi |
|---|---|
| **Dashboard Premium** | Ringkasan statistik dengan desain card modern dan tipografi bersih |
| **CRM Analitik** | Grafik tren kunjungan dan profil interaksi pasien yang mendalam |
| **SPK SAW** | Pemeringkatan dokter otomatis berdasarkan ulasan pasien secara *real-time* |
| **Manajemen Dokumen** | Tombol **Unduh Laporan .CSV** untuk rekapitulasi data cepat |
| **View-Only User List** | Monitoring akun pengguna dengan mode baca-saja untuk integritas data |
| **Kelola Dokter & Jadwal** | Manajemen profil dan waktu praktik dokter secara dinamis |

### 🧑‍⚕️ Panel Dokter
- Dashboard pasien harian dengan kontrol status sesi (aktif/selesai)
- Riwayat seluruh konsultasi pasien
- Ruang Chat real-time dengan pasien

### 🧑‍🤝‍🧑 Panel Pasien
- Booking online dengan pemilihan jadwal otomatis
- **Integrasi Midtrans Snap**: Pembayaran otomatis (QRIS, E-Wallet, VA, dll)
- Antrean Walk-in (Offline) instan
- Sistem Review & Rating Dokter (mempengaruhi SPK)
- Chat real-time dan Download riwayat chat (.txt)

---

## 🛠 Teknologi yang Digunakan

| Kategori | Teknologi |
|---|---|
| **Framework** | Laravel 12 (Stable) |
| **Database** | MySQL / MariaDB (Eloquent ORM) |
| **Frontend** | Tailwind CSS (CDN), Alpine.js (opsional), Google Fonts (Inter & Outfit) |
| **Payment** | Midtrans SNAP API Service |
| **Keamanan** | Custom Middleware (CheckRole, NoCache), CSRF Protection |

---

## 🚀 Panduan Instalasi Lokal

### Prasyarat
- XAMPP / Laragon (PHP 8.2+)
- [Composer](https://getcomposer.org/)

### Langkah Instalasi

**1. Clone & Masuk ke Folder**
```bash
cd klinik-laravel
```

**2. Install Dependencies**
```bash
composer install
```

**3. Konfigurasi Environment**
Salin `.env.example` menjadi `.env`, lalu atur koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_klinik
DB_USERNAME=root
DB_PASSWORD=
```

**4. Generate Key & Migrate**
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

**5. Jalankan Server**
```bash
php artisan serve
```
Akses di: `http://localhost:8000`

---

## 💳 Konfigurasi Payment Gateway (Midtrans)

1. Daftar akun di [dashboard.midtrans.com](https://dashboard.midtrans.com)
2. Pilih mode **Sandbox** untuk pengujian atau **Production** untuk live
3. Salin **Client Key** dan **Server Key** dari menu *Settings → Access Keys*
4. Tambahkan ke file `.env`:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

5. Untuk mode Production, ubah `MIDTRANS_IS_PRODUCTION=true` dan gunakan key Production

> ⚠️ **Penting:** Jangan pernah commit file `.env` yang berisi key Production ke repository publik.

---

## 🌐 Deploy ke Production

### Opsi A: Deploy ke VPS (Ubuntu + Nginx)

**1. Persiapan Server**
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server php8.2 php8.2-fpm php8.2-mbstring \
  php8.2-xml php8.2-curl php8.2-bcmath php8.2-zip php8.2-mysql unzip git
```

**2. Install Composer**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**3. Clone & Setup Project**
```bash
cd /var/www
sudo git clone https://github.com/username/klinik-laravel.git
cd klinik-laravel
sudo composer install --optimize-autoloader --no-dev
sudo cp .env.example .env
sudo nano .env   # Isi konfigurasi DB & Midtrans
sudo php artisan key:generate
sudo php artisan migrate --force --seed
```

**4. Atur Permission**
```bash
sudo chown -R www-data:www-data /var/www/klinik-laravel
sudo chmod -R 755 /var/www/klinik-laravel/storage
sudo chmod -R 755 /var/www/klinik-laravel/bootstrap/cache
```

**5. Konfigurasi Nginx**

Buat file konfigurasi Nginx:
```bash
sudo nano /etc/nginx/sites-available/klinik-laravel
```

Isi dengan:
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/klinik-laravel/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/klinik-laravel /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

**6. Optimasi Cache Laravel (Production)**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**7. (Opsional) SSL Gratis dengan Let's Encrypt**
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

### Opsi B: Deploy ke Shared Hosting (cPanel)

**1. Upload File Project**
- Zip seluruh folder `klinik-laravel` (kecuali folder `vendor`)
- Upload via **File Manager** cPanel ke direktori `public_html/klinik` atau subdomain
- Ekstrak file zip di server

**2. Install Dependencies via SSH**
```bash
cd ~/public_html/klinik-laravel
composer install --optimize-autoloader --no-dev
```

**3. Pindahkan Folder `public` ke Document Root**

Jika document root adalah `public_html`, pindahkan isi folder `public` ke sana:
```bash
cp -r public/* ../public_html/
```

Lalu edit `public_html/index.php`, ubah path berikut:
```php
// Dari:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// Menjadi (sesuaikan path ke folder project):
require __DIR__.'/../klinik-laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../klinik-laravel/bootstrap/app.php';
```

**4. Konfigurasi `.env`**
- Buat/upload file `.env` dengan konfigurasi database dari cPanel MySQL
- Pastikan `APP_ENV=production` dan `APP_DEBUG=false`

**5. Generate Key & Migrate**
```bash
php artisan key:generate
php artisan migrate --force --seed
php artisan config:cache
php artisan route:cache
```

**6. Konfigurasi `.htaccess`**

Pastikan file `.htaccess` di `public_html/` berisi:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### Checklist Deploy

- [ ] `APP_DEBUG=false` di `.env` production
- [ ] `APP_ENV=production` di `.env`
- [ ] Key Midtrans Production sudah diisi
- [ ] Permission `storage/` & `bootstrap/cache/` sudah `755`
- [ ] SSL/HTTPS sudah aktif
- [ ] `php artisan config:cache` sudah dijalankan
- [ ] `php artisan route:cache` sudah dijalankan

---

## 🔑 Akun Default (Seeder)

| Role | Username | Password |
|---|---|---|
| **Admin** | `admin` | `password123` |
| **Dokter** | `dokter1` | `password123` |
| **Pasien** | `pasien1` | `password123` |

> ⚠️ **Ganti password default** segera setelah deploy ke production!

---

## 📐 Dokumentasi Sistem

File dokumentasi diagram sistem tersimpan di folder `docs/`:

| Dokumen | File | Deskripsi |
|---|---|---|
| **Use Case Diagram** | [`docs/usecase.md`](docs/usecase.md) | Interaksi aktor (Admin, Dokter, Pasien) dengan sistem |
| **Activity Diagram** | [`docs/activity-diagram.md`](docs/activity-diagram.md) | Alur aktivitas proses utama (booking, pembayaran, dll) |
| **ERD** | [`docs/erd.md`](docs/erd.md) | Entity Relationship Diagram skema database |
| **Class Diagram** | [`docs/class-diagram.md`](docs/class-diagram.md) | Struktur kelas Model dan relasi antar objek |
| **Sequence Diagram** | [`docs/sequence-diagram.md`](docs/sequence-diagram.md) | Urutan interaksi objek per skenario |

---

## 📞 Kontak & Lisensi
Dikembangkan untuk keperluan akademik/portofolio. Bebas digunakan dengan tetap mencantumkan kredit pengembang.
