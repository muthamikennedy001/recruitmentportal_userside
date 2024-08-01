<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ShowFormController extends Controller
{
    public function showForm(Request $request, $assessment_id)
    {
        $job_id = $request->input('job_id');
        Log::info('Assessment ID captured.', ['assessment_id' => $assessment_id]);
        Log::info('Job Id And Assessment', ['job_id' => $job_id, 'assessment' => $assessment_id]);

        try {
            $token = Session::get('api_token');
            
            if (!$token) {
                Log::error('API token not found in session.');
                return response()->json(['error' => 'API token not found'], 401);
            }

            $baseUrl = config('app.api_base_url');
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];

            $response = Http::withHeaders($headers)->get("{$baseUrl}/api/user/educationdetails");

            if ($response->successful()) {
                $data = $response->json()['data'];
                Log::info('Educational data fetched successfully.', ['data' => $data]);

                $missingData = [];
                if (empty($data['personal_details'])) {
                    $missingData['personal_details'] = true;
                }
                if (empty($data['professional_qualifications'])) {
                    $missingData['professional_qualifications'] = true;
                }
                if (empty($data['secondary_education'])) {
                    $missingData['secondary_education'] = true;
                }
                if (empty($data['highest_education_level'])) {
                    $missingData['highest_education_level'] = true;
                }

                if (!empty($missingData)) {
                    Log::info('Missing data detected, redirecting to appropriate form.', ['missing_data' => $missingData]);
                    if (isset($missingData['personal_details'])) {
                        return redirect()->route('personaldetails', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
                    } elseif (isset($missingData['professional_qualifications'])) {
                        return redirect()->route('professionalqualification', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
                    } elseif (isset($missingData['secondary_education'])) {
                        return redirect()->route('highschooleducation', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
                    } elseif (isset($missingData['highest_education_level'])) {
                        return redirect()->route('highesteducationlevel', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
                    }
                } else {
                    Log::info('All required data present, redirecting to assessment.');
                    return redirect()->route('quiz.start', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
                }
            } else {
                Log::error('Failed to fetch educational data.', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return redirect()->route('login')->withErrors(['error' => 'Failed to fetch educational data']);
            }

        } catch (\Exception $e) {
            Log::error('An error occurred while checking educational data.', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
