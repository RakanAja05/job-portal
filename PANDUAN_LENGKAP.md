# 📚 Panduan Lengkap Job Portal dengan Export/Import

## 🎯 Fitur-Fitur Utama

### 1. **Halaman Publik (Untuk Semua Orang)**
✅ **Landing Page** - `http://localhost/`
- Design modern dengan gradient biru-ungu
- Hero section dengan search bar
- Statistik lowongan (Total, Full-Time, Part-Time)
- Grid card lowongan dengan logo, salary, location
- **TIDAK PERLU LOGIN** untuk melihat lowongan

✅ **Detail Lowongan** - `/jobs/public/{id}`
- Informasi lengkap lowongan
- Deskripsi dan persyaratan
- Tombol "LAMAR SEKARANG" (perlu login)
- Tombol "Login/Register" jika belum login

---

### 2. **Untuk User Biasa (Setelah Login)**
✅ **Lihat Lowongan** - Sama dengan halaman publik
✅ **Apply Pekerjaan** - Klik "LAMAR SEKARANG" di detail lowongan
✅ **Upload CV** - Format PDF, maksimal 2MB
✅ **Lihat Status Lamaran** - Menu "Lamaran Saya"

---

### 3. **Untuk Admin (Setelah Login sebagai Admin)**
✅ **Kelola Lowongan** - CRUD (Create, Read, Update, Delete)
✅ **Export Excel** - Download lowongan + pelamar dalam 1 file (2 sheets)
✅ **Import Excel** - Upload file Excel untuk tambah lowongan massal
✅ **Lihat Semua Lamaran** - Menu "Admin Applications"
✅ **Export Lamaran** - Download data semua pelamar

---

## 🚀 Panduan Penggunaan

### 📋 **CARA USER APPLY PEKERJAAN**

#### Step 1: Buka Website
```
http://localhost/
```

#### Step 2: Lihat Lowongan yang Tersedia
- Semua lowongan ditampilkan dalam card
- Ada info: Judul, Perusahaan, Lokasi, Tipe, Salary
- Klik **"Lihat Detail & Apply 🚀"**

#### Step 3: Login atau Register
Jika belum login, akan ada notifikasi:
```
🔒 Login Untuk Melamar
Anda harus login atau register terlebih dahulu untuk melamar pekerjaan ini.
```
- Klik **"Login"** jika sudah punya akun
- Klik **"Register"** jika belum punya akun

#### Step 4: Setelah Login, Klik "LAMAR SEKARANG!"
- Akan diarahkan ke form aplikasi
- Ada preview lowongan yang dilamar
- Upload CV (format PDF, max 2MB)
- Centang persetujuan
- Klik **"📤 KIRIM LAMARAN"**

#### Step 5: Cek Status Lamaran
- Klik menu **"Lamaran Saya"** di navbar
- Lihat status: Pending ⏳, Diterima ✅, atau Ditolak ❌
- Download CV yang sudah diupload
- Hapus lamaran jika perlu

---

### 💼 **CARA ADMIN EXPORT DATA (LOWONGAN + PELAMAR)**

#### Step 1: Login sebagai Admin
```
Email: admin@example.com (atau email admin Anda)
Password: (password admin)
```

#### Step 2: Buka Halaman Lowongan
```
http://localhost/jobs
```

#### Step 3: Klik Tombol "📥 EXPORT EXCEL"
- Tombol berwarna cyan/biru di atas daftar lowongan
- File otomatis terdownload

#### Step 4: Buka File Excel
File yang didownload bernama: `jobs-and-applications-YYYY-MM-DD-HHmmss.xlsx`

**📊 Isi file Excel:**

**Sheet 1: Lowongan Kerja**
| ID | Title | Company | Location | Description | Requirements | Type | Salary | Logo | Created At | Updated At |
|----|-------|---------|----------|-------------|--------------|------|--------|------|------------|------------|
| 1 | Backend Developer | PT Tech | Jakarta | ... | ... | full-time | 15000000 | ... | ... | ... |
| 2 | Frontend Developer | PT Digital | Bandung | ... | ... | part-time | 12000000 | ... | ... | ... |

**Sheet 2: Pelamar**
| ID | Applicant Name | Applicant Email | Job Title | Company | CV | Status | Applied At |
|----|----------------|-----------------|-----------|---------|-------|--------|------------|
| 1 | John Doe | john@example.com | Backend Developer | PT Tech | cvs/john.pdf | Pending | 2025-01-10 |
| 2 | Jane Smith | jane@example.com | Frontend Developer | PT Digital | cvs/jane.pdf | Accepted | 2025-01-11 |

