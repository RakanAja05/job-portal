<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use App\Exports\ApplicationsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
        ]);

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
     * Export applications to Excel
     */
    public function export()
    {
        return Excel::download(new ApplicationsExport, 'applications-' . date('Y-m-d-His') . '.xlsx');
    }
}
