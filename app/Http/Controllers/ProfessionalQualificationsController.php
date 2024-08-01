<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProfessionalQualificationsController extends Controller
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

        Log::debug('Base URL and token', ['baseUrl' => $baseUrl, 'token' => $token]);

        try {
            $request->validate([
                'institution' => 'required|string|max:255',
                'body' => 'required|string|max:255',
                'award' => 'required|string|max:255',
                'professionalCertificate' => 'file|mimes:pdf|max:2048',
            ]);

            Log::info('Validation passed.');

            if (!$request->hasFile('professionalCertificate')) {
                Log::error('No certificate file found in the request.');
                return redirect()->back()->withErrors(['professionalCertificate' => 'File is required.'])->withInput();
            }

            $professionalCertificate = $request->file('professionalCertificate');
            if (!$professionalCertificate->isValid()) {
                Log::error('Uploaded file is not valid.');
                return redirect()->back()->withErrors(['professionalCertificate' => 'Invalid file upload.'])->withInput();
            }

            Log::info('File is valid.');

            $data = [
                'institution' => $request->input('institution'),
                'body' => $request->input('body'),
                'award' => $request->input('award'),
            ];

            Log::debug('Collected data:', $data);

            $fileName = $professionalCertificate->getClientOriginalName();
            $fileMime = $professionalCertificate->getMimeType();
            $filePath = $professionalCertificate->getPathname();

            Log::debug('File details:', ['fileName' => $fileName, 'fileMime' => $fileMime, 'filePath' => $filePath]);

            $attempts = 5;
            while ($attempts > 0) {
                Log::info('Attempting to send request to API', ['attempts_left' => $attempts]);

                try {
                    $response = Http::withToken($token)
                        ->attach('professionalCertificate', fopen($filePath, 'r'), $fileName, ['Content-Type' => $fileMime])
                        ->post("{$baseUrl}/api/user/professionalQualification", $data);

                    Log::info('API request made.');

                    if ($response->successful()) {
                        Log::info('API Response successful for api/user/professionalQualification', ['response' => $response->json()]);
                        return redirect()->route('checkUserData', ['assessment_id' => $assessment_id, 'job_id' => $job_id])
                            ->with('success', 'Professional qualifications submitted successfully.');
                    } else {
                        $attempts--;
                        Log::error('API Response failed for /api/user/professionalQualification', [
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
                        sleep(1);
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
        $professionalQualification = $request->input('$professionalQualification');

        return view('users.updateprofessionalqualification', ['professionalQualification' => $professionalQualification]);
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
            $request->validate([
                'institution' => 'required|string|max:255',
                'body' => 'required|string|max:255',
                'award' => 'required|string|max:255',
                'professionalCertificate' => 'file|mimes:pdf|max:2048',
            ]);

            Log::info('Validation passed.');

            $data = [
                '_method' => 'PUT',
                'institution' => $request->input('institution'),
                'body' => $request->input('body'),
                'award' => $request->input('award'),
            ];

            Log::debug('Collected data:', $data);

            if ($request->hasFile('professionalCertificate')) {
                $professionalCertificate = $request->file('professionalCertificate');
                if (!$professionalCertificate->isValid()) {
                    Log::error('Uploaded file is not valid.');
                    return redirect()->back()->withErrors(['professionalCertificate' => 'Invalid file upload.'])->withInput();
                }

                Log::info('File is valid.');

                $fileName = $professionalCertificate->getClientOriginalName();
                $fileMime = $professionalCertificate->getMimeType();
                $filePath = $professionalCertificate->getPathname();

                Log::debug('File details:', ['fileName' => $fileName, 'fileMime' => $fileMime, 'filePath' => $filePath]);
            }

            $attempts = 5;
            while ($attempts > 0) {
                Log::info('Attempting to send request to API', ['attempts_left' => $attempts]);

                try {
                    $response = Http::withToken($token);

                    if ($request->hasFile('professionalCertificate')) {
                        $fileResource = fopen($filePath, 'r');
                        if (!$fileResource) {
                            Log::error('Failed to open file resource.');
                            return redirect()->back()->withErrors(['professionalCertificate' => 'Failed to open file.'])->withInput();
                        }

                        $response = $response->attach('professionalCertificate', $fileResource, $fileName, ['Content-Type' => $fileMime]);
                    }

                    $response = $response->asMultipart()
                        ->post("{$baseUrl}/api/user/professionalQualification/{$id}", $data);

                    Log::info('API request made.');

                    if ($response->successful()) {
                        Log::info('API Response successful for api/user/professionalQualification', ['response' => $response->json()]);
                        return redirect()->route('dashboard')
                            ->with('success', 'Professional qualifications updated successfully.');
                    } else {
                        $attempts--;
                        Log::error('API Response failed for /api/user/professionalQualification', [
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
                        sleep(1);
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
