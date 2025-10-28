# Dokumentasi Middleware - Job Portal

## 📚 Daftar Middleware yang Sudah Diimplementasikan

### 1. **Global Middleware** (Berjalan di semua request)
File: `app/Http/Kernel.php` - `$middleware` array

- `HandleCors` - Handle CORS (Cross-Origin Resource Sharing)
- `PreventRequestsDuringMaintenance` - Blokir akses saat maintenance mode
- `ValidatePostSize` - Validasi ukuran POST request
- `TrimStrings` - Trim whitespace dari input
- `ConvertEmptyStringsToNull` - Convert string kosong jadi null

### 2. **Route Middleware** (Dipakai per route/group)

#### Authentication & Authorization
- **`auth`** - Cek apakah user sudah login
  ```php
  Route::get('/dashboard', function () {
      return view('dashboard');
  })->middleware('auth');
  ```

- **`guest`** - Redirect ke dashboard jika sudah login (untuk halaman login/register)
  ```php
  Route::get('/login', function () {
      return view('login');
  })->middleware('guest');
  ```

- **`verified`** - Cek apakah email sudah diverifikasi
  ```php
  Route::get('/dashboard', function () {
      return view('dashboard');
  })->middleware(['auth', 'verified']);
  ```

#### Role-Based Access Control
- **`role:HR`** - Cek role user (bisa multiple: `role:HR,Admin`)
  ```php
  Route::get('/hr-dashboard', function () {
      return view('hr.dashboard');
  })->middleware('role:HR');
  
  // Multiple roles
  Route::get('/admin-page', function () {
      return view('admin');
  })->middleware('role:HR,Admin');
  ```

- **`isAdmin`** - Cek apakah user adalah HR/Admin/admin
  ```php
  Route::get('/admin-settings', function () {
      return view('admin.settings');
  })->middleware('isAdmin');
  ```

#### User Status Check
- **`active`** - Cek apakah user status = 'active'
  ```php
  Route::get('/dashboard', function () {
      return view('dashboard');
  })->middleware(['auth', 'active']);
  ```

#### Logging Middleware
- **`log.requests`** - Log semua request (sebelum dan sesudah)
  ```php
  Route::get('/important-page', function () {
      return view('important');
  })->middleware('log.requests');
  ```

- **`log.after`** - Log request setelah response dikirim (Terminable Middleware)
  ```php
  Route::get('/tracked-page', function () {
      return view('tracked');
  })->middleware('log.after');
  ```

#### Security Middleware
- **`check.age`** - Cek apakah umur >= 18
  ```php
  Route::get('/adult-content', function () {
      return 'Adult content';
  })->middleware('check.age');
  ```

- **`check.ip`** - Whitelist IP address
  ```php
  Route::get('/restricted', function () {
      return 'IP restricted';
  })->middleware('check.ip');
  ```

- **`check.token`** - Validasi API token (dengan parameter)
  ```php
  // Default: type 'api'
  Route::get('/api/users', function () {
      return response()->json(['users' => []]);
  })->middleware('check.token');
  
  // Custom type
  Route::get('/api/posts', function () {
      return response()->json(['posts' => []]);
  })->middleware('check.token:session');
  ```

- **`custom.header`** - Tambah custom headers ke response
  ```php
  Route::get('/secure', function () {
      return 'Secure page';
  })->middleware('custom.header');
  ```

- **`throttle:60,1`** - Rate limiting (60 requests per minute)
  ```php
  Route::get('/limited', function () {
      return 'Limited access';
  })->middleware('throttle:5,1'); // 5 requests per minute
  ```

---

## 🔧 Cara Menggunakan Middleware

### A. Single Middleware
```php
Route::get('/page', function () {
    return view('page');
})->middleware('auth');
```

### B. Multiple Middleware
```php
Route::get('/page', function () {
    return view('page');
})->middleware(['auth', 'verified', 'role:HR']);
```

### C. Middleware Group
```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    
    Route::get('/profile', function () {
        return view('profile');
    });
});
```

### D. Middleware dengan Prefix
```php
Route::middleware(['auth', 'role:HR'])->prefix('admin')->group(function () {
    Route::get('/users', function () {
        return 'Admin Users';
    }); // URL: /admin/users
    
    Route::get('/settings', function () {
        return 'Admin Settings';
    }); // URL: /admin/settings
});
```

### E. Middleware dengan Parameter
```php
// Single parameter
Route::get('/page', function () {
    return view('page');
})->middleware('role:HR');

// Multiple parameters (comma separated)
Route::get('/page', function () {
    return view('page');
})->middleware('role:HR,Admin,Manager');

// Custom middleware parameter
Route::get('/api', function () {
    return response()->json([]);
})->middleware('check.token:api');
```

---

## 📁 Struktur File Middleware

```
app/Http/Middleware/
├── Authenticate.php              # Auth check
├── RedirectIfAuthenticated.php   # Guest middleware
├── EnsureUserHasRole.php         # Role check (parameter)
├── IsAdmin.php                   # Admin check
├── EnsureUserIsActive.php        # Active status check
├── LogRequests.php               # Request logging
├── LogAfterRequest.php           # Terminable logging
├── CheckAge.php                  # Age verification
├── CheckIpAddress.php            # IP whitelist
├── CheckToken.php                # Token validation
├── AddCustomHeader.php           # Response header modification
├── EncryptCookies.php            # Cookie encryption
├── VerifyCsrfToken.php           # CSRF protection
├── TrimStrings.php               # Input trimming
└── PreventRequestsDuringMaintenance.php  # Maintenance mode

app/Http/Controllers/
├── AdminController.php           # Admin management
├── HRController.php              # HR operations
├── JobSeekerController.php       # Job seeker operations
└── ProfileController.php         # User profile
```

