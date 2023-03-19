<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        $teacher = $request->user();

        if ($teacher != null and $teacher->tokenCan('teacher-level')) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthenticate.'], 401);
    }
}
