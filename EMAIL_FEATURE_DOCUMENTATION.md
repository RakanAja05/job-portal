# 📧 Dokumentasi Fitur Email Notifikasi

## 🎯 Overview
Fitur email notifikasi telah berhasil ditambahkan ke Job Portal. Fitur ini memungkinkan admin untuk mengirim notifikasi email ketika lowongan kerja baru dibuat.

---

## ✨ Fitur yang Ditambahkan

### 1. **Email Template yang Cantik**
- 🎨 Desain HTML email yang modern dan responsif
- 📊 Menampilkan semua detail lowongan (title, company, location, type, salary)
- 🖼️ Menampilkan logo perusahaan (jika ada)
- 🔘 Tombol CTA "Lihat Detail Lowongan"
- 📱 Mobile-friendly design
- 🌈 Gradient header yang menarik

### 2. **Form Input Email Notifikasi**
- 📝 Field email opsional di form tambah lowongan
- 💡 Info box dengan penjelasan fitur
- ✅ Validasi email format
- 🎨 Styling yang menarik dengan background biru

### 3. **Automatic Email Sending**
- 📤 Email otomatis terkirim setelah lowongan dibuat
- ⚠️ Error handling yang baik
- 💬 Success/error message yang informatif

---

## 📁 File yang Dibuat/Dimodifikasi

### File Baru:
1. **`app/Mail/JobCreatedMail.php`**
   - Mailable class untuk mengirim email
   - Constructor menerima JobVacancy object
   - Subject: "🎉 Lowongan Kerja Baru: [Job Title]"

2. **`resources/views/emails/job-created.blade.php`**
   - Template HTML email yang cantik
   - Responsive design
   - Gradient header
   - Icon emoji untuk visual appeal

### File yang Dimodifikasi:
1. **`app/Http/Controllers/JobController.php`**
   - Import `Mail` facade dan `JobCreatedMail`
   - Update method `store()` untuk mengirim email
   - Validasi field `recipient_email`
   - Error handling untuk email sending

2. **`resources/views/jobs/create.blade.php`**
   - Tambah field email notifikasi
   - Info box dengan icon
   - Styling yang menarik

3. **`routes/web.php`**
   - Route untuk preview email template
   - URL: `/email-preview` (admin only)

---

## 🚀 Cara Menggunakan

### 1. **Konfigurasi Email (Development)**
File `.env` sudah dikonfigurasi dengan `MAIL_MAILER=log`:
```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Untuk Development:**
- Email akan disimpan di `storage/logs/laravel.log`
- Tidak perlu SMTP server

### 2. **Konfigurasi Email (Production)**
Ubah di file `.env`:

**Menggunakan Gmail:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@jobportal.com"
MAIL_FROM_NAME="Job Portal"
```

**Menggunakan Mailtrap (Testing):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_FROM_ADDRESS="noreply@jobportal.com"
MAIL_FROM_NAME="Job Portal"
```

**Menggunakan SendGrid:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

### 3. **Mengirim Email Notifikasi**
1. Login sebagai admin
2. Buka halaman "Kelola Lowongan"
3. Klik "Tambah Lowongan Baru"
4. Isi form lowongan
5. **Isi email notifikasi** di field "📧 Email Notifikasi"
6. Klik "Simpan"
7. Email akan dikirim ke alamat yang diinput

### 4. **Preview Email Template**
Untuk melihat preview template email tanpa mengirim:
1. Login sebagai admin
2. Akses URL: `http://127.0.0.1:8000/email-preview`
3. Browser akan menampilkan email template

---

## 🧪 Testing Email

### Development (Log Driver):
```bash
# Cek log file
tail -f storage/logs/laravel.log

# Atau buka file
code storage/logs/laravel.log
```

