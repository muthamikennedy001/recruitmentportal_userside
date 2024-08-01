<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckIfTestCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $baseUrl = config('app.api_base_url');
        $jobId = $request->query('job_id');
        $assessmentId = $request->query('assessment_id');
        $token = Session::get('api_token'); // Get the token from session storage

        Log::info('Checking test attempt for job and assessment', [
            'job_id' => $jobId,
            'assessment_id' => $assessmentId,
            'token' => $token ? 'Token Present' : 'No Token'
        ]);

        if (!$token) {
            Log::warning('Authentication token is missing.');
            return redirect()->route('login')->with('error', 'Authentication token is missing.');
        }

        $response = Http::withToken($token)->get("{$baseUrl}/api/user/check-test-attempt", [
            'job_id' => $jobId,
            'assessment_id' => $assessmentId,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Log::info('API Response received', ['data' => $data]);

            if ($data['data']['attempted']) {
                Log::info('User has already attempted the test.', ['job_id' => $jobId, 'assessment_id' => $assessmentId]);
                Session::flash('modal_message', 'You have already attempted the quiz. You can Only Attempt Quiz Once .');
                return redirect()->route('posts.index');
            }
        } else {
            Log::error('Failed to check quiz attempt.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            Session::flash('modal_message', 'Failed to check quiz attempt.');
            return redirect()->route('posts.index');
        }

        return $next($request);
    }
}
