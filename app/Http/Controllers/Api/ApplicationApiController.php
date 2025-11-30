<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class ApplicationApiController extends Controller
{
    /**
     * @OA\Get(path="/api/applications", summary="List applications", tags={"Applications"}, security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="page", in="query", required=false),
     *   @OA\Parameter(name="per_page", in="query", required=false),
     *   @OA\Response(response=200, description="Paginated applications")
     * )
     */
    public function index(Request $req)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $apps = Application::with(['user', 'job'])
            ->latest()
            ->paginate($req->get('per_page', 10));
        return response()->json($apps);
    }

    /**
     * @OA\Post(path="/api/jobs/{id}/apply", summary="Apply to job", tags={"Applications"}, security={{"bearerAuth":{}}},
     *   @OA\Response(response=201, description="Application submitted")
     * )
     */
    public function store(Request $req, JobVacancy $jobVacancy)
    {
        $req->validate([
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        $cvPath = $req->file('cv')->store('cvs', 'public');

        $app = Application::create([
            'user_id' => $req->user()->id,
            'job_id' => $jobVacancy->id,
            'cv' => $cvPath,
            'status' => 'Pending',
        ]);

        return response()->json(['message' => 'Application submitted', 'application' => $app], 201);
    }

    /**
     * @OA\Patch(path="/api/applications/{id}/status", summary="Update application status", tags={"Applications"}, security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id", in="path", required=true),
     *   @OA\RequestBody(@OA\MediaType(mediaType="application/json", @OA\Schema(@OA\Property(property="status", type="string", enum={"Accepted","Rejected"}))), required=true),
     *   @OA\Response(response=200, description="Status updated")
     * )
     */
    public function updateStatus(Request $req, Application $application)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $req->validate([
            'status' => 'required|in:Accepted,Rejected'
        ]);
        $application->update(['status' => $data['status']]);
        return response()->json(['message' => 'Status updated', 'application' => $application]);
    }
}
