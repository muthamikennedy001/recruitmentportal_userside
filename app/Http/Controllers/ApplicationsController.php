<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ApplicationsController extends Controller
{
    public function getApplicationsByUser(Request $request)
    {
        $adminBaseUrl = config('app.api_admin_base_url');
        $baseUrl = config('app.api_base_url');

        $token = Session::get('api_token');

        if (!$token) {
            Log::error('User not authenticated. Token not found in session.');
            return redirect()->back()->withErrors(['error' => 'User not authenticated.']);
        }

        Log::info('Retrieved token from session.', ['token' => $token]);

        // Make GET request to get applications by user with token
        $response = Http::withToken($token)->get("{$baseUrl}/api/user/assessment-attempts");

        Log::info('Sent request to get applications by user.', [
            'url' => "{$baseUrl}/api/user/user/assessment-attempts",
            'response_status' => $response->status()
        ]);

        if ($response->successful()) {
            $applications = $response->json()['data'] ?? [];
            Log::info('Successfully retrieved applications.', ['applications' => $applications]);

            $jobs = [];
            foreach ($applications as $application) {
                $jobId = $application['job_id'];
                Log::info('Fetching job details.', ['job_id' => $jobId]);

                $jobResponse = Http::withToken($token)->timeout(30)->get("{$adminBaseUrl}/api/jobs/{$jobId}");

                Log::info('Sent request to get job details.', [
                    'url' => "{$adminBaseUrl}/api/jobs/{$jobId}",
                    'response_status' => $jobResponse->status()
                ]);

                if ($jobResponse->successful()) {
                    $job = $jobResponse->json();
                    Log::info('Successfully retrieved job details.', ['job' => $job]);

                    $jobs[] = [
                        'application' => $application,
                        'job' => $job
                    ];
                } else {
                    Log::error('Failed to retrieve job details.', [
                        'job_id' => $jobId,
                        'response' => $jobResponse->body()
                    ]);
                }
            }

            // Get current page from request, default to 1
            $currentPage = $request->input('page', 1);

            // Define how many items we want to be visible in each page
            $perPage = 5;

            // Create a new LengthAwarePaginator instance
            $currentItems = array_slice($jobs, ($currentPage - 1) * $perPage, $perPage);
            $paginator = new LengthAwarePaginator(
                $currentItems,
                count($jobs),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            Log::info('Passing paginated jobs data to the view.', ['jobs' => $paginator->items()]);

            // Pass the paginated jobs data to the Blade view
            return view('applications.allapplications', [
                'jobs' => $paginator
            ]);
        } else {
            Log::error('Failed to retrieve applications.', ['response' => $response->body()]);
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve applications.']);
        }
    }

    public function getSpecificJobByApplicationId(Request $request, $applicationId)
    {
        $adminBaseUrl = config('app.api_admin_base_url');
        $baseUrl = config('app.api_base_url');

        $token = Session::get('api_token');

        if (!$token) {
            Log::error('User not authenticated. Token not found in session.');
            return redirect()->back()->withErrors(['error' => 'User not authenticated.']);
        }

        Log::info('Retrieved token from session.', ['token' => $token]);

        $applicationResponse = Http::withToken($token)->get("{$baseUrl}/api/user/specificJobApplication/{$applicationId}");

        Log::info('Sent request to get application details.', [
            'url' => "{$baseUrl}api/user/specificJobApplication/{$applicationId}",
            'response_status' => $applicationResponse->status()
        ]);

        if ($applicationResponse->successful()) {
            $application = $applicationResponse->json()['data'];
            $jobId = $application['job_id'];

            $jobResponse = Http::withToken($token)->timeout(30)->get("{$adminBaseUrl}/api/jobs/{$jobId}");

            Log::info('Sent request to get job details.', [
                'url' => "{$adminBaseUrl}/api/jobs/{$jobId}",
                'response_status' => $jobResponse->status()
            ]);

            if ($jobResponse->successful()) {
                $job = $jobResponse->json();
                Log::info('Successfully retrieved job details.', ['job' => $job, 'application' => $application]);

                return view('applications.myapplications', [
                    'application' => $application,
                    'job' => $job
                ]);
            } else {
                Log::error('Failed to retrieve job details.', [
                    'job_id' => $jobId,
                    'response' => $jobResponse->body()
                ]);
                return redirect()->back()->withErrors(['error' => 'Failed to retrieve job details.']);
            }
        } else {
            Log::error('Failed to retrieve application details.', ['response' => $applicationResponse->body()]);
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve application details.']);
        }
    }
}
