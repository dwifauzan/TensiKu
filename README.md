# TensiKu

TensiKu adalah aplikasi web sederhana untuk mencatat dan memantau tekanan darah.
Pengguna cukup memasukkan angka **sistolik** dan **diastolik**, lalu sistem otomatis
menampilkan status (normal sampai hipertensi), riwayat pengukuran, dan grafik tren.

> ⚠️ TensiKu hanya alat bantu pencatatan, bukan pengganti diagnosis dokter.

## Fitur

- **Akun pengguna** — register, login, dan logout.
- **Dashboard** — lihat pengukuran terakhir, status, dan grafik singkat.
- **Tambah pengukuran** — isi tanggal, sistolik, diastolik, serta nadi & catatan (opsional).
- **Status otomatis** — sistem menghitung kategori tekanan darah dengan warna penanda.
- **Riwayat** — lihat, edit, dan hapus data lama, lengkap dengan grafik tren.
- **Tips kesehatan** — saran ringan untuk menjaga tekanan darah tetap sehat.

## Kategori Status

| Status               | Sistolik (mmHg) |      | Diastolik (mmHg) | Warna     |
| -------------------- | --------------- | ---- | ---------------- | --------- |
| Normal               | < 120           | dan  | < 80             | 🟢 Hijau  |
| Meningkat            | 120 – 129       | dan  | < 80             | 🟡 Kuning |
| Hipertensi Tahap 1   | 130 – 139       | atau | 80 – 89          | 🟠 Oranye |
| Hipertensi Tahap 2   | ≥ 140           | atau | ≥ 90             | 🔴 Merah  |

Jika sistolik dan diastolik jatuh di kategori berbeda, yang dipakai adalah kategori yang lebih tinggi.

## Alur Aplikasi

1. Buka **Welcome page**.
2. **Register** atau **Login**.
3. Masuk ke **Dashboard** — lihat pengukuran terakhir, status, dan grafik.
4. Klik **"Tambah Pengukuran"**.
5. Isi form: tanggal, sistolik, diastolik (nadi & catatan opsional).
6. **Simpan** → sistem validasi input → hitung status otomatis.
7. Kembali ke Dashboard, status baru muncul sesuai warnanya.
8. Buka **Riwayat** untuk lihat, edit, atau hapus data lama + grafik tren.
9. Buka **Tips** untuk membaca saran kesehatan.
10. **Logout**.

## Teknologi

- [Laravel 13](https://laravel.com) (PHP 8.3+)
- [Tailwind CSS 4](https://tailwindcss.com) + [Vite](https://vite.dev)
- Database: SQLite / MySQL

## Instalasi

```bash
git clone <url-repo> tensiku
cd tensiku

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate

composer run dev
```

Buka `http://localhost:8000` di browser.

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
