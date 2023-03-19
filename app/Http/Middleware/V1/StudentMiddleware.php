<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        $teacher = $request->user();

        if ($teacher->tokenCan('student-level')) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthenticate.'], 401);
    }
}