### Testing dengan Mailtrap:
1. Daftar di [mailtrap.io](https://mailtrap.io)
2. Buat inbox baru
3. Copy credentials ke `.env`
4. Test kirim email
5. Cek inbox di Mailtrap dashboard

---

## 📧 Format Email yang Dikirim

### Subject:
```
🎉 Lowongan Kerja Baru: [Job Title]
```

### Content Includes:
- **Header**: Gradient header dengan title
- **Job Title**: Nama posisi
- **Company Info**: Logo dan nama perusahaan
- **Job Details**:
  - 📍 Lokasi
  - 💼 Jenis pekerjaan (badge berwarna)
  - 💰 Gaji (jika ada)
- **Description**: Deskripsi lengkap pekerjaan
- **CTA Button**: "Lihat Detail Lowongan"
- **Logo**: Logo perusahaan (jika ada)
- **Footer**: Copyright dan info

---

## 🔧 Troubleshooting

### Email tidak terkirim?
1. **Cek konfigurasi `.env`**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Cek log error**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Test koneksi SMTP**
   ```bash
   php artisan tinker
   Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });
   ```

### Email masuk spam?
- Gunakan email dari domain yang sama
- Setup SPF, DKIM, DMARC records
- Gunakan service email terpercaya (SendGrid, Mailgun, SES)

### Email tidak tampil dengan baik?
- Email client berbeda punya support CSS yang berbeda
- Template sudah menggunakan inline CSS dan table layout
- Test di berbagai email client

---

## 🎨 Customization

### Ubah Subject Email:
Edit file `app/Mail/JobCreatedMail.php`:
```php
public function envelope(): Envelope
{
    return new Envelope(
        subject: 'Custom Subject: ' . $this->job->title,
    );
}
```

### Ubah Template Email:
Edit file `resources/views/emails/job-created.blade.php`

### Tambah Attachment:
```php
public function attachments(): array
{
    return [
        Attachment::fromPath('/path/to/file.pdf')
    ];
}
```

---

## 📊 Fitur Tambahan (Opsional)

### 1. Queue Email (Recommended untuk Production)
```bash
# Ubah di .env
QUEUE_CONNECTION=database

# Migrate queue table
php artisan queue:table
php artisan migrate

# Update Mailable
class JobCreatedMail extends Mailable implements ShouldQueue

# Run queue worker
php artisan queue:work
```

### 2. Send to Multiple Recipients
```php
// Di controller
Mail::to('user1@example.com')
    ->cc('user2@example.com')
    ->bcc('user3@example.com')
    ->send(new JobCreatedMail($job));
```

### 3. Send to All Users
```php
$users = User::where('role', 'user')->get();
foreach($users as $user) {
    Mail::to($user->email)->send(new JobCreatedMail($job));
}
```

---

## 📝 Best Practices

1. **Gunakan Queue** - Jangan block request dengan email sending
2. **Error Handling** - Selalu tangkap exception
3. **Rate Limiting** - Batasi jumlah email per jam
4. **Unsubscribe Link** - Tambahkan link untuk berhenti berlangganan
5. **Test Template** - Test di berbagai email client
6. **Monitor** - Monitor email delivery rate
7. **Backup** - Simpan log email yang terkirim

---

## 🔐 Security Tips

1. Jangan expose email di URL
2. Validate email format
3. Rate limit email sending
4. Sanitize user input di email content
5. Use environment variables untuk credentials
6. Don't commit `.env` file

---

## 📚 Resources

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Email Testing with Mailtrap](https://mailtrap.io)
- [Email Best Practices](https://www.campaignmonitor.com/resources/guides/email-best-practices/)
- [HTML Email Templates](https://htmlemail.io/)

---

## ✅ Checklist Implementasi

- [x] Buat Mailable class
- [x] Buat email template
- [x] Update controller untuk send email
- [x] Tambah field email di form
- [x] Add validation
- [x] Error handling
- [x] Preview route
- [x] Documentation
- [ ] Setup queue (optional)
- [ ] Add unsubscribe (optional)
- [ ] Setup production SMTP (when deploy)

---

**Status**: ✅ **SELESAI & SIAP DIGUNAKAN**

Fitur email notifikasi sudah fully functional dan siap digunakan! 🎉
