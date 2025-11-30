<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/jobs",
     *   summary="Get all job listings (protected)",
     *   tags={"Jobs"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="keyword", in="query", description="Search keyword", required=false),
     *   @OA\Parameter(name="company", in="query", description="Filter by company", required=false),
     *   @OA\Parameter(name="location", in="query", description="Filter by location", required=false),
     *   @OA\Parameter(name="page", in="query", description="Page number", required=false),
     *   @OA\Parameter(name="per_page", in="query", description="Items per page", required=false),
     *   @OA\Response(response=200, description="Paginated list of jobs")
     * )
     */
    public function index(Request $req)
    {
        $q = JobVacancy::query();

        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                  ->orWhere('company', 'like', "%$kw%")
                  ->orWhere('location', 'like', "%$kw%");
            });
        }
        if ($req->filled('company')) {
            $q->where('company', $req->company);
        }
        if ($req->filled('location')) {
            $q->where('location', $req->location);
        }

        $jobs = $q->orderBy('created_at', 'desc')->paginate($req->get('per_page', 10));
        return response()->json($jobs);
    }

    /**
     * @OA\Get(
     *   path="/api/public/jobs",
     *   summary="Public job listings (no auth)",
     *   tags={"Jobs"},
     *   @OA\Response(response=200, description="Paginated public list of jobs")
     * )
     */
    public function public(Request $req)
    {
        $q = JobVacancy::query();
        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                  ->orWhere('company', 'like', "%$kw%")
                  ->orWhere('location', 'like', "%$kw%");
            });
        }
        if ($req->filled('company')) {
            $q->where('company', $req->company);
        }
        if ($req->filled('location')) {
            $q->where('location', $req->location);
        }
        return response()->json($q->orderBy('created_at', 'desc')->paginate($req->get('per_page', 10)));
    }

    /**
     * @OA\Get(path="/api/jobs/{id}", summary="Show job", tags={"Jobs"}, security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id", in="path", required=true),
     *   @OA\Response(response=200, description="Job detail")
     * )
     */
    public function show(JobVacancy $jobVacancy)
    {
        return response()->json($jobVacancy);
    }

    /**
     * @OA\Post(path="/api/jobs", summary="Create job", tags={"Jobs"}, security={{"bearerAuth":{}}},
     *   @OA\Response(response=201, description="Created")
     * )
     */
    public function store(Request $req)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'nullable|integer',
            'type' => 'nullable|in:full-time,part-time'
        ]);
        $job = JobVacancy::create($data);
        return response()->json(['message' => 'Created', 'job' => $job], 201);
    }

    /**
     * @OA\Put(path="/api/jobs/{id}", summary="Update job", tags={"Jobs"}, security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(Request $req, JobVacancy $jobVacancy)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $req->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'location' => 'sometimes|required',
            'company' => 'sometimes|required',
            'salary' => 'nullable|integer',
            'type' => 'nullable|in:full-time,part-time'
        ]);
        $jobVacancy->update($data);
        return response()->json(['message' => 'Updated', 'job' => $jobVacancy]);
    }

    /**
     * @OA\Delete(path="/api/jobs/{id}", summary="Delete job", tags={"Jobs"}, security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(Request $req, JobVacancy $jobVacancy)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $jobVacancy->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
