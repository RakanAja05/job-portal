# FITUR EMAIL & NOTIFIKASI - DOKUMENTASI

## 🎯 Fitur yang Sudah Diimplementasikan

### 1. Email dengan Link Download CV ✅
**Deskripsi:** Ketika user melamar pekerjaan, admin menerima email dengan link download CV.

**Flow:**
1. User apply ke lowongan (upload CV)
2. Sistem kirim email ke semua admin
3. Email berisi:
   - Info pelamar (nama, email)
   - Info posisi (job title, company)
   - **Link download CV** ← Fitur utama
4. Admin klik link untuk download CV

**File terkait:**
- `app/Mail/NewApplicationMail.php` - Mailable class
- `resources/views/emails/new-application.blade.php` - Template email
- `app/Http/Controllers/ApplicationController.php` (method `store`)

**Email dikirim ke:** Semua user dengan role `admin`

---

### 2. Notifikasi ke Database ✅
**Deskripsi:** Setiap lamaran baru disimpan sebagai notifikasi di database yang bisa dilihat admin.

**Flow:**
1. User apply ke lowongan
2. Sistem simpan notifikasi ke tabel `notifications`
3. Admin bisa lihat di halaman **Notifikasi** (`/notifications`)
4. Notifikasi menampilkan:
   - Nama pelamar
   - Posisi yang dilamar
   - Tanggal lamar
   - Status: Belum dibaca (badge BARU) / Sudah dibaca
   - Tombol download CV
   - Tombol "Tandai Dibaca"

**Database Schema:**
```sql
notifications:
- id
- user_id (admin yang menerima notifikasi)
- application_id (lamaran yang dimaksud)
- type (default: 'new_application')
- title (judul notifikasi)
- message (isi pesan)
- is_read (boolean: false = belum dibaca)
- timestamps
```

**File terkait:**
- `database/migrations/2025_11_23_133002_create_notifications_table.php`
- `app/Models/Notification.php`
- `app/Http/Controllers/NotificationController.php`
- `resources/views/notifications/index.blade.php`

**Routes:**
- GET `/notifications` - Lihat semua notifikasi
- POST `/notifications/{id}/mark-read` - Tandai satu notifikasi sudah dibaca
- POST `/notifications/mark-all-read` - Tandai semua notifikasi sudah dibaca

---

### 3. Email Custom untuk Status Lamaran ✅
**Deskripsi:** Admin bisa terima/tolak lamaran, dan user otomatis dapat email notifikasi status.

**Flow Accept (Terima):**
1. Admin klik tombol **✓ Terima** di halaman applications
2. Status lamaran berubah jadi `accepted`
3. User dapat email:
   - Subject: "✅ Status Lamaran: Diterima"
   - Isi: Selamat! Lamaran diterima
   - Info posisi yang dilamar

**Flow Reject (Tolak):**
1. Admin klik tombol **✗ Tolak**
2. Status lamaran berubah jadi `rejected`
3. User dapat email:
   - Subject: "❌ Status Lamaran: Ditolak"
   - Isi: Mohon maaf, lamaran ditolak
   - Info posisi yang dilamar

**File terkait:**
- `app/Mail/ApplicationStatusMail.php` - Mailable class
- `resources/views/emails/application-status.blade.php` - Template email
- `app/Http/Controllers/ApplicationController.php` (methods: `accept`, `reject`)

**Routes:**
- POST `/applications/{id}/accept` - Terima lamaran
- POST `/applications/{id}/reject` - Tolak lamaran

---

## 📁 Struktur File Baru

```
app/
├── Http/Controllers/
│   ├── ApplicationController.php (updated: store, accept, reject)
│   └── NotificationController.php (new)
├── Mail/
│   ├── NewApplicationMail.php (new)
│   └── ApplicationStatusMail.php (new)
└── Models/
    └── Notification.php (new)

database/migrations/
└── 2025_11_23_133002_create_notifications_table.php (new)

resources/views/
├── emails/
│   ├── new-application.blade.php (new)
│   └── application-status.blade.php (new)
├── notifications/
│   └── index.blade.php (new)
└── applications/
    └── admin-index.blade.php (updated: tombol accept/reject)

routes/web.php (updated)
```