**💡 Manfaat:**
- Satu file untuk semua data
- Mudah untuk analisis data
- Bisa digunakan untuk laporan
- Export dan Import terintegrasi

---

### 📤 **CARA ADMIN IMPORT LOWONGAN DARI EXCEL**

#### Step 1: Siapkan File Excel
Buat file Excel dengan format berikut (baris pertama = header):

| title | company | location | description | requirements | type | salary | logo |
|-------|---------|----------|-------------|--------------|------|--------|------|
| Backend Developer | PT Tech Indonesia | Jakarta | Mencari backend developer Laravel | Min 2 tahun pengalaman | full-time | 15000000 | |
| Frontend Developer | PT Digital Kreatif | Bandung | Membuat UI/UX menarik | Menguasai React | full-time | 12000000 | |
| Mobile Developer | PT Apps Nusantara | Surabaya | Develop aplikasi mobile | Flutter/React Native | part-time | 10000000 | |

**Kolom WAJIB:**
- `title` - Judul lowongan
- `company` - Nama perusahaan
- `location` - Lokasi
- `description` - Deskripsi pekerjaan

**Kolom OPSIONAL:**
- `requirements` - Persyaratan (boleh kosong)
- `type` - Jenis: `full-time` atau `part-time` (default: full-time)
- `salary` - Gaji dalam angka (boleh kosong)
- `logo` - Path logo (biasanya kosong)

#### Step 2: Login sebagai Admin & Buka Halaman Jobs
```
http://localhost/jobs
```

#### Step 3: Klik Tombol "📤 IMPORT EXCEL"
- Tombol berwarna ungu
- Form import akan muncul

#### Step 4: Upload File Excel
- Klik **"Pilih File Excel"**
- Pilih file Excel yang sudah disiapkan
- Klik **"📤 Upload & Import"**

#### Step 5: Cek Hasilnya
- Jika berhasil: Muncul notifikasi hijau "Data lowongan berhasil diimport!"
- Data lowongan baru akan muncul di daftar
- Jika gagal: Muncul notifikasi merah dengan pesan error

---

### 📊 **CARA ADMIN LIHAT SEMUA LAMARAN**

#### Step 1: Login sebagai Admin

#### Step 2: Akses Halaman Admin Applications
```
http://localhost/admin/applications
```

#### Step 3: Lihat Data
Halaman ini menampilkan:
- **Tabel semua lamaran** dari semua user
- **Kolom:** ID, Pelamar, Posisi, Perusahaan, Tanggal, Status, CV
- **Statistik** di bawah tabel:
  - 🟡 Jumlah Pending
  - 🟢 Jumlah Diterima
  - 🔴 Jumlah Ditolak

#### Step 4: Export Data Lamaran (Opsional)
- Klik tombol **"📥 EXPORT EXCEL"** di pojok kanan atas
- File `applications-YYYY-MM-DD-HHmmss.xlsx` akan terdownload
- Berisi semua data pelamar

---

## 🔐 Hak Akses

### **Halaman Publik (Tanpa Login)**
✅ Lihat semua lowongan kerja  
✅ Lihat detail lowongan  
❌ Apply pekerjaan (harus login dulu)

### **User Biasa (Setelah Login)**
✅ Lihat semua lowongan  
✅ Apply pekerjaan  
✅ Upload CV  
✅ Lihat status lamaran sendiri  
✅ Download CV yang sudah diupload  
✅ Hapus lamaran sendiri  
❌ Tidak bisa akses halaman admin

### **Admin (Role: admin)**
✅ Semua akses user biasa  
✅ CRUD lowongan kerja  
✅ Export lowongan + pelamar (2 sheets)  
✅ Import lowongan dari Excel  
✅ Lihat semua lamaran dari semua user  
✅ Export data semua pelamar  
✅ Edit/Hapus lowongan  

---

## 🎨 Tampilan UI

### **Landing Page (Public)**
```
╔══════════════════════════════════════╗
║  💼 Job Portal         Login|Register║
╠══════════════════════════════════════╣
║  Temukan Pekerjaan Impianmu! 🚀      ║
║  [        Search Bar          ] 🔍   ║
╠══════════════════════════════════════╣
║  [100] Lowongan  [80] Full  [20] Part║
╠══════════════════════════════════════╣
║  📋 Lowongan Terbaru                 ║
║  ┌────────┐ ┌────────┐ ┌────────┐   ║
║  │ Job 1  │ │ Job 2  │ │ Job 3  │   ║
║  │ [Card] │ │ [Card] │ │ [Card] │   ║
║  └────────┘ └────────┘ └────────┘   ║
╚══════════════════════════════════════╝
```

