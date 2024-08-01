<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobPostingsController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $adminBaseUrl = config('app.api_admin_base_url');
        $modal = $request->query('modal', false);
        $result = $request->query('result', "none");
        Log::info("result",['result'=>$result]);
        try {
            // Fetch job postings
            $response = Http::timeout(30)->get("{$adminBaseUrl}/api/jobs");
    
            if ($response->successful()) {
                $allJobs = $response->json();
    
                Log::info('Number of jobs fetched:', ['count' => count($allJobs)]);
    
                if (empty($allJobs)) {
                    Log::info('No job postings available.');
                    return view('posts.index', ['jobs' => [], 'currentPage' => 1, 'totalPages' => 1,'modal' => $modal, 'result' => $result]);
                }
    
                $request->session()->put('jobs',$allJobs);
                // Laravel's built-in paginator
                $perPage = 6;
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $collection = collect($allJobs);
                $paginatedJobs = new LengthAwarePaginator(
                    $collection->forPage($currentPage, $perPage),
                    $collection->count(),
                    $perPage,
                    $currentPage,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
             
    
                Log::info('Paginated Jobs:', ['jobs' => $paginatedJobs->items(), 'currentPage' => $currentPage, 'totalPages' => $paginatedJobs->lastPage()]);
    
                return view('posts.index', [
                    'jobs' => $paginatedJobs->items(),
                    'paginatedJobs' => $paginatedJobs,
                    'currentPage' => $currentPage,
                    'totalPages' => $paginatedJobs->lastPage(),
                    'modal' => $modal,
                    'result' => $result
                ]);
            } else {
                Log::error('API request failed.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return view('posts.index', ['jobs' => [], 'currentPage' => 1, 'totalPages' => 1, 'error' => 'Failed to fetch job postings.','modal' => $modal, 'result' => $result]);
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching job postings.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('posts.index', ['jobs' => [], 'currentPage' => 1, 'totalPages' => 1, 'error' => 'An error occurred. Please try again later.','modal' => $modal, 'result' => $result]);
        }
    }
    
    


    public function show($post)
    {
        $adminBaseUrl = config('app.api_admin_base_url');
    
        // Fetch job by ID
        $jobId = $post;
    
        try {
            $response = Http::timeout(30)->get("{$adminBaseUrl}/api/jobs/{$jobId}");
    
            if ($response->successful()) {
                $job = $response->json();
    
                Log::info('job', ['job' => $job]);
    
                // Fetch similar jobs by category ID
                $categoryId = $job['category_id'];
                $similarJobs = $this->fetchSimilarJobs($adminBaseUrl, $categoryId);
    
                return view('posts.specificjob', ['job' => $job, 'similarJobs' => $similarJobs]);
            } else {
                Log::error('API request failed.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
    
                return view("posts.specificjob", ['job' => null, 'similarJobs' => [], 'error' => 'Failed to fetch job.' ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching job.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return view("posts.specificjob", ['job' => null, 'similarJobs' => [], 'error' => 'An error occurred. Please try again later.']);
        }
    }
    
    private function fetchSimilarJobs($adminBaseUrl, $categoryId)
    {
        try {
            $response = Http::timeout(30)->get("{$adminBaseUrl}/api/categories/jobs", [
                'category_id' => $categoryId
            ]);
    
            if ($response->successful()) {
                $similarJobs = $response->json();
                Log::info('similar jobs', ['similarJobs' => $similarJobs]);
                return $similarJobs;
            } else {
                Log::error('Failed to fetch similar jobs.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return [];
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching similar jobs.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }
    

   
}