<<<<<<< HEAD
# Aplikasi Toko Online - CodeIgniter 4

Aplikasi toko online berbasis web yang dibangun menggunakan framework CodeIgniter 4 dengan fitur manajemen produk, sistem diskon, keranjang belanja, dan integrasi API pengiriman

## Fitur

### 🛍️ **Manajemen Produk**
- **CRUD Produk**: Tambah, edit, hapus, dan lihat daftar produk
- **Kategori Produk**: Pengelompokan produk berdasarkan kategori
- **Upload Gambar**: Fitur upload foto produk dengan validasi format dan ukuran
- **Download Data**: Export data produk ke format Excel/CSV

### 👥 **Sistem Autentikasi & Otorisasi**
- **Multi-role User**: Admin dan Customer dengan akses yang berbeda
- **Session Management**: Pengelolaan sesi pengguna yang aman
- **Password Encryption**: Enkripsi password menggunakan PHP password_hash()
- **Login/Logout**: Sistem masuk dan keluar yang secure

### 🎯 **Sistem Diskon**
- **Manajemen Diskon Harian**: Admin dapat mengatur diskon berdasarkan tanggal
- **Validasi Tanggal Unik**: Tidak boleh ada duplikasi diskon untuk tanggal yang sama
- **Tampilan Real-time**: Notifikasi diskon aktif di header website
- **Edit Readonly**: Form edit diskon dengan tanggal yang tidak bisa diubah
- **Auto Apply**: Diskon otomatis diterapkan saat login berdasarkan tanggal

### 🛒 **Keranjang Belanja (Shopping Cart)**
- **Add to Cart**: Menambahkan produk ke keranjang dengan diskon otomatis
- **Cart Management**: Edit quantity, hapus item, kosongkan keranjang
- **Price Calculation**: Perhitungan harga dengan diskon real-time
- **Session Storage**: Keranjang tersimpan dalam sesi browser

### 🚚 **Sistem Pengiriman**
- **Integrasi RajaOngkir API**: Cek ongkos kirim ke seluruh Indonesia
- **Location Search**: Pencarian lokasi tujuan dengan autocomplete
- **Shipping Options**: Pilihan layanan pengiriman (JNE, TIKI, POS)
- **Cost Calculator**: Kalkulasi biaya pengiriman otomatis

### 💳 **Transaksi & Checkout**
- **Checkout Process**: Proses pembelian dengan form alamat dan ongkir
- **Transaction Detail**: Penyimpanan detail transaksi dan item yang dibeli
- **Discount Tracking**: Pencatatan diskon yang diterapkan per item
- **Order History**: Riwayat transaksi pembelian user

### 📊 **Dashboard & Reporting**
- **Admin Dashboard**: Panel admin untuk mengelola seluruh sistem
- **Transaction Dashboard**: Dashboard terpisah untuk melihat data transaksi
- **API Integration**: Webservice untuk mengakses data transaksi
- **Real-time Data**: Data yang selalu terupdate dengan auto-refresh

### 🔌 **API & Webservice**
- **RESTful API**: API untuk mengakses data transaksi
- **API Authentication**: Sistem autentikasi API menggunakan API Key
- **JSON Response**: Format response yang standar dan konsisten
- **External Dashboard**: Dashboard terpisah yang mengonsumsi API

## Instalasi

### Prasyarat Sistem
- **PHP**: Versi 7.4 atau lebih tinggi (disarankan PHP 8.1+)
- **Web Server**: Apache/Nginx dengan mod_rewrite
- **Database**: MySQL 5.7+ atau MariaDB 10.3+
- **Composer**: Package manager untuk PHP
- **Extensions**: intl, mbstring, json, mysqlnd, curl

### Langkah Instalasi

#### 1. Clone/Download Project
```bash
git clone <repository-url>
cd belajar-ci
```

#### 2. Install Dependencies
```bash
composer install
```

#### 3. Konfigurasi Environment
```bash
# Copy file environment
cp env .env

# Edit file .env sesuai konfigurasi server Anda
```

#### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan pengaturan database:
```env
database.default.hostname = localhost
database.default.database = nama_database
database.default.username = username_db
database.default.password = password_db
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306
```

#### 5. Konfigurasi API Keys
Tambahkan konfigurasi API di file `.env`:
```env
# API Key untuk internal webservice
API_KEY = random123678abcghi

# RajaOngkir API Key (daftar di rajaongkir.com)
COST_KEY = pzsaabTx6d84e93992b56070guhCr1D1

# Base URL aplikasi
app.baseURL = 'http://localhost:8080/'

# Timezone
app.appTimezone = 'Asia/Jakarta'
```