### **Detail Lowongan (Public)**
```
╔══════════════════════════════════════╗
║  [Kembali ke Daftar Lowongan]        ║
╠══════════════════════════════════════╣
║  🏢 Backend Developer                ║
║  PT Tech Indonesia                   ║
║  📍 Jakarta • Full-Time              ║
╠══════════════════════════════════════╣
║  💰 Rp 15.000.000 / bulan           ║
╠══════════════════════════════════════╣
║  📝 Deskripsi Pekerjaan              ║
║  Mencari backend developer...        ║
╠══════════════════════════════════════╣
║  ✅ Persyaratan                      ║
║  - Min 2 tahun pengalaman            ║
╠══════════════════════════════════════╣
║  [🚀 LAMAR SEKARANG!] (jika login)  ║
║  [Login] [Register] (jika belum)     ║
╚══════════════════════════════════════╝
```

### **Admin Jobs Page**
```
╔══════════════════════════════════════╗
║ [➕ TAMBAH] [📥 EXPORT] [📤 IMPORT]  ║
╠══════════════════════════════════════╣
║  📋 Daftar Lowongan Kerja (Cards)    ║
║  ┌────────┐ ┌────────┐ ┌────────┐   ║
║  │ Job 1  │ │ Job 2  │ │ Job 3  │   ║
║  │ [Edit] │ │ [Edit] │ │ [Edit] │   ║
║  │ [Del]  │ │ [Del]  │ │ [Del]  │   ║
║  └────────┘ └────────┘ └────────┘   ║
╚══════════════════════════════════════╝
```

---

## 📝 Catatan Penting

### Export Excel
- ✅ File berisi **2 sheets**: Lowongan Kerja + Pelamar
- ✅ Format nama file: `jobs-and-applications-YYYY-MM-DD-HHmmss.xlsx`
- ✅ Bisa dibuka di Microsoft Excel atau Google Sheets
- ✅ Semua data ter-export, tidak ada filter

### Import Excel
- ✅ Format file: `.xlsx`, `.xls`, atau `.csv`
- ✅ Maximum file size: **2MB**
- ✅ Baris pertama HARUS header (nama kolom)
- ✅ Import hanya **menambah** data baru, tidak update data lama
- ✅ Jika error, akan tampil pesan error di halaman

### Apply Pekerjaan
- ✅ CV harus format **PDF**
- ✅ Maximum file size: **2MB**
- ✅ Status default: **Pending** (menunggu review admin)
- ✅ User hanya bisa lihat lamaran sendiri
- ✅ Admin bisa lihat semua lamaran

---

## 🐛 Troubleshooting

### Error: "Class 'Excel' not found"
```bash
composer require maatwebsite/excel
php artisan config:clear
```

### Error: "The file field is required" saat import
**Solusi:** Pastikan Anda sudah memilih file sebelum klik Upload

### Tombol "LAMAR SEKARANG" tidak muncul
**Solusi:** Pastikan Anda sudah login dan role bukan admin

### File Excel tidak bisa dibuka
**Solusi:** 
- Pastikan menggunakan Microsoft Excel 2007 atau lebih baru
- Atau buka dengan Google Sheets
- Pastikan file tidak corrupt

### Data tidak muncul setelah import
**Solusi:**
- Refresh halaman (F5)
- Cek notifikasi error
- Pastikan format Excel sesuai (header di baris pertama)

---

## ✅ Testing Checklist

### User Flow
- [ ] User bisa lihat lowongan tanpa login
- [ ] User bisa klik detail lowongan
- [ ] User diminta login saat klik "LAMAR SEKARANG"
- [ ] User bisa register akun baru
- [ ] User bisa login
- [ ] User bisa apply pekerjaan
- [ ] User bisa upload CV (PDF)
- [ ] User bisa lihat status lamaran
- [ ] User bisa download CV yang diupload
- [ ] User bisa hapus lamaran

### Admin Flow
- [ ] Admin bisa login
- [ ] Admin bisa CRUD lowongan
- [ ] Admin bisa export Excel (2 sheets)
- [ ] Admin bisa import Excel
- [ ] Admin bisa lihat semua lamaran
- [ ] Admin bisa export data pelamar
- [ ] Sheet 1 Excel: Data lowongan benar
- [ ] Sheet 2 Excel: Data pelamar benar

---

## 🎉 Selamat Menggunakan!

Job Portal Anda sekarang sudah lengkap dengan:
✅ Halaman publik untuk semua orang
✅ System apply pekerjaan untuk user
✅ Export Excel dengan 2 sheets (Lowongan + Pelamar)
✅ Import Excel untuk tambah lowongan massal
✅ Admin dashboard untuk kelola semua data

**Happy Recruiting! 💼🚀**
