# Dokumentasi Fitur Export & Import

## Overview
Fitur Export & Import memungkinkan admin untuk mengekspor data lowongan kerja dan lamaran ke file Excel, serta mengimpor data lowongan dari file Excel.

## Packages Used
- **maatwebsite/excel** v1.1.5 (Laravel Excel)
- **phpoffice/phpexcel** 1.8.1 (dependency)

## Files Created

### 1. Export Classes
- `app/Exports/JobsExport.php` - Export lowongan kerja ke Excel
- `app/Exports/ApplicationsExport.php` - Export lamaran ke Excel

### 2. Import Classes
- `app/Imports/JobsImport.php` - Import lowongan kerja dari Excel

### 3. Controller Methods

#### JobController
- `export()` - Download file Excel berisi semua lowongan
- `import(Request $request)` - Upload dan import lowongan dari Excel

#### ApplicationController
- `export()` - Download file Excel berisi semua lamaran
- `adminIndex()` - Menampilkan semua lamaran untuk admin

### 4. Views
- `resources/views/jobs/index.blade.php` - Ditambahkan tombol Export & Import
- `resources/views/applications/admin-index.blade.php` - Halaman admin untuk melihat semua lamaran

### 5. Routes
```php
// Export & Import Routes - hanya untuk admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/jobs/export/excel', [JobController::class, 'export'])->name('jobs.export');
    Route::post('/jobs/import/excel', [JobController::class, 'import'])->name('jobs.import');
    Route::get('/admin/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications');
    Route::get('/applications/export/excel', [ApplicationController::class, 'export'])->name('applications.export');
});
```

## Features

### 1. Export Jobs to Excel
**Route:** `GET /jobs/export/excel`  
**Access:** Admin only  
**Output:** File Excel dengan nama `jobs-YYYY-MM-DD-HHmmss.xlsx`

**Kolom yang diekspor:**
- ID
- Title
- Company
- Location
- Description
- Requirements
- Type
- Salary
- Logo
- Created At
- Updated At

### 2. Import Jobs from Excel
**Route:** `POST /jobs/import/excel`  
**Access:** Admin only  
**Input:** File Excel (.xlsx, .xls, .csv)

**Kolom yang harus ada di Excel:**
- title (required)
- company (required)
- location (required)
- description (required)
- requirements (optional)
- type (optional, default: full-time)
- salary (optional)
- logo (optional)

**Validasi:**
- File harus berformat .xlsx, .xls, atau .csv
- Maximum file size: 2MB

### 3. Export Applications to Excel
**Route:** `GET /applications/export/excel`  
**Access:** Admin only  
**Output:** File Excel dengan nama `applications-YYYY-MM-DD-HHmmss.xlsx`

**Kolom yang diekspor:**
- ID
- Applicant Name
- Applicant Email
- Job Title
- Company
- CV (path)
- Status
- Applied At

### 4. Admin Applications List
**Route:** `GET /admin/applications`  
**Access:** Admin only  
**Features:**
- View all applications from all users
- Statistics: Pending, Accepted, Rejected count
- Export button to download Excel
- View applicant details
- Download CV

## UI Features

### Jobs Index (Admin View)
1. **Tambah Lowongan** - Hijau dengan gradient
2. **Export Excel** - Cyan dengan gradient
3. **Import Excel** - Ungu dengan gradient (toggle form)

### Import Form
- Hidden by default
- Shows when "Import Excel" button clicked
- Contains:
  - File upload input
  - Upload button
  - Format information
  - Close button

### Admin Applications
- Table view with all applications
- Export Excel button
- Statistics cards (Pending/Accepted/Rejected)
- CV download links

## Usage Guide

### Cara Export Lowongan:
1. Login sebagai admin
2. Pergi ke halaman daftar lowongan (`/jobs`)
3. Klik tombol **"📥 EXPORT EXCEL"**
4. File Excel akan otomatis terdownload

### Cara Import Lowongan:
1. Login sebagai admin
2. Pergi ke halaman daftar lowongan (`/jobs`)
3. Klik tombol **"📤 IMPORT EXCEL"**
4. Form import akan muncul
5. Pilih file Excel yang sudah disiapkan
6. Klik **"📤 Upload & Import"**
7. Data akan diimport ke database

### Format Excel untuk Import:
Buat file Excel dengan header sebagai berikut di baris pertama:

| title | company | location | description | requirements | type | salary | logo |
|-------|---------|----------|-------------|--------------|------|--------|------|
| Backend Developer | PT XYZ | Jakarta | ... | ... | full-time | 10000000 | |
| Frontend Developer | PT ABC | Bandung | ... | ... | part-time | 8000000 | |

**Catatan:**
- Baris pertama harus berisi header (nama kolom)
- Kolom `title`, `company`, `location`, `description` wajib diisi
- Kolom lainnya opsional
- `type` hanya boleh: `full-time` atau `part-time`

### Cara Export Lamaran:
1. Login sebagai admin
2. Pergi ke halaman admin applications (`/admin/applications`)
3. Klik tombol **"📥 EXPORT EXCEL"**
4. File Excel akan otomatis terdownload

## Error Handling
- Import akan menampilkan pesan error jika format file salah
- Import akan menampilkan pesan error jika ada kesalahan saat import
- Validasi file type dan size

## Testing

### Test Export Jobs:
```bash
# Pastikan ada data lowongan di database
# Akses: http://localhost/jobs/export/excel
# File harus terdownload dengan format jobs-YYYY-MM-DD-HHmmss.xlsx
```

### Test Import Jobs:
```bash
# Siapkan file Excel dengan format yang benar
# Upload melalui form import di halaman /jobs
# Cek database apakah data berhasil masuk
```

### Test Export Applications:
```bash
# Pastikan ada data lamaran di database
# Akses: http://localhost/admin/applications
# Klik tombol Export Excel
# File harus terdownload dengan format applications-YYYY-MM-DD-HHmmss.xlsx
```

## Notes
- Semua fitur export/import hanya bisa diakses oleh admin
- Import akan membuat data baru, tidak update data yang sudah ada
- Export mengambil semua data tanpa filter
- File yang diexport menggunakan timestamp untuk menghindari duplikasi nama

## Future Improvements
- Add filter options for export (date range, status, etc.)
- Add update functionality in import (not just create)
- Add validation for duplicate data
- Add progress bar for large imports
- Add batch import with error handling per row
- Add export template download
