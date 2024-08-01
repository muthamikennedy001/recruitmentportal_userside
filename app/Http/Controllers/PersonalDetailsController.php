<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PersonalDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'nationalId' => 'required|string|max:10|regex:/^[0-9]{4,10}$/',
            'contactNo' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'address' => 'required|string|max:255|regex:/^[A-Za-z0-9\s.,\-]+$/',
        ]);


        $data = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'nationalId' => $request->input('nationalId'),
            'contactNo' => $request->input('contactNo'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ];

        $attempts = 5;
        while ($attempts > 0) {
            $response = Http::withToken($token)->post("{$baseUrl}/api/user/personaldetails", $data);

            if ($response->successful()) {
                Log::info('API Response successful for /api/user/personaldetails', ['response' => $response->json()]);
                return redirect()->route('checkUserData', ['assessment_id' => $assessment_id, 'job_id' => $job_id])
                    ->with('success', 'Personal details submitted successfully.');
            } else {
                $attempts--;
                Log::error('API Response failed for /api/user/personaldetails', [
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
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $personalDetails = $request->input('personalDetails');


        return view('users.updatepersonaldetails', ['personalDetails' => $personalDetails]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');


        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'nationalId' => 'required|string|max:10|regex:/^[0-9]{4,10}$/',
            'contactNo' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'address' => 'required|string|max:255|regex:/^[A-Za-z0-9\s.,\-]+$/',
        ]);

        $data = [
            '_method' => 'PUT',
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'nationalId' => $request->input('nationalId'),
            'contactNo' => $request->input('contactNo'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ];

        $attempts = 5;
        while ($attempts > 0) {
            $response = Http::withToken($token)
                ->post("{$baseUrl}/api/user/personaldetails/{$id}", $data);

            if ($response->successful()) {
                Log::info('API Response successful for /api/user/personaldetails', ['response' => $response->json()]);
                return redirect()->route('dashboard', ['assessment_id'])
                    ->with('success', 'Personal details updated successfully.');
                break; // Exit loop on success
            } else {
                $attempts--;
                Log::error('API Response failed for /api/user/personaldetails', [
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
