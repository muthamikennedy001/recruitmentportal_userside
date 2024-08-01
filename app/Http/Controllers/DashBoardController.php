<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashBoardController extends Controller
{
    public function index(Request $request)
    {
        $adminBaseUrl = config('app.api_admin_base_url');
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');

        if (!$token) {
            Log::error('User not authenticated. Token not found in session.');
            return redirect()->back()->withErrors(['error' => 'User not authenticated.']);
        }

        Log::info('Retrieved token from session.', ['token' => $token]);

        // Define headers for API requests
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        // Fetch user profile data
        $profileResponse = Http::withHeaders($headers)->get("{$baseUrl}/api/profile");

        if ($profileResponse->successful()) {
            $userData = $profileResponse->json();
            Log::info('User profile fetched successfully.', ['userData' => $userData]);

            // Fetch educational details
            $educationResponse = Http::withHeaders($headers)->get("{$baseUrl}/api/user/educationdetails");

            if ($educationResponse->successful()) {
                $educationData = $educationResponse->json()['data'];

                // Extracting data from the response
                $personalDetails = $educationData['personal_details'][0] ?? null;
                $professionalQualification = $educationData['professional_qualifications'][0] ?? null;
                $secondaryEducation = $educationData['secondary_education'][0] ?? null;
                $highestEducationLevel = $educationData['highest_education_level'][0] ?? null;

                Log::info('Educational data fetched successfully.', ['educationData' => $educationData]);
                $baseUrlWithStorage = rtrim($baseUrl, '/') . '/storage';

                // Fetch all job postings
                try {
                    $allJobsResponse = Http::timeout(30)->get("{$adminBaseUrl}/api/jobs");

                    if ($allJobsResponse->successful()) {
                        $allJobs = $allJobsResponse->json();
                        Log::info('Number of jobs fetched:', ['count' => count($allJobs)]);

                        if (empty($allJobs)) {
                            Log::info('No job postings available.');
                        } else {
                            // Get only the first 3 jobs
                            $topJobs = collect($allJobs)->take(3);
                            Log::info('First 3 Jobs:', ['jobs' => $topJobs]);
                        }
                    } else {
                        Log::error('API request failed.', [
                            'status' => $allJobsResponse->status(),
                            'body' => $allJobsResponse->body()
                        ]);
                        $allJobs = [];
                        $topJobs = [];
                    }
                } catch (\Exception $e) {
                    Log::error('Exception occurred while fetching job postings.', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $allJobs = [];
                    $topJobs = [];
                }

                // Fetch applications by user
                $response = Http::withToken($token)->get("{$baseUrl}/api/user/my-applications");

                Log::info('Sent request to get applications by user.', [
                    'url' => "{$baseUrl}/api/user/my-applications",
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

                    // Get the first three jobs
                    $jobs = array_slice($jobs, 0, 3);

                    Log::info('Passing job data to the view.', ['jobs' => $jobs]);
                } else {
                    Log::error('Failed to retrieve applications.', ['response' => $response->body()]);
                    $jobs = [];
                }

                // Fetch interviews for the applicant
                $applicantId = $applications[0]['applicant']['user_id'] ?? null;
                $interviews = [];

                if ($applicantId) {
                    try {
                        Log::info('Fetching interviews for applicant.', ['applicant_id' => $applicantId]);

                        $url = "{$adminBaseUrl}/api/interview";
                        $parameters = ['applicant_user_id' => $applicantId];

                        Log::info('Interview request URL and body.', ['url' => $url, 'body' => $parameters]);

                        $interviewResponse = Http::get($url, $parameters);

                        if ($interviewResponse->successful()) {
                            $interviews = $interviewResponse->json()['interviews'];
                            Log::info('Number of interviews fetched.', ['count' => count($interviews)]);
                        } else {
                            Log::error('Failed to fetch interviews.', [
                                'status' => $interviewResponse->status(),
                                'body' => $interviewResponse->body()
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::error('Exception occurred while fetching interviews.', [
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    Log::warning('Applicant ID is not set.');
                }

                // Process the interview data for FullCalendar
                $events = array_map(function ($interview) {
                    return [
                        'title' => $interview['title'],
                        'start' => $interview['interview_date'] . 'T' . $interview['interview_time'],
                        'extendedProps' => [
                            'jobTitle' => $interview['job_title'],
                            'requirements' => sprintf(
                                "You have an interview for %s job at %s . The following are the requirements: %s",
                                $interview['job_title'],
                                $interview['location_name'],
                                $interview['requirements']
                            )
                        ]
                    ];
                }, $interviews);

                // Pass all data to the view
                return view('users.dashboard', [
                    'jobs' => $jobs,
                    'allJobs' => $allJobs ?? [],
                    'topJobs' => $topJobs ?? [],
                    'events' => $events,
                    'userData' => $userData,
                    'personalDetails' => $personalDetails,
                    'professionalQualification' => $professionalQualification,
                    'secondaryEducation' => $secondaryEducation,
                    'highestEducationLevel' => $highestEducationLevel,
                    'baseUrlWithStorage' => $baseUrlWithStorage,
                ]);
            } else {
                Log::error('Failed to fetch educational data.', [
                    'status' => $educationResponse->status(),
                    'response' => $educationResponse->body()
                ]);
                return redirect()->route('login')->withErrors(['error' => 'Failed to fetch educational data']);
            }
        } else {
            Log::error('Failed to fetch user profile.', [
                'status' => $profileResponse->status(),
                'response' => $profileResponse->body()
            ]);
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized']);
        }
    }
}
