<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomePageController extends Controller
{
    //
    public function index(Request $request)
{
    $adminBaseUrl = config('app.api_admin_base_url');

    try {
        // Fetch job postings
        $response = Http::timeout(30)->get("{$adminBaseUrl}/api/jobs");

        if ($response->successful()) {
            $allJobs = $response->json();

            Log::info('Number of jobs fetched:', ['count' => count($allJobs)]);

            if (empty($allJobs)) {
                Log::info('No job postings available.');
                return view('components.home', ['jobs' => []]);
            }

            // Get only the first 3 jobs
            $jobs = collect($allJobs)->take(3);

            Log::info('First 3 Jobs:', ['jobs' => $jobs]);

            return view('components.home', [
                'jobs' => $jobs,
            ]);
        } else {
            Log::error('API request failed.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return view('components.home', ['jobs' => [], 'error' => 'Failed to fetch job postings.']);
        }
    } catch (\Exception $e) {
        Log::error('Exception occurred while fetching job postings.', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return view('components.home', ['jobs' => [], 'error' => 'An error occurred. Please try again later.']);
    }
}

    
}
