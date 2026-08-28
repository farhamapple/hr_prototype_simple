# Sistem Manajemen HR (Prototype)

Prototype sederhana untuk **Sistem Manajemen Human Resources (HR)** berbasis database `db_hr`. Proyek ini berisi perancangan antarmuka (wireframe), struktur database, dan latihan soal SQL.

---

## 📂 Isi Proyek

| File | Deskripsi |
|------|-----------|
| `prototype.md` | Visualisasi wireframe (ASCII) dari seluruh halaman sistem |
| `Menu.md` | Rincian menu, sub menu, dan fungsi setiap modul |
| `db_hr_backup.sql` | Backup/struktur database PostgreSQL `db_hr` |
| `soal.txt` | Daftar soal latihan SQL (Basic & Menengah) |
| `soal_jawaban.md` | Soal beserta jawaban SQL |

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

Berdasarkan `prototype.md` dan `Menu.md`, sistem memiliki **9 modul**:

1. **Login** — autentikasi pengguna
2. **Dashboard** — ringkasan jumlah karyawan & grafik distribusi
3. **Data Karyawan** — CRUD + detail & riwayat pekerjaan
4. **Data Departemen** — CRUD + struktur organisasi
5. **Data Pekerjaan (Jobs)** — CRUD job title
6. **Riwayat Pekerjaan** — histori perpindahan karyawan
7. **Lokasi & Wilayah** — lokasi, negara, wilayah
8. **Laporan** — karyawan per departemen, gaji, riwayat, lokasi
9. **Pengaturan** — profil admin & ganti password

Total **24 halaman** (terdiri dari berbagai sub menu tiap modul).

---

## 📘 Latihan SQL

Setiap level:

### Level Basic (20 Soal)
Topik: `SELECT`, `WHERE`, `ORDER BY`, `LIMIT`, `LIKE`, `NULL`, `IN`, `BETWEEN`, `JOIN`

### Level Menengah - GROUP BY (10 Soal)
Topik: `GROUP BY`, `COUNT`, `AVG`, `SUM`, `MAX`, `MIN`, `HAVING`

Detail soal dan jawaban lengkap tersedia di `soal_jawaban.md`.

---

## 🚀 Menjalankan Database

Import backup SQL ke PostgreSQL:

```bash
createdb db_hr
psql -d db_hr -f db_hr_backup.sql
```

---

## ⚙️ Teknologi

- **Database:** PostgreSQL
- **Desain:** Wireframe ASCII (belum implementasi kode aplikasi)