---

## 🎯 Contoh Penggunaan di Project

### 1. Dashboard dengan Role-based Access
```php
// HR Dashboard - menggunakan Controller
Route::middleware(['auth', 'verified', 'role:HR'])->prefix('dashboard')->group(function () {
    Route::get('/hr', [HRController::class, 'index'])->name('dashboard.hr');
    Route::get('/hr/users', [HRController::class, 'users'])->name('dashboard.hr.users');
    Route::get('/hr/jobs', [HRController::class, 'jobs'])->name('dashboard.hr.jobs');
});

// Job Seeker Dashboard - menggunakan Controller
Route::middleware(['auth', 'verified', 'role:Job Seeker'])->prefix('dashboard')->group(function () {
    Route::get('/jobseeker', [JobSeekerController::class, 'index'])->name('dashboard.jobseeker');
    Route::get('/jobseeker/applications', [JobSeekerController::class, 'applications'])->name('dashboard.jobseeker.applications');
});
```

### 2. API Routes dengan Protection
```php
Route::prefix('api')->middleware(['check.token', 'throttle:60,1'])->group(function () {
    Route::get('/users', function () {
        return response()->json(['users' => []]);
    });
    
    Route::get('/jobs', function () {
        return response()->json(['jobs' => []]);
    });
});
```

### 3. Admin Panel dengan Multiple Security
```php
// Menggunakan AdminController
Route::middleware(['auth', 'isAdmin', 'log.after'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});
```

---

## 🔄 Middleware Priority

Urutan eksekusi middleware (dari `$middlewarePriority`):
1. `StartSession` - Start session terlebih dahulu
2. `ShareErrorsFromSession` - Share errors dari session
3. `Authenticate` - Cek authentication
4. `ThrottleRequests` - Rate limiting
5. `AuthenticateSession` - Session authentication
6. `SubstituteBindings` - Route model binding
7. `Authorize` - Authorization check

---

## 📝 Testing Middleware

### Test dengan Browser
1. Akses route yang di-protect: `/dashboard`
2. Tanpa login → redirect ke `/login`
3. Login dengan role HR → bisa akses `/dashboard/hr`
4. Login dengan role Job Seeker → 403 jika akses `/dashboard/hr`

### Test dengan Postman/cURL
```bash
# Test API dengan token
curl -H "Authorization: Bearer your-token-here" http://localhost:8000/api/users

# Test rate limiting
for i in {1..10}; do curl http://localhost:8000/limited-access; done

# Test dengan parameter age
curl "http://localhost:8000/adult-content?age=17"  # Akan redirect
curl "http://localhost:8000/adult-content?age=20"  # Berhasil
```

---

## ✅ Fitur yang Sudah Diimplementasikan

- [x] Global Middleware
- [x] Route Middleware
- [x] Middleware Groups
- [x] Middleware dengan Parameter
- [x] Multiple Middleware
- [x] Middleware Priority
- [x] Terminable Middleware (LogAfterRequest)
- [x] Role-based Authorization
- [x] Token Authentication
- [x] IP Whitelist
- [x] Age Verification
- [x] Request Logging
- [x] Response Modification
- [x] Rate Limiting (Throttle)
- [x] CSRF Protection
- [x] Maintenance Mode
- [x] Controllers (AdminController, HRController, JobSeekerController)
- [x] Complete Views (Admin, HR, Job Seeker dashboards)

---

## 🎨 Views yang Sudah Dibuat

### Admin Views
- `resources/views/admin/dashboard.blade.php` - Admin dashboard dengan statistik
- `resources/views/admin/users.blade.php` - User management dengan table
- `resources/views/admin/settings.blade.php` - System settings
- `resources/views/admin/reports.blade.php` - System reports

### HR Views
- `resources/views/dashboard/hr.blade.php` - HR dashboard
- `resources/views/dashboard/hr-users.blade.php` - Manage job seekers

### Job Seeker Views
- `resources/views/dashboard/jobseeker.blade.php` - Job seeker dashboard
- `resources/views/dashboard/jobseeker-applications.blade.php` - Applications list

---

## 🚀 Cara Test Project

1. **Jalankan server:**
   ```bash
   php artisan serve
   ```

2. **Akses halaman:**
   - Home: `http://127.0.0.1:8000/`
   - Login: `http://127.0.0.1:8000/login`
   - Dashboard: `http://127.0.0.1:8000/dashboard`
   - HR Dashboard: `http://127.0.0.1:8000/dashboard/hr`
   - Job Seeker: `http://127.0.0.1:8000/dashboard/jobseeker`

3. **Test Middleware:**
   - Adult Content: `http://127.0.0.1:8000/adult-content?age=25`
   - Restricted: `http://127.0.0.1:8000/restricted-access`
   - API: `http://127.0.0.1:8000/api/users` (butuh token)

---

## 📚 Referensi
- Laravel Middleware Documentation: https://laravel.com/docs/middleware
- Middleware Priority: https://laravel.com/docs/middleware#sorting-middleware
- Terminable Middleware: https://laravel.com/docs/middleware#terminable-middleware
