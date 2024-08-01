<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        try {
            $response = Http::post("{$baseUrl}/api/register", [
                'name' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
            ]);

            if ($response->successful()) {
                $loginResponse = Http::post("{$baseUrl}/api/login", [
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]);

                if ($loginResponse->successful()) {
                    $loginData = $loginResponse->json();
                    if ($loginData['status']) {
                        $token = $loginData['token'];
                        Session::put('api_token', $token);
                        Log::info('Registration and login successful.', ['token' => $token]);
                        $intendedUrl = Session::pull('url.intended', route('verification.notice'));
                        // Redirect to the intended URL
                        return redirect($intendedUrl);
                    } else {
                        Log::error('Login after registration failed: ' . $loginData['message']);
                        return back()->withErrors(['failed' => $loginData['message']]);
                    }
                } else {
                    Log::error('API login communication failure: ' . $loginResponse->body());
                    return back()->withErrors(['failed' => 'Failed to communicate with the authentication server for login.']);
                }
            } else {
                Log::error('Registration failed: ' . $response->body());
                return back()->withErrors(['failed' => 'Registration failed, please try again.']);
            }
        } catch (\Exception $e) {
            Log::error('Exception during registration: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        $response = Http::post("{$baseUrl}/api/login", $request->all());

        if ($response->successful()) {
            $responseData = $response->json();

            if ($responseData['status']) {
                $token = $responseData['token'];
                Session::put('api_token', $token);
                Log::info('Login successful, redirecting to intended URL.', ['token' => Session::get('api_token')]);

                // Retrieve the intended URL from the session
                $intendedUrl = Session::pull('url.intended', route('dashboard'));

                // Redirect to the intended URL
                return redirect($intendedUrl);
            } else {
                Log::error('Invalid credentials: ' . $responseData['message']);
                return back()->withErrors(['failed' => $responseData['message']]);
            }
        } else {
            Log::error('API communication failure: ' . $response->body());
            return back()->withErrors(['failed' => 'Failed to communicate with the authentication server.']);
        }
    }


    public function logout(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');

        $response = Http::withToken($token)->post("{$baseUrl}/api/logout");

        if ($response->successful()) {
            Session()->forget('api_token');
            Session::flush();
            Log::info('User logged out successfully.', ['token' => $token]);
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Failed to logout. Please try again.');
        }
    }

    public function verifyNotice()
    {
        return view('auth.verify-email');
    }
    // public function verifyEmail(Request $request, $id, $hash)
    // {
    //     $baseUrl = config('app.api_base_url');
    //     $token = $request->query('token');

    //     if (!$token) {
    //         return redirect()->route('login')->withErrors(['failed' => 'You must be logged in to verify your email.']);
    //     }

    //     // Ensure token format
    //     $bearerToken = 'Bearer ' . urldecode($token);

    //     $response = Http::withToken($bearerToken)->get("{$baseUrl}/api/email/verify/{$id}/{$hash}", [
    //         'expires' => $request->query('expires'),
    //         'signature' => $request->query('signature')
    //     ]);

    //     if ($response->successful()) {
    //         return redirect()->route('dashboard')->with('status', 'Your email has been verified.');
    //     } else {
    //         return redirect()->route('login')->withErrors(['failed' => 'Email verification failed, please try again.']);
    //     }
    // }



    public function verifyHandler(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        $token = Session::get('api_token');
        if (!$token) {
            return redirect('login')->withErrors(['failed' => 'You must be logged in to resend the verification email.']);
        }

        // Make the POST request with the token
        $response = Http::withToken($token)->post("{$baseUrl}/api/email/verification-notification");

        if ($response->successful()) {
            return view('auth.verify-email')->with('status', 'Verification email resent.');
        } else {
            return response()->json(['error' => 'There was an issue resending the email. Please try again.'], $response->status());
        }
    }
}
