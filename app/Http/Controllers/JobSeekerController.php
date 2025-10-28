<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobSeekerController extends Controller
{
    /**
     * Display job seeker dashboard
     */
    public function index()
    {
        return view('dashboard.jobseeker', [
            'title' => 'Job Seeker Dashboard'
        ]);
    }

    /**
     * Display job applications
     */
    public function applications()
    {
        return view('dashboard.jobseeker-applications', [
            'title' => 'My Applications'
        ]);
    }

    /**
     * Display available jobs
     */
    public function jobs()
    {
        return view('jobseeker.jobs', [
            'title' => 'Available Jobs'
        ]);
    }

    /**
     * Apply for a job
     */
    public function apply(Request $request)
    {
        // Validation
        $request->validate([
            'job_id' => 'required|integer',
            'cover_letter' => 'required|string|min:50'
        ]);

        // Logic to save application
        return redirect()->route('dashboard.jobseeker.applications')
            ->with('success', 'Application submitted successfully!');
    }
}
