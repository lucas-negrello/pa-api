<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogLoginAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->isMethod('post')) {
            $timestamp = now();
            $email = $request->input('email');
            $success = false;

            if (auth()->attempt($request->only('email', 'password'))) {
                $success = true;
            }

            Log::channel('login')->info('Login Attempt:', [
                'email' => $email,
                'success' => $success,
                'timestamp' => $timestamp,
            ]);
        }
        return $next($request);
    }
}
