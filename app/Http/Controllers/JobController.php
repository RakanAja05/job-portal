<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy as Job;
use App\Mail\JobCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();
        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'type' => 'required|in:full-time,part-time',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048',
            'recipient_email' => 'nullable|email' // Email untuk notifikasi
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'type' => $request->type,
            'logo' => $logoPath
        ]);

        // Kirim email notifikasi jika ada recipient email
        if ($request->filled('recipient_email')) {
            try {
                Mail::to($request->recipient_email)->send(new JobCreatedMail($job));
                return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan dan email notifikasi telah dikirim!');
            } catch (\Exception $e) {
                return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan, namun gagal mengirim email: ' . $e->getMessage());
            }
        }

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'type' => 'required|in:full-time,part-time',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $logoPath = $job->logo;
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($job->logo) {
                Storage::disk('public')->delete($job->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'type' => $request->type,
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);
        
        // Delete logo if exists
        if ($job->logo) {
            Storage::disk('public')->delete($job->logo);
        }
        
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus');
    }

    /**
     * Export jobs to Excel
     */
    public function export()
    {
        $jobs = Job::all();
        
        $filename = 'jobs-' . date('Y-m-d-His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($jobs) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['ID', 'Title', 'Company', 'Location', 'Description', 'Requirements', 'Type', 'Salary', 'Logo', 'Created At', 'Updated At']);
            
            // Data
            foreach ($jobs as $job) {
                fputcsv($file, [
                    $job->id,
                    $job->title,
                    $job->company,
                    $job->location,
                    $job->description,
                    $job->requirements,
                    $job->type,
                    $job->salary,
                    $job->logo,
                    $job->created_at,
                    $job->updated_at,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import jobs from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $handle = fopen($file->getRealPath(), 'r');
            
            // Skip header
            fgetcsv($handle);
            
            $imported = 0;
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) >= 4) { // At least title, company, location, description
                    Job::create([
                        'title'        => $data[0] ?? '',
                        'company'      => $data[1] ?? '',
                        'location'     => $data[2] ?? '',
                        'description'  => $data[3] ?? '',
                        'requirements' => $data[4] ?? null,
                        'type'         => isset($data[5]) && in_array($data[5], ['full-time', 'part-time']) ? $data[5] : 'full-time',
                        'salary'       => isset($data[6]) && is_numeric($data[6]) ? $data[6] : null,
                        'logo'         => $data[7] ?? null,
                    ]);
                    $imported++;
                }
            }
            
            fclose($handle);
            
            return redirect()->route('jobs.index')->with('success', "Berhasil import {$imported} lowongan kerja!");
        } catch (\Exception $e) {
            return redirect()->route('jobs.index')->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Display public job listings (for all users including guests)
     */
    public function publicIndex()
    {
        $jobs = Job::latest()->get();
        return view('jobs.public-index', compact('jobs'));
    }

    /**
     * Display public job details (for all users including guests)
     */
    public function publicShow(string $id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.public-show', compact('job'));
    }
}