---

## 🧪 Cara Testing

### Test 1: Email ke Admin dengan Link Download CV
1. Login sebagai **user** (bukan admin)
2. Buka halaman home `/`
3. Klik salah satu lowongan → Klik **LAMAR SEKARANG**
4. Upload CV (file PDF)
5. Submit form
6. **✅ Cek email admin** - harus dapat email dengan link download CV
7. **✅ Cek database** - tabel `notifications` harus ada record baru

### Test 2: Notifikasi di Dashboard Admin
1. Login sebagai **admin**
2. Buka `/notifications` atau klik tombol **🔔 NOTIFIKASI** di halaman applications
3. **✅ Harus muncul** notifikasi lamaran baru dengan badge "BARU"
4. Klik tombol **📄 Download CV** - file CV harus ke-download
5. Klik **✓ Tandai Dibaca** - badge "BARU" hilang
6. Klik **✓ Tandai Semua Sudah Dibaca** - semua badge hilang

### Test 3: Email Status Lamaran ke User
1. Login sebagai **admin**
2. Buka `/admin/applications`
3. Cari lamaran dengan status **Pending**
4. Klik tombol **✓ Terima**
5. **✅ Cek email user** - harus dapat email "Status Lamaran: Diterima"
6. Status di tabel berubah jadi **✅ Diterima**
7. Test reject: klik **✗ Tolak** di lamaran lain
8. **✅ Cek email user** - harus dapat email "Status Lamaran: Ditolak"

---

## 🔧 Konfigurasi Email

Pastikan file `.env` sudah dikonfigurasi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=rakanhibrizi00@gmail.com
MAIL_PASSWORD="zxed vter nnfg mqgu"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@jobportal.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 📊 Database Schema

### Tabel `notifications`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key ke `users` (admin) |
| application_id | bigint | Foreign key ke `applications` |
| type | varchar | Tipe notifikasi (default: 'new_application') |
| title | varchar | Judul notifikasi |
| message | text | Isi pesan notifikasi |
| is_read | boolean | Status baca (default: false) |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### Relasi:
- `notifications.user_id` → `users.id` (admin yang menerima)
- `notifications.application_id` → `applications.id` (lamaran)

---

## 🎨 UI/UX Features

### Halaman Notifikasi (`/notifications`)
- **Header:** Judul + statistik (Total Notifikasi, Belum Dibaca)
- **Stats Cards:** Menampilkan angka dengan warna gradient
- **Notification Cards:**
  - Badge "BARU" untuk yang belum dibaca
  - Background biru muda untuk unread
  - Info lengkap: nama, email, posisi, tanggal
  - Tombol: Download CV, Lihat Detail, Tandai Dibaca
  - Hover effect: card bergeser ke kanan
- **Empty State:** Tampilan ketika belum ada notifikasi

### Halaman Admin Applications (`/admin/applications`)
- **Tombol Notifikasi:** Warna ungu di header
- **Kolom Aksi:** Tombol Accept (hijau) dan Reject (merah)
- **Disabled State:** Tombol hilang jika status sudah Accepted/Rejected
- **Badge Status:** 
  - ⏳ Pending (kuning)
  - ✅ Diterima (hijau)
  - ❌ Ditolak (merah)

---

## ✨ Summary

**3 Fitur Utama:**
1. ✅ Email ke admin dengan **link download CV**
2. ✅ Notifikasi tersimpan di **database** untuk admin
3. ✅ Email custom untuk **status lamaran** (Accepted/Rejected)

**Total File Baru:** 7 files
**Total File Diupdate:** 4 files
**Total Routes Baru:** 6 routes
**Total Migration:** 1 migration

**Status:** ✅ Semua fitur sudah diimplementasikan dan siap ditest!
