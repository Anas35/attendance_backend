<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;

use App\Http\Resources\V1\DepartmentResource;

class DepartmentController extends Controller
{
    
    public function index()
    {
        try {
            $departments = Department::all();
            return DepartmentResource::collection($departments);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json([
                'message' => 'Server Error, Please Try again or Contact Support'
            ], 500);
        }
    }

}