#### 6. Setup Database
```bash
# Jalankan migrasi database
php spark migrate

# Jalankan seeder untuk data awal
php spark db:seed UserSeeder
php spark db:seed ProductSeeder
php spark db:seed ProductDiskonSeeder
```

#### 7. Setup Permissions
```bash
# Pastikan folder writable dapat ditulis
chmod -R 755 writable/
chmod -R 755 public/img/
```

#### 8. Jalankan Server
```bash
# Development server
php spark serve

# Atau gunakan web server seperti Apache/Nginx
# Arahkan document root ke folder public/
```

### Akses Aplikasi
- **URL Utama**: http://localhost:8080/
- **Dashboard API**: http://localhost/dashboard-toko/

### Data Login Default
```
Admin:
- Username: jwibowo
- Password: 1234567

Customer:
- Username: kani35 
- Password: 1234567
```

## Struktur Proyek

```
belajar-ci/
├── app/
│   ├── Config/
│   │   ├── App.php                 # Konfigurasi aplikasi
│   │   ├── Routes.php              # Routing aplikasi
│   │   ├── Filters.php             # Filter autentikasi
│   │   └── dan lainnya...             
|   |   
│   ├── Controllers/
│   │   ├── AuthController.php      # Autentikasi & login
│   │   ├── Home.php               # Controller utama
│   │   ├── ProdukController.php   # Manajemen produk
│   │   ├── DiskonController.php   # Manajemen diskon
│   │   ├── TransaksiController.php # Keranjang & transaksi
│   │   └── ApiController.php      # API webservice
│   ├── Models/
│   │   ├── UserModel.php          # Model user
│   │   ├── ProductModel.php       # Model produk
│   │   ├── ProductDiskonModel.php # Model diskon
│   │   ├── TransactionModel.php   # Model transaksi
│   │   └── TransactionDetailModel.php # Model detail transaksi
│   ├── Views/
│   │   ├── layout.php             # Template utama
│   │   ├── layout_clear.php             # Template clear
│   │   ├── components/
│   │   │   ├── header.php         # Header dengan notifikasi diskon
│   │   │   ├── footer.php         # footer
│   │   │   └── sidebar.php        # Sidebar navigasi
│   │   ├── v_home.php             # Halaman utama produk
│   │   ├── v_faq.php              # Halaman utama faq
│   │   ├── v_produk.php           # Halaman utama produk
│   │   ├── v_produkPDF.php        # Halaman PDF
│   │   ├── v_login.php            # Halaman login
│   │   ├── v_produk.php           # Manajemen produk
│   │   ├── v_diskon.php           # Manajemen diskon
│   │   ├── v_keranjang.php        # Halaman keranjang
│   │   ├── v_checkout.php         # Halaman checkout
│   │   └── v_profile.php          # Riwayat transaksi
│   ├── Database/
│   │   ├── Migrations/
│   │   │   ├── 2025-xxx-User.php
│   │   │   ├── 2025-xxx-Product.php
│   │   │   ├── 2025-xxx-Transaction.php
│   │   │   ├── 2025-xxx-TransactionDetail.php
│   │   │   └── 2025-07-02-ProductDiskon.php
│   │   └── Seeds/
│   │       ├── UserSeeder.php
│   │       ├── ProductSeeder.php
│   │       └── ProductDiskonSeeder.php
│   └── Filters/
│       └── Auth.php               # Filter autentikasi
├── public/
│   ├── index.php                  # Entry point aplikasi
│   ├── img/                       # Folder upload gambar produk
│   ├── NiceAdmin/                 # Template CSS/JS
│   └── dashboard-toko/
│       └── index.php              # Dashboard eksternal API
├── writable/
│   ├── cache/                     # Cache aplikasi
│   ├── logs/                      # Log sistem
│   └── session/                   # Session storage
├── vendor/                        # Dependencies Composer
├── .env                          # Konfigurasi environment
├── composer.json                 # Dependencies PHP
└── README.md                     # Dokumentasi ini
```

## Teknologi yang Digunakan

### Backend
- **CodeIgniter 4**: Framework PHP untuk rapid development
- **PHP 8.1+**: Bahasa pemrograman server-side
- **MySQL**: Database relational untuk menyimpan data
- **Composer**: Dependency manager untuk PHP

### Frontend
- **Bootstrap 5**: Framework CSS responsive
- **jQuery**: Library JavaScript untuk interaktivitas
- **Select2**: Plugin untuk dropdown dengan search
- **DataTables**: Plugin untuk tabel dengan fitur sorting/filtering
- **Bootstrap Icons**: Icon set untuk UI

