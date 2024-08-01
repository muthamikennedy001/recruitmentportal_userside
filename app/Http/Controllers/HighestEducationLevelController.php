<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HighestEducationLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called.');

        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');
        $assessment_id = $request->input('assessment_id');
        $job_id = $request->input('job_id');
        Log::info('Job Id And Assessment', ['job_id' => $job_id, 'assessment' => $assessment_id]);


        Log::debug('Base URL and token', ['baseUrl' => $baseUrl, 'token' => $token]);

        try {
            // Validate incoming request
            $request->validate([
                'institution' => 'required|string|max:255',
                'course' => 'required|string|max:255',
                'grade' => 'required|string|max:50',
                'graduationYear' => 'required|integer',
                'certificate' => 'file|mimes:pdf|max:2048',
            ]);

            Log::info('Validation passed.');

            if (!$request->hasFile('certificate')) {
                Log::error('No certificate file found in the request.');
                return redirect()->back()->withErrors(['certificate' => 'File is required.'])->withInput();
            }

            $certificate = $request->file('certificate');
            if (!$certificate->isValid()) {
                Log::error('Uploaded file is not valid.');
                return redirect()->back()->withErrors(['certificate' => 'Invalid file upload.'])->withInput();
            }

            Log::info('File is valid.');

            $data = [
                'institution' => $request->input('institution'),
                'course' => $request->input('course'),
                'grade' => $request->input('grade'),
                'graduationYear' => $request->input('graduationYear'),
            ];

            Log::debug('Collected data:', $data);

            $fileName = $certificate->getClientOriginalName();
            $fileMime = $certificate->getMimeType();
            $filePath = $certificate->getPathname();

            Log::debug('File details:', ['fileName' => $fileName, 'fileMime' => $fileMime, 'filePath' => $filePath]);

            $attempts = 5;
            $assessmentId = $request->input('assessmentId'); // Assuming 'assessmentId' is part of the request

            while ($attempts > 0) {
                Log::info('Attempting to send request to API', ['attempts_left' => $attempts]);

                try {
                    $response = Http::withToken($token)
                        ->attach('certificate', fopen($filePath, 'r'), $fileName, ['Content-Type' => $fileMime])
                        ->post("{$baseUrl}/api/user/highestEducationLevel", $data);

                    Log::info('API request made.');

                    if ($response->successful()) {
                        Log::info('API Response successful for /api/user/highestEducationLevel', ['response' => $response->json()]);
                        return redirect()->route('checkUserData', ['assessment_id' => $assessment_id, 'job_id' => $job_id])
                            ->with('success', 'Highest Education Details submitted successfully.');
                        break; // Exit loop on success
                    } else {
                        $responseData = $response->json();
                        Log::error('API Response failed for /api/user/highestEducationLevel', [
                            'status' => $response->status(),
                            'response' => $responseData ?? 'No response content',
                        ]);

                        // Check if the user already has a record and break out of the loop
                        if (isset($responseData['message']) && strpos($responseData['message'], 'User already has a highest education level record') !== false) {
                            Log::info('User already has a record, no further retries.');
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Exception occurred during API request.', ['exception' => $e->getMessage()]);
                }

                $attempts--;

                if ($attempts === 0) {
                    $errors = $response->json('errors', ['An error occurred while processing your request. Please try again.']);
                    if (!is_array($errors)) {
                        $errors = ['An error occurred while processing your request. Please try again.'];
                    }
                    Log::error('Errors received from API', ['errors' => $errors]);
                    return redirect()->back()->withErrors($errors)->withInput();
                }

                sleep(1); // Adding delay before retrying
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred in store method.', ['exception' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your request.'])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $highestEducationLevel = $request->input('$highestEducationLevel');


        return view('users.updatehighesteducation', ['highestEducationLevel' => $highestEducationLevel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        Log::info('Update method called.', ['id' => $id]);

        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');


        Log::debug('Base URL and token', ['baseUrl' => $baseUrl, 'token' => $token]);

        try {
            // Validate incoming request
            $request->validate([
                'institution' => 'required|string|max:255',
                'course' => 'required|string|max:255',
                'grade' => 'required|string|max:50',
                'graduationYear' => 'required|integer',
                'certificate' => 'file|mimes:pdf|max:2048',
            ]);

            Log::info('Validation passed.');

            $data = [
                '_method' => 'PUT',
                'institution' => $request->input('institution'),
                'course' => $request->input('course'),
                'grade' => $request->input('grade'),
                'graduationYear' => $request->input('graduationYear'),
            ];

            Log::debug('Collected data:', $data);

            if ($request->hasFile('certificate')) {
                $certificate = $request->file('certificate');
                if (!$certificate->isValid()) {
                    Log::error('Uploaded file is not valid.');
                    return redirect()->back()->withErrors(['certificate' => 'Invalid file upload.'])->withInput();
                }

                Log::info('File is valid.');

                $fileName = $certificate->getClientOriginalName();
                $fileMime = $certificate->getMimeType();
                $filePath = $certificate->getPathname();

                Log::debug('File details:', ['fileName' => $fileName, 'fileMime' => $fileMime, 'filePath' => $filePath]);
            }

            $attempts = 5;
            while ($attempts > 0) {
                Log::info('Attempting to send request to API', ['attempts_left' => $attempts]);

                try {
                    $response = Http::withToken($token);

                    if ($request->hasFile('certificate')) {
                        $fileResource = fopen($filePath, 'r');
                        if (!$fileResource) {
                            Log::error('Failed to open file resource.');
                            return redirect()->back()->withErrors(['certificate' => 'Failed to open file.'])->withInput();
                        }

                        $response = $response->attach('certificate', $fileResource, $fileName, ['Content-Type' => $fileMime]);
                    }

                    $response = $response->asMultipart()
                        ->post("{$baseUrl}/api/user/highestEducationLevel/{$id}", $data);

                    Log::info('API request made.');

                    if ($response->successful()) {
                        Log::info('API Response successful for /api/user/highestEducationLevel', ['response' => $response->json()]);
                        return redirect()->route('dashboard')
                            ->with('success', 'Highest Education Details updated successfully.');
                        break; // Exit loop on success
                    } else {
                        $attempts--;
                        Log::error('API Response failed for /api/user//highestEducationLevel', [
                            'status' => $response->status(),
                            'response' => $response->json() ?? 'No response content'
                        ]);

                        if ($attempts === 0) {
                            $errors = $response->json('errors', ['An error occurred while processing your request. Please try again.']);
                            if (!is_array($errors)) {
                                $errors = ['An error occurred while processing your request. Please try again.'];
                            }
                            Log::error('Errors received from API', ['errors' => $errors]);
                            return redirect()->back()->withErrors($errors)->withInput();
                        }
                        sleep(1); // Wait a second before retrying
                    }
                } catch (\Exception $e) {
                    Log::error('Exception occurred while sending request to API', ['exception' => $e->getMessage()]);
                    $attempts--;
                }
            }
        } catch (\Exception $e) {
            Log::error('Validation or other error', ['exception' => $e->getMessage()]);
            return redirect()->back()->withErrors(['An error occurred: ' . $e->getMessage()])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
