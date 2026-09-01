# Sistem Manajemen HR (Prototype)

Prototype sederhana untuk **Sistem Manajemen Human Resources (HR)** berbasis Laravel + PostgreSQL. Proyek ini berisi perancangan antarmuka (wireframe), struktur database, CRUD modul, dan latihan soal SQL.

---

## 📂 Isi Proyek

| File/Folder | Deskripsi |
|------|-----------|
| `app/Http/Controllers/` | Controller untuk setiap modul (Auth, Dashboard, Employee, dll) |
| `database/migrations/` | Migrasi database Laravel |
| `docs/prototype.md` | Visualisasi wireframe (ASCII) dari seluruh halaman sistem |
| `docs/Menu.md` | Rincian menu, sub menu, dan fungsi setiap modul |
| `docs/db_hr_backup.sql` | Backup/struktur database PostgreSQL `db_hr` |
| `docs/soal.txt` | Daftar soal latihan SQL (Basic & Menengah) |
| `docs/soal_jawaban.md` | Soal beserta jawaban SQL |
| `routes/web.php` | Definisi route Laravel |
| `resources/views/` | Blade template views |

---

## 🗄️ Struktur Database `db_hr`

Database berisi **7 tabel**:

| Tabel | Keterangan |
|-------|------------|
| `employees` | Data karyawan (nama, email, gaji, job, manager, departemen) |
| `departments` | Departemen organisasi |
| `jobs` | Daftar pekerjaan/job title beserta range gaji |
| `job_history` | Riwayat perpindahan pekerjaan karyawan |
| `locations` | Lokasi/kota kantor |
| `countries` | Negara beserta wilayah |
| `regions` | Wilayah geografis (region) |

### Relasi Utama
- `employees.department_id` → `departments.department_id`
- `employees.job_id` → `jobs.job_id`
- `employees.manager_id` → `employees.employee_id` (self-reference)
- `departments.location_id` → `locations.location_id`
- `locations.country_id` → `countries.country_id`
- `countries.region_id` → `regions.region_id`
- `job_history.employee_id` → `employees.employee_id`

---

## 🖥️ Modul & Halaman

Berdasarkan `prototype.md` dan route Laravel, sistem memiliki **7 modul**:

1. **Login** — autentikasi pengguna
2. **Dashboard** — ringkasan jumlah karyawan & grafik distribusi
3. **Data Karyawan** — CRUD + detail & riwayat pekerjaan
4. **Data Departemen** — CRUD + struktur organisasi
5. **Data Pekerjaan (Jobs)** — CRUD job title
6. **Riwayat Pekerjaan** — histori perpindahan karyawan
7. **Lokasi & Wilayah** — lokasi, negara, wilayah

Total **49 routes** terdaftar (resource routes untuk setiap modul).

---

## 📘 Latihan SQL

Setiap level:

### Level Basic (20 Soal)
Topik: `SELECT`, `WHERE`, `ORDER BY`, `LIMIT`, `LIKE`, `NULL`, `IN`, `BETWEEN`, `JOIN`

### Level Menengah - GROUP BY (10 Soal)
Topik: `GROUP BY`, `COUNT`, `AVG`, `SUM`, `MAX`, `MIN`, `HAVING`

Detail soal dan jawaban lengkap tersedia di `soal_jawaban.md`.

---

## 🔐 Contoh Login

Tampilan halaman login sesuai wireframe di `prototype.md`:

```
┌─────────────────────────────────────────────┐
│              SISTEM MANAJEMEN HR             │
│                                             │
│  ┌───────────────────────────────────────┐  │
│  │ Username                             │  │
│  │ [___________________]                │  │
│  └───────────────────────────────────────┘  │
│                                             │
│  ┌───────────────────────────────────────┐  │
│  │ Password                             │  │
│  │ [___________________]                │  │
│  └───────────────────────────────────────┘  │
│                                             │
│  ┌───────────────────────────────────────┐  │
│  │               LOGIN                  │  │
│  └───────────────────────────────────────┘  │
└─────────────────────────────────────────────┘
```

**Kredensial login:**

| Level | Username | Password |
|-------|----------|----------|
| Admin | `admin@example.com` | `password` |

> Catatan: Password diatur pada modul **Pengaturan → Ganti Password** (lihat `Menu.md`).

---

## 🚀 Menjalankan Aplikasi

### 1. Database Setup (PostgreSQL di Windows, WSL)

```bash
# Buat database baru
PGPASSWORD=postgres psql -h 127.0.0.1 -U postgres -p 5432 -c "CREATE DATABASE db_hr;"

# Restore dari backup
PGPASSWORD=postgres psql -h 127.0.0.1 -U postgres -p 5432 -d db_hr -f docs/db_hr_backup.sql
```

### 2. Konfigurasi .env

Pastikan file `.env` sudah terkonfigurasi:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_hr
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### 3. Install Dependencies & Jalankan

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

Aplikasi berjalan di `http://localhost:8000`.

---

## ⚙️ Teknologi

- **Backend:** Laravel (PHP)
- **Database:** PostgreSQL (running di Windows, diakses dari WSL via `127.0.0.1`)
- **Template:** Blade
- **Desain:** Wireframe ASCII (prototype) + implementasi Laravel
