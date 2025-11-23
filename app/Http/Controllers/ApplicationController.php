<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use App\Models\Notification;
use App\Models\User;
use App\Mail\NewApplicationMail;
use App\Mail\ApplicationStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::with(['user', 'job'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        
        return view('applications.index', compact('applications'));
    }

    /**
     * Display all applications (for admin)
     */
    public function adminIndex()
    {
        $applications = Application::with(['user', 'job'])
            ->latest()
            ->get();
        
        return view('applications.admin-index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($jobId)
    {
        $job = JobVacancy::findOrFail($jobId);
        return view('applications.create', compact('job'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
        ]);

        // Get all admins
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            // 1. Kirim email ke admin dengan link download CV
            Mail::to($admin->email)->send(new NewApplicationMail($application));

            // 2. Simpan notifikasi ke database
            Notification::create([
                'user_id' => $admin->id,
                'application_id' => $application->id,
                'type' => 'new_application',
                'title' => 'Lamaran Baru dari ' . $application->user->name,
                'message' => $application->user->name . ' melamar posisi ' . $application->job->title . ' di ' . $application->job->company,
                'is_read' => false,
            ]);
        }

        return redirect()->route('jobs.show', $jobId)
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $application = Application::findOrFail($id);
        return view('applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);

        $request->validate([
            'cv' => 'nullable|mimes:pdf|max:2048',
            'status' => 'required|in:Pending,Accepted,Rejected',
        ]);

        $data = $request->only('status');

        if ($request->hasFile('cv')) {
            // Delete old CV
            if ($application->cv) {
                Storage::disk('public')->delete($application->cv);
            }
            $data['cv'] = $request->file('cv')->store('cvs', 'public');
        }

        $application->update($data);

        return redirect()->route('applications.index')
            ->with('success', 'Lamaran berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        
        // Delete CV file
        if ($application->cv) {
            Storage::disk('public')->delete($application->cv);
        }
        
        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Lamaran berhasil dihapus!');
    }

    /**
     * Accept application and send email to user
     */
    public function accept($id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'accepted';
        $application->save();

        // Send email to user
        Mail::to($application->user->email)->send(new ApplicationStatusMail($application, 'accepted'));

        return redirect()->back()->with('success', 'Lamaran diterima! Email telah dikirim ke pelamar.');
    }

    /**
     * Reject application and send email to user
     */
    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'rejected';
        $application->save();

        // Send email to user
        Mail::to($application->user->email)->send(new ApplicationStatusMail($application, 'rejected'));

        return redirect()->back()->with('success', 'Lamaran ditolak! Email telah dikirim ke pelamar.');
    }

    /**
     * Export applications to Excel
     */
    public function export()
    {
        $applications = Application::with(['user', 'job'])->get();
        
        $filename = 'applications-' . date('Y-m-d-His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['ID', 'Applicant Name', 'Applicant Email', 'Job Title', 'Company', 'CV', 'Status', 'Applied At']);
            
            // Data
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->id,
                    $application->user->name,
                    $application->user->email,
                    $application->job->title,
                    $application->job->company,
                    $application->cv,
                    $application->status,
                    $application->created_at,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
