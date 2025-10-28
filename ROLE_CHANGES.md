# Perubahan Sistem Role: User & Admin

## 📝 Ringkasan Perubahan

Sistem role telah diubah dari **HR/Job Seeker** menjadi **User/Admin**

---

## 🔄 Role System

### Role Tersedia:
1. **`user`** - Role default untuk user biasa (logged in)
2. **`admin`** - Role untuk administrator

---

## 🗂️ Struktur Routes

### 1. Public Routes
- `/` - Welcome page (semua orang)
- `/login` - Login page
- `/register` - Register page

### 2. Authenticated Routes (Semua yang login)
- `/dashboard` - Dashboard umum dengan link ke role-specific dashboard

### 3. User Routes (Role: user)
- `/user/dashboard` - User dashboard
- `/user/profile` - User profile view

### 4. Admin Routes (Role: admin)
- `/admin/dashboard` - Admin dashboard
- `/admin/users` - User management
- `/admin/settings` - System settings
- `/admin/reports` - Reports

---

## 🔒 Middleware Protection

### Auth Middleware
```php
'auth' // Harus login
'verified' // Email harus verified
```

### Role Middleware
```php
'role:user' // Hanya role user
'role:admin' // Hanya role admin
'isAdmin' // Hanya admin (alternative)
```

### Contoh Penggunaan:
```php
// User routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/user/dashboard', ...);
});

// Admin routes
Route::middleware(['auth', 'verified', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', ...);
});
```

---

## 📁 File yang Diubah/Dibuat

### Modified Files:
1. ✅ `routes/web.php` - Updated semua routes
2. ✅ `app/Http/Middleware/IsAdmin.php` - Check role 'admin' only
3. ✅ `database/migrations/0001_01_01_000000_create_users_table.php` - Role enum: ['user', 'admin']
4. ✅ `database/factories/UserFactory.php` - Added role 'user' default & admin() method
5. ✅ `database/seeders/DatabaseSeeder.php` - Create test users & admin
6. ✅ `resources/views/dashboard.blade.php` - Updated dengan role-based links

### New Files:
1. ✅ `resources/views/user/dashboard.blade.php` - User dashboard
2. ✅ `resources/views/user/profile.blade.php` - User profile page

### Existing Admin Files:
1. ✅ `resources/views/admin/dashboard.blade.php` - Admin dashboard (updated)
2. ✅ `resources/views/admin/users.blade.php` - User management
3. ✅ `resources/views/admin/settings.blade.php` - Settings
4. ✅ `resources/views/admin/reports.blade.php` - Reports

---

## 🗄️ Database Schema

### Users Table:
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 👥 Test Accounts (Seeder)

Setelah run `php artisan db:seed`:

### Admin Account:
- **Email:** admin@example.com
- **Password:** password
- **Role:** admin

### User Account:
- **Email:** user@example.com
- **Password:** password
- **Role:** user

### Random Users:
- 5 additional users dengan role 'user'

---

## 🚀 Setup Instructions

### 1. Reset & Migrate Database:
```bash
php artisan migrate:fresh --seed
```

### 2. Start Server:
```bash
php artisan serve
```

### 3. Test Login:

**Login sebagai Admin:**
- URL: http://127.0.0.1:8000/login
- Email: admin@example.com
- Password: password
- Akan bisa akses: /admin/dashboard

**Login sebagai User:**
- URL: http://127.0.0.1:8000/login
- Email: user@example.com
- Password: password
- Akan bisa akses: /user/dashboard

---

## 🔐 Access Control

### Dashboard Default (`/dashboard`):
- ✅ Semua user yang login bisa akses
- ✅ Menampilkan link ke dashboard sesuai role
- ✅ Admin → link ke /admin/dashboard
- ✅ User → link ke /user/dashboard

### User Dashboard (`/user/dashboard`):
- ✅ Hanya role 'user' yang bisa akses
- ✅ Admin akan ditolak (403 atau redirect)
- ✅ Menampilkan profile, activity, settings

### Admin Dashboard (`/admin/dashboard`):
- ✅ Hanya role 'admin' yang bisa akses
- ✅ User biasa akan ditolak (redirect ke /)
- ✅ Full admin features (users, settings, reports)

---

## 🧪 Testing Checklist

- [ ] Register new account → role = 'user' (default)
- [ ] Login dengan user@example.com → akses /user/dashboard ✓
- [ ] Login dengan user@example.com → akses /admin/dashboard ✗ (403)
- [ ] Login dengan admin@example.com → akses /admin/dashboard ✓
- [ ] Login dengan admin@example.com → akses /user/dashboard ✗ (403)
- [ ] Logout dari dashboard
- [ ] Akses /dashboard tanpa login → redirect ke /login

---

## 📊 Route Summary

| Route | Middleware | Role Required | View |
|-------|-----------|---------------|------|
| `/` | - | - | welcome |
| `/dashboard` | auth, verified | any | dashboard |
| `/user/dashboard` | auth, verified, role:user | user | user.dashboard |
| `/user/profile` | auth, verified, role:user | user | user.profile |
| `/admin/dashboard` | auth, verified, isAdmin | admin | admin.dashboard |
| `/admin/users` | auth, verified, isAdmin | admin | admin.users |
| `/admin/settings` | auth, verified, isAdmin | admin | admin.settings |
| `/admin/reports` | auth, verified, isAdmin | admin | admin.reports |

---

## ⚡ Quick Commands

```bash
# Reset database & seed
php artisan migrate:fresh --seed

# Create manual user
php artisan tinker
>>> User::create(['name' => 'John', 'email' => 'john@test.com', 'password' => bcrypt('password'), 'role' => 'user']);
>>> User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password'), 'role' => 'admin']);

# Check all users
>>> User::all();

# Test syntax
php -l routes/web.php

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 🎨 Features

### User Dashboard Features:
- ✅ View profile information
- ✅ Access to personal settings
- ✅ Activity tracking (placeholder)
- ✅ Profile edit link
- ✅ Logout button

### Admin Dashboard Features:
- ✅ System statistics
- ✅ User management (view all users)
- ✅ System settings
- ✅ Reports generation
- ✅ Quick actions
- ✅ Logout button

---

## 📖 Related Documentation
- Main Documentation: `MIDDLEWARE_DOCUMENTATION.md`
- This Document: `ROLE_CHANGES.md`
