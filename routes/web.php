<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Public Job Listings - bisa diakses tanpa login
Route::get('/', [JobController::class, 'publicIndex'])->name('home');
Route::get('/jobs/public/{job}', [JobController::class, 'publicShow'])->name('jobs.public.show');

// Dashboard untuk semua user yang login
Route::get('/dashboard', [JobController::class, 'publicIndex'])->middleware(['auth', 'verified'])->name('dashboard');

// User Dashboard - hanya untuk role 'user'
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
});

// Admin Dashboard - hanya untuk role 'admin'
Route::middleware(['auth', 'verified', 'isAdmin', 'log.after'])->prefix('admin')->group(function () {
    Route::get('/jobs', [AdminController::class, 'index'])->name('admin.jobs');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

// Job CRUD Routes - hanya untuk admin
Route::resource('jobs', JobController::class)->middleware(['auth', 'isAdmin']);

// Export & Import Routes - hanya untuk admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/jobs/export/excel', [JobController::class, 'export'])->name('jobs.export');
    Route::post('/jobs/import/excel', [JobController::class, 'import'])->name('jobs.import');
    Route::get('/admin/applications', [App\Http\Controllers\ApplicationController::class, 'adminIndex'])->name('admin.applications');
    Route::get('/applications/export/excel', [App\Http\Controllers\ApplicationController::class, 'export'])->name('applications.export');
});

// Application Routes - untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/{job}/apply', [App\Http\Controllers\ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{job}/apply', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications', [App\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [App\Http\Controllers\ApplicationController::class, 'show'])->name('applications.show');
    Route::delete('/applications/{application}', [App\Http\Controllers\ApplicationController::class, 'destroy'])->name('applications.destroy');
});

// Preview Email Template (untuk testing)
Route::get('/email-preview', function () {
    $job = App\Models\JobVacancy::first();
    
    if (!$job) {
        // Create dummy job for preview
        $job = new App\Models\JobVacancy([
            'title' => 'Senior Web Developer',
            'company' => 'PT Technology Indonesia',
            'location' => 'Jakarta',
            'type' => 'full-time',
            'salary' => 15000000,
            'description' => 'Kami mencari Senior Web Developer yang berpengalaman dalam Laravel, Vue.js, dan MySQL. Kandidat yang ideal memiliki minimal 3 tahun pengalaman dalam pengembangan web dan dapat bekerja dalam tim.',
            'logo' => null
        ]);
        $job->id = 1;
    }
    
    return new App\Mail\JobCreatedMail($job);
})->middleware(['auth', 'isAdmin']);

// Profile routes with auth middleware group
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// CONTOH PENGGUNAAN BERBAGAI MIDDLEWARE
// ============================================

// 1. Route dengan middleware CheckAge
Route::get('/adult-content', function () {
    return 'This is adult content, only for 18+';
})->middleware('check.age');

// 2. Route dengan middleware CheckIP (hanya IP tertentu)
Route::get('/restricted-access', function () {
    return 'This page is restricted by IP address';
})->middleware('check.ip');

// 3. API Routes dengan Token Authentication
Route::prefix('api')->middleware(['check.token', 'throttle:60,1'])->group(function () {
    Route::get('/users', function () {
        return response()->json(['users' => []]);
    });
    
    // Token dengan parameter berbeda
    Route::get('/posts', function () {
        return response()->json(['posts' => []]);
    })->middleware('check.token:session');
});

// 4. Route dengan Custom Headers
Route::get('/secure-page', function () {
    return 'This page has custom security headers';
})->middleware('custom.header');

// 5. Route dengan Request Logging
Route::middleware('log.requests')->group(function () {
    Route::get('/logged-route', function () {
        return 'All requests to this route are logged';
    });
});

// 6. Multiple Middleware dengan Parameter
Route::middleware(['auth', 'role:HR,Admin', 'log.after', 'custom.header'])->group(function () {
    Route::get('/super-admin', function () {
        return 'Super protected route with multiple middleware';
    });
});

// 7. Middleware dengan Throttling (Rate Limiting)
Route::middleware('throttle:5,1')->group(function () {
    Route::get('/limited-access', function () {
        return 'This route is limited to 5 requests per minute';
    });
});

require __DIR__.'/auth.php';
