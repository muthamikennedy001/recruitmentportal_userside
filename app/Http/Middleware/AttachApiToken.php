<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AttachApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the API token is available in the session
        if (Session::has('api_token')) {
            $token = Session::get('api_token');
            // Attach the token to the Authorization header
            $request->headers->set('Authorization', 'Bearer ' . $token);
        } else {
            // Store the current URL in the session before redirecting
            Session::put('url.intended', url()->current());

            // Redirect to the login page if the API token is not present
            return redirect()->route('login')->with('message', 'Please login to access this page.');
        }

        // Proceed with the next middleware or request
        return $next($request);
    }
}
