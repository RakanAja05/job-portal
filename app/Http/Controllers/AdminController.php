<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display admin jobs page
     */
    public function index()
    {
        return view('admin.jobs', [
            'title' => 'Admin - Job Management'
        ]);
    }

    /**
     * Display all users
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', [
            'users' => $users,
            'title' => 'User Management'
        ]);
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        return view('admin.settings', [
            'title' => 'Admin Settings'
        ]);
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        return view('admin.reports', [
            'title' => 'Reports'
        ]);
    }
}
