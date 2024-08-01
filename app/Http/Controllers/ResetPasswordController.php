<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    //
    public function passwordEmail(Request $request)
    {
        $baseUrl = config('app.api_base_url');
        try {
            $response = Http::post("{$baseUrl}/api/forgot-password", [
                'email' => $request->input('email'),
            ]);

            if ($response->successful()) {
                $token = $response->body();
                // Store the token in the session for later use
                return back()->with('status', 'Password reset link sent to your email.');
            } else {
                Log::error('Password reset request failed: ' . $response->body());
                return back()->withErrors(['email' => 'Failed to send reset link. Please try again.']);
            }
        } catch (\Exception $e) {
            Log::error('Exception during password reset request: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An error occurred. Please try again later.']);
        }
    }

    public function passwordReset($token, Request $request)
    {
        // Extract email from query parameters
        return view('auth.reset-password', ['token' => $token]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);



        $baseUrl = config('app.api_base_url');
        try {
            $response = Http::post("{$baseUrl}/api/reset-password", [
                'token' => $request->input('token'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
            ]);
            Log::info('reset details', ['resetdetails' => $request]);

            if ($response->successful()) {

                return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
            } else {
                Log::error('Password reset failed: ' . $response->body());
                return back()->withErrors(['email' => 'Failed to reset password. Please try again.']);
            }
        } catch (\Exception $e) {
            Log::error('Exception during password reset: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An error occurred. Please try again later.']);
        }
    }
}