### External Services
- **RajaOngkir API**: Layanan cek ongkos kirim Indonesia
- **Guzzle HTTP**: HTTP client untuk API calls

### Features & Libraries
- **CodeIgniter Cart**: Library untuk keranjang belanja
- **Password Hashing**: Keamanan password menggunakan PHP native
- **Session Management**: Pengelolaan sesi user
- **File Upload**: Upload dan validasi file gambar
- **Form Validation**: Validasi input form
- **Database Migration**: Versi kontrol database
- **Database Seeding**: Data awal untuk development

## API Documentation

### Authentication
Semua endpoint API memerlukan header authentication:
```
Key: your-api-key-here
```

### Endpoints

#### GET /api
Mengambil semua data transaksi dengan detail
```json
Response:
{
  "status": {
    "code": 200,
    "description": "OK"
  },
  "results": [
    {
      "id": 1,
      "username": "customer123",
      "total_harga": 1500000,
      "alamat": "Jl. Contoh No. 123",
      "ongkir": 15000,
      "status": 1,
      "total_item": 3,
      "total_diskon": 150000,
      "created_at": "2025-07-03 10:30:00",
      "details": [...]
    }
  ]
}
```

## Troubleshooting

### Masalah Umum

1. **Timezone Issue**: Pastikan `app.appTimezone = 'Asia/Jakarta'` di `.env`
2. **Database Connection**: Periksa konfigurasi database di file `.env`
3. **File Permissions**: Pastikan folder `writable/` dan `public/img/` dapat ditulis
4. **API Key**: Pastikan API key RajaOngkir sudah benar dan aktif
5. **Mod Rewrite**: Pastikan mod_rewrite Apache sudah aktif

### Debug Mode
Untuk development, aktifkan debug mode di `.env`:
```env
CI_ENVIRONMENT = development
```

## Kontribusi

1. Fork repository ini
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## Kontak

Developer: [Kent Pradana]
Email: [kenpradana8880@gmail.com]
Project Link: [https://github.com/username/project-name]

---

**Catatan**: Aplikasi ini dibuat untuk keperluan pembelajaran dan development. Untuk production, pastikan melakukan security audit dan optimisasi performance yang sesuai.
=======
# Toko Online CodeIgniter 4

Proyek ini adalah platform toko online yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Sistem ini menyediakan beberapa fungsionalitas untuk toko online, termasuk manajemen produk, keranjang belanja, dan sistem transaksi.

## Daftar Isi

- [Fitur](#fitur)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Struktur Proyek](#struktur-proyek)

## Fitur

- Katalog Produk
  - Tampilan produk dengan gambar
  - Pencarian produk
- Keranjang Belanja
  - Tambah/hapus produk
  - Update jumlah produk
- Sistem Transaksi
  - Proses checkout
  - Riwayat transaksi
- Panel Admin
  - Manajemen produk (CRUD)
  - Manajemen kategori
  - Laporan transaksi
  - Export data ke PDF
- Sistem Autentikasi
  - Login/Register pengguna
  - Manajemen akun
- UI Responsif dengan NiceAdmin template

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Web server (XAMPP)

## Instalasi

1. **Clone repository ini**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas
   ```
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Konfigurasi database**

   - Start module Apache dan MySQL pada XAMPP
   - Buat database **db_ci4** di phpmyadmin.
   - copy file .env dari tutorial https://www.notion.so/april-ns/Codeigniter4-Migration-dan-Seeding-045ffe5f44904e5c88633b2deae724d2

4. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
5. **Seeder data**
   ```bash
   php spark db:seed ProductSeeder
   ```
   ```bash
   php spark db:seed UserSeeder
   ```
6. **Jalankan server**
   ```bash
   php spark serve
   ```
7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8080` untuk melihat aplikasi.

## Struktur Proyek

Proyek menggunakan struktur MVC CodeIgniter 4:

- app/Controllers - Logika aplikasi dan penanganan request
  - AuthController.php - Autentikasi pengguna
  - ProdukController.php - Manajemen produk
  - TransaksiController.php - Proses transaksi
- app/Models - Model untuk interaksi database
  - ProductModel.php - Model produk
  - UserModel.php - Model pengguna
- app/Views - Template dan komponen UI
  - v_produk.php - Tampilan produk
  - v_keranjang.php - Halaman keranjang
- public/img - Gambar produk dan aset
- public/NiceAdmin - Template admin
>>>>>>> e42709f191398b688eadf849410c56b1f5765176
