<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckIfUserVerified
{
    public function handle(Request $request, Closure $next)
    {
        $baseUrl = config('app.api_base_url');
        // Retrieve the token from the session
        $token = Session::get('api_token'); // Or however you are storing your API token

        Log::info('Checking if user is verified', [
            'token' => $token ? 'Token Present' : 'No Token'
        ]);

        if (!$token) {
            Log::warning('Authentication token is missing.');
            return redirect()->route('login')->with('error', 'Authentication token is missing.');
        }

        // Make an API request to check the user's verification status
        $response = Http::withToken($token)->get("{$baseUrl}/api/user/verification-status");

        if ($response->successful()) {
            $isVerified = $response->json(); // Adjust this if your API response structure is different
            Log::info('API Response received', ['is_verified' => $isVerified]);

            // Ensure $isVerified is an array and contains the 'verified' key
            if (is_array($isVerified) && array_key_exists('verified', $isVerified) && !$isVerified['verified']) {
                Log::info('User is not verified.');
                Session::flash('modal_message', 'Please verify your email address.');
                return redirect()->route('verification.notice');
            }
        } else {
            Log::error('Failed to check verification status.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            Session::flash('modal_message', 'Failed to check verification status.');
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
