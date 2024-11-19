<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = env('APP_KEY');

        if ($request->header('X-Secret-Password') !== $key) {
            return response()->json(['message' => 'Forbidden, please, contact P.O.'], 403);
        }

        return $next($request);
    }
}
