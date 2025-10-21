<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Redirect to role-specific dashboard
    $user = auth()->user();
    if ($user && $user->role === 'HR') {
        return redirect()->route('dashboard.hr');
    }
    return redirect()->route('dashboard.jobseeker');
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboards
Route::get('/dashboard/hr', function () {
    return view('dashboard.hr');
})->middleware(['auth', 'verified', 'role:HR'])->name('dashboard.hr');

Route::get('/dashboard/jobseeker', function () {
    return view('dashboard.jobseeker');
})->middleware(['auth', 'verified', 'role:Job Seeker'])->name('dashboard.jobseeker');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
