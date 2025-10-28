<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HRController extends Controller
{
    /**
     * Display HR dashboard
     */
    public function index()
    {
        return view('dashboard.hr', [
            'title' => 'HR Dashboard',
            'stats' => [
                'total_applicants' => 0,
                'active_jobs' => 0,
                'pending_applications' => 0,
            ]
        ]);
    }

    /**
     * Display all users (job seekers)
     */
    public function users()
    {
        $users = User::where('role', 'Job Seeker')->get();
        return view('dashboard.hr-users', [
            'users' => $users,
            'title' => 'Manage Job Seekers'
        ]);
    }

    /**
     * Display job postings
     */
    public function jobs()
    {
        return view('hr.jobs', [
            'title' => 'Job Postings'
        ]);
    }

    /**
     * Create new job posting
     */
    public function createJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'nullable|numeric',
        ]);

        // Logic to save job posting
        return redirect()->route('dashboard.hr.jobs')
            ->with('success', 'Job posted successfully!');
    }
}
