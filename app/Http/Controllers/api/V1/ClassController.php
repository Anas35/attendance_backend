<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ClassResource;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClassController extends Controller
{

    public function index()
    {
        try {
            $classes = ClassModel::all();
            return ClassResource::collection($classes);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json([
                'message' => 'Server Error, Please Try again or Contact Support'
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $class = ClassModel::findOrFail($id);
            if ($request->has('includeDept')) {
                $class = $class->loadMissing('department');
            }
            return new ClassResource($class);
        } catch (ModelNotFoundException $th) {
            return response()->json([
                'message' => 'No Class for the specified Class Id found'
            ], 404);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json([
                'message' => 'Server Error, Please Try again or Contact Support'
            ], 500);
        }
    }

}
