<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');
        Log::info('Attempting to fetch user profile.', ['token' => $token]);

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
                // Pass all data to the view
                return view('users.myprofile', compact(
                    'userData',
                    'personalDetails',
                    'professionalQualification',
                    'secondaryEducation',
                    'highestEducationLevel',
                    'baseUrlWithStorage'

                ));
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
