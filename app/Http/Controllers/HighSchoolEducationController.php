<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class HighSchoolEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');
        $assessment_id = $request->input('assessment_id');
        $job_id = $request->input('job_id');

        // Validate incoming request
        $request->validate([
            'school' => 'required|string|max:255',
            'grade' => 'required|string|max:10',
            'kcseYear' => 'required|integer',
            'kcseCertificate' => 'required|file|mimes:pdf|max:2048', // Adjust validation rules as needed
        ]);

        // Collecting input data to send to the API
        $data = [
            'school' => $request->input('school'),
            'grade' => $request->input('grade'),
            'kcseYear' => $request->input('kcseYear'),
        ];

        $filePath = $request->file('kcseCertificate')->getPathname();
        $fileName = $request->file('kcseCertificate')->getClientOriginalName();
        $fileMime = $request->file('kcseCertificate')->getMimeType();

        $attempts = 5;


        while ($attempts > 0) {
            $response = Http::withToken($token)
                ->attach('kcseCertificate', file_get_contents($filePath), $fileName)
                ->post("{$baseUrl}/api/user/secondaryEducation", $data);

            if ($response->successful()) {
                Log::info('API Response successful for /api/user/secondaryEducation', ['response' => $response->json()]);
                return redirect()->route('checkUserData', ['assessment_id' => $assessment_id, 'job_id' => $job_id])
                    ->with('success', 'High School Education Details submitted successfully.');
                break; // Exit loop on success
            } else {
                $attempts--;
                Log::error('API Response failed for /api/user/secondaryEducation', [
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
        $secondaryEducation = $request->input('secondaryEducation');


        return view('users.updatehighschooleducation', ['secondaryEducation' => $secondaryEducation]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');

        // Validate incoming request
        $request->validate([
            'school' => 'required|string|max:255',
            'grade' => 'required|string|max:10',
            'kcseYear' => 'required|integer',
            'kcseCertificate' => 'file|mimes:pdf|max:2048', // Adjust validation rules as needed
        ]);

        // Collecting input data to send to the API
        $data = [
            '_method' => 'PUT',
            'school' => $request->input('school'),
            'grade' => $request->input('grade'),
            'kcseYear' => $request->input('kcseYear'),
        ];

        if ($request->hasFile('kcseCertificate')) {
            $filePath = $request->file('kcseCertificate')->getPathname();
            $fileName = $request->file('kcseCertificate')->getClientOriginalName();
            $fileMime = $request->file('kcseCertificate')->getMimeType();
        }

        $attempts = 5;

        while ($attempts > 0) {
            $response = Http::withToken($token);

            if ($request->hasFile('kcseCertificate')) {
                $response = $response->attach('kcseCertificate', file_get_contents($filePath), $fileName, ['Content-Type' => $fileMime]);
            }

            $response = $response->post("{$baseUrl}/api/user/secondaryEducation/{$id}", $data);

            if ($response->successful()) {
                Log::info('API Response successful for /api/user/secondaryEducation', ['response' => $response->json()]);
                return redirect()->route('dashboard')
                    ->with('success', 'High School Education Details updated successfully.');
                break; // Exit loop on success
            } else {
                $attempts--;
                Log::error('API Response failed for /api/user/secondaryEducation', [
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
