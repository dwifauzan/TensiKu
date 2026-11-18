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

## Database

```
role 1 ─── * users 1 ─┬─ * pengukuran
                      ├─ * obat
                      └─ * tips (dibuat_oleh)
```

### `role`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_role` | bigint, PK | |
| `nama_role` | varchar | `admin` atau `pengguna` |

### `users`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint, PK | |
| `nama` | varchar | |
| `email` | varchar, unik | |
| `email_verified_at` | timestamp, null | |
| `password` | varchar | di-hash |
| `is_active` | boolean | default `true`; `false` = tidak bisa login |
| `id_role` | FK → `role.id_role`, null | |
| `remember_token` | varchar, null | untuk *Ingat saya* |
| `created_at`, `updated_at` | timestamp | |

### `pengukuran`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint, PK | |
| `pengguna_id` | FK → `users.id` | ikut terhapus jika user dihapus |
| `waktu_ukur` | datetime | tanggal & jam pengukuran |
| `sistolik` | smallint | mmHg, rentang wajar 70–250 |
| `diastolik` | smallint | mmHg, rentang wajar 40–150 |
| `nadi` | smallint, null | bpm, opsional |
| `status` | enum | `normal`, `meningkat`, `hipertensi_1`, `hipertensi_2` — dihitung otomatis saat simpan |
| `catatan` | text, null | |
| `created_at`, `updated_at` | timestamp | |

Index: (`pengguna_id`, `waktu_ukur`) untuk riwayat per pengguna.

### `tips`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint, PK | |
| `dibuat_oleh` | FK → `users.id` | admin pembuat; admin yang masih punya tips tidak bisa dihapus |
| `judul` | varchar | |
| `isi` | text | |
| `kategori` | enum, null | sama seperti `pengukuran.status`; `null` = tips umum |
| `gambar` | varchar, null | path gambar, opsional |
| `created_at`, `updated_at` | timestamp | |

### `obat`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint, PK | |
| `pengguna_id` | FK → `users.id` | ikut terhapus jika user dihapus |
| `nama_obat` | varchar | |
| `dosis` | varchar(100) | contoh: `5 mg` |
| `aturan_pakai` | varchar(100) | contoh: `2x sehari` |
| `catatan` | text, null | |
| `created_at`, `updated_at` | timestamp | |

Tabel bawaan Laravel juga tetap ada: `password_reset_tokens`, `sessions`, `cache`, `jobs`.

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
