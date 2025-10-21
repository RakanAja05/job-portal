<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller {
public function showLoginForm() {
    return view('auth.login');
}
public function login(Request $request) {
    $credentials = $request->only('email','password');
    if (Auth::attempt($credentials)) {
        // Redirect users based on role
        $user = Auth::user();
        if ($user && $user->role === 'HR') {
            return redirect()->intended(route('dashboard.hr'));
        }
        return redirect()->intended(route('dashboard.jobseeker'));
    }
    return back()->withErrors(['email' => 'Email ataupassword salah.']);
}
public function showRegisterForm() {
    return view('auth.register');
}
public function register (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:HR,Job Seeker',
    ]);
    User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => $request->role ?? 'Job Seeker',
    ]);
    return redirect()->route('login')->with('success','Registrasi berhasil! Silakan login.');
}
public function logout() {
    Auth::logout();
    return redirect()->route('login');
}
}