# MENU SISTEM MANAJEMEN HR

Berdasarkan struktur database `db_hr`, sistem ini adalah **Sistem Manajemen HR (Human Resources)**.

---

## 1. Dashboard
- Ringkasan jumlah karyawan
- Jumlah departemen aktif
- Grafik distribusi karyawan per departemen
- Grafik distribusi karyawan per wilayah

---

## 2. Data Karyawan

| Sub Menu | Fungsi |
|----------|--------|
| Daftar Karyawan | Menampilkan seluruh data karyawan (tabel) |
| Tambah Karyawan | Form input karyawan baru |
| Edit Karyawan | Update data karyawan |
| Hapus Karyawan | Hapus data karyawan |
| Detail Karyawan | Lihat detail + riwayat pekerjaan |

---

## 3. Data Departemen

| Sub Menu | Fungsi |
|----------|--------|
| Daftar Departemen | Menampilkan semua departemen |
| Tambah Departemen | Form input departemen baru |
| Edit Departemen | Update data departemen |
| Hapus Departemen | Hapus departemen |
| Struktur Organisasi | Hierarki departemen & manager |

---

## 4. Data Pekerjaan (Jobs)

| Sub Menu | Fungsi |
|----------|--------|
| Daftar Pekerjaan | Menampilkan semua job title |
| Tambah Pekerjaan | Form input pekerjaan baru |
| Edit Pekerjaan | Update data pekerjaan |

---

## 5. Riwayat Pekerjaan (Job History)

| Sub Menu | Fungsi |
|----------|--------|
| Daftar Riwayat | Menampilkan semua perpindahan karyawan |
| Riwayat per Karyawan | Filter berdasarkan karyawan |
| Riwayat per Departemen | Filter berdasarkan departemen |

---

## 6. Lokasi & Wilayah

| Sub Menu | Fungsi |
|----------|--------|
| Daftar Lokasi | Semua kota & alamat kantor |
| Daftar Negara | Semua negara + wilayah |
| Daftar Wilayah | Semua region/wilayah |

---

## 7. Laporan

| Sub Menu | Fungsi |
|----------|--------|
| Laporan Karyawan per Departemen | Jumlah & rata-rata gaji |
| Laporan Gaji | Ringkasan gaji per departemen/wilayah |
| Laporan Riwayat Pekerjaan | Histori perpindahan karyawan |
| Laporan Lokasi Kerja | Distribusi karyawan per lokasi |

---

## 8. Pengaturan (Settings)

| Sub Menu | Fungsi |
|----------|--------|
| Profil Admin | Edit profil pengguna |
| Ganti Password | Ubah password login |
| Logout | Keluar dari sistem |

---

## Struktur Menu (Visual)

```
🏠 Dashboard

👥 Data Karyawan
   ├── Daftar Karyawan
   ├── Tambah Karyawan
   ├── Edit Karyawan
   ├── Hapus Karyawan
   └── Detail Karyawan

🏢 Data Departemen
   ├── Daftar Departemen
   ├── Tambah Departemen
   ├── Edit Departemen
   ├── Hapus Departemen
   └── Struktur Organisasi

💼 Data Pekerjaan
   ├── Daftar Pekerjaan
   ├── Tambah Pekerjaan
   └── Edit Pekerjaan

📋 Riwayat Pekerjaan
   ├── Daftar Riwayat
   ├── Riwayat per Karyawan
   └── Riwayat per Departemen

📍 Lokasi & Wilayah
   ├── Daftar Lokasi
   ├── Daftar Negara
   └── Daftar Wilayah

📊 Laporan
   ├── Karyawan per Departemen
   ├── Laporan Gaji
   ├── Riwayat Pekerjaan
   └── Lokasi Kerja

⚙️ Pengaturan
   ├── Profil Admin
   ├── Ganti Password
   └── Logout
```

---

## Ringkasan

| Menu | Jumlah Sub Menu |
|------|-----------------|
| Dashboard | - |
| Data Karyawan | 5 |
| Data Departemen | 5 |
| Data Pekerjaan | 3 |
| Riwayat Pekerjaan | 3 |
| Lokasi & Wilayah | 3 |
| Laporan | 4 |
| Pengaturan | 3 |
| **Total** | **26 halaman** |
