# TensiKu

TensiKu adalah aplikasi web sederhana untuk mencatat dan memantau tekanan darah.
Pengguna memasukkan angka **sistolik** dan **diastolik**, lalu sistem menampilkan
status (normal sampai hipertensi), riwayat pengukuran, dan grafik tren.

> ⚠️ TensiKu hanya alat bantu pencatatan, bukan pengganti diagnosis dokter.

## Fitur

Sudah tersedia:

- Register, login, dan logout
- Profil pengguna di navbar (dropdown)
- Skema database untuk role, users, pengukuran, tips, dan obat
- Dashboard (masih berisi sapaan saja)

Rencana berikutnya:

- Tambah, edit, dan hapus pengukuran dengan status otomatis
- Riwayat pengukuran dan grafik tren
- Tips kesehatan
- Catatan obat

### Autentikasi

- **Register** (`/register`) — nama, email, password, konfirmasi password.
  Email harus unik, password minimal 8 karakter. Akun baru otomatis aktif,
  diberi role `pengguna`, lalu langsung login.
- **Login** (`/login`) — email, password, dan opsi *Ingat saya*.
  - Akun dengan `is_active = false` tidak bisa login.
  - Maksimal 5 percobaan per menit untuk kombinasi email + IP.
  - Setelah login, pengguna diarahkan ke halaman yang tadi dituju, atau ke dashboard.
- **Logout** — tombol *Keluar* di dropdown profil. Sesi dihapus, kembali ke halaman login.
- **Proteksi halaman** — tamu yang membuka `/dashboard` diarahkan ke login;
  pengguna yang sudah login dan membuka `/login` atau `/register` diarahkan ke dashboard.

### Dropdown Profil

Klik avatar (inisial nama) di navbar untuk melihat nama, email, role, tanggal
terdaftar, dan tombol *Keluar*. Dropdown tertutup saat klik di luar atau menekan `Esc`.

## Kategori Status

Aturan ini dipakai oleh fitur pengukuran (kolom `pengukuran.status` dan `tips.kategori`).

| Status | Nilai di database | Sistolik (mmHg) | | Diastolik (mmHg) | Warna |
| --- | --- | --- | --- | --- | --- |
| Normal | `normal` | < 120 | dan | < 80 | 🟢 Hijau |
| Meningkat | `meningkat` | 120 – 129 | dan | < 80 | 🟡 Kuning |
| Hipertensi Tahap 1 | `hipertensi_1` | 130 – 139 | atau | 80 – 89 | 🟠 Oranye |
| Hipertensi Tahap 2 | `hipertensi_2` | ≥ 140 | atau | ≥ 90 | 🔴 Merah |

Jika sistolik dan diastolik jatuh di kategori berbeda, yang dipakai adalah kategori yang lebih tinggi.
Warna sudah tersedia sebagai token Tailwind: `bg-status-normal`, `bg-status-meningkat`,
`bg-status-hipertensi-1`, `bg-status-hipertensi-2`.

## Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/Auth/
│   │   ├── AuthenticatedSessionController.php   # login & logout
│   │   └── RegisteredUserController.php         # register
│   └── Requests/Auth/
│       ├── LoginRequest.php                     # validasi login
│       └── RegisterRequest.php                  # validasi register
├── Models/
│   ├── Role.php
│   └── User.php
└── Providers/AppServiceProvider.php             # rate limit login

database/
├── factories/        # RoleFactory, UserFactory
├── migrations/       # users + role, pengukuran, tips, obat
└── seeders/DatabaseSeeder.php

resources/
├── css/app.css       # Tailwind + token warna & font
├── js/app.js         # dropdown profil
└── views/
    ├── auth/         # login, register
    ├── components/
    │   ├── layouts/  # base, app (dengan navbar), auth
    │   ├── brand, button, input
    │   └── profile-dropdown
    ├── dashboard.blade.php
    └── welcome.blade.php

routes/web.php

tests/Feature/
├── Auth/             # AuthenticationTest, RegistrationTest
└── DatabaseSchemaTest.php
```

## Routes

| Method | URL | Nama | Akses |
| --- | --- | --- | --- |
| GET | `/` | `home` | semua |
| GET | `/register` | `register` | tamu |
| POST | `/register` | | tamu |
| GET | `/login` | `login` | tamu |
| POST | `/login` | | tamu, maks. 5/menit |
| POST | `/logout` | `logout` | login |
| GET | `/dashboard` | `dashboard` | login |

## Teknologi

- [Laravel 13](https://laravel.com) (PHP 8.3+)
- [Tailwind CSS 4](https://tailwindcss.com) + [Vite](https://vite.dev)
- Font: Plus Jakarta Sans
- Database: SQLite (default) / MySQL

## Instalasi

```bash
git clone <url-repo> tensiku
cd tensiku

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed

composer run dev
```

Buka `http://localhost:8000` di browser.

Seeder membuat role `admin` dan `pengguna`, serta satu akun contoh:

| Email | Password |
| --- | --- |
| `test@example.com` | `password` |

## Testing

```bash
php artisan test
```

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
