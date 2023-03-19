<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Query\Query;
use App\Http\Resources\V1\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public static $filters = [
        'semester' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'], 
        'departmentId' => ['eq', 'ne'],
    ];

    public function index()
    {
        $subjects = Subject::all();
        $includeDepartment = request()->query('includeDepartment');
        
        if ($includeDepartment) {
            $subjects = $subjects->loadMissing('department');
        }

        $subjects = Query::filtering(self::$filters, request()->all(), $subjects);

        return SubjectResource::collection($subjects);
    }

    public function show(Subject $subject)
    {
        $includeDepartment = request()->query('includeDepartment');
        if ($includeDepartment) {
            $subject = $subject->loadMissing('department');
        }

        return new SubjectResource($subject);
    }

}
