<?php

use App\Http\Controllers\api\V1\DepartmentController;
use App\Http\Controllers\api\V1\RecordController;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\V1'], function () {
    Route::get('departments', [
        'uses' => 'DepartmentController@index', 
        'as' => 'departments',
    ]);
    Route::apiResource('classes', ClassController::class, [
        'only' => ['index', 'show'],
        'names' => [
            'index' => 'classes',
            'show' => 'class',
        ],
    ]);
    Route::apiResource('subjects', SubjectController::class, [
        'only' => ['index', 'show']
    ]);
    Route::post('students/login', ['uses' => 'StudentController@login']);    
    Route::post('students/register', ['uses' => 'StudentController@register']);

    Route::post('teachers/login', [
        'uses' => 'TeacherController@login', 
        'as' => 'teacher.login',
    ]);
    Route::post('teachers/register', [
        'uses' => 'TeacherController@register', 
        'as' => 'teacher.register',
    ]);
    
    Route::apiResource('students', StudentController::class, [
        'only' => ['show', 'update'],
        'middleware' => ['auth:sanctum', 'user.student'],
    ]);
    Route::get('students', [
        'uses' => 'StudentController@index', 
        'middleware' => ['auth:sanctum', 'user.teacher']
    ]);
    Route::apiResource('teachers', TeacherController::class, [
        'only' => ['show', 'update'],
        'middleware' => ['auth:sanctum', 'user.teacher'],
        'names' => [
            'show' => 'teacher.show',
            'update' => 'teacher.update',
        ],
    ]);
    Route::apiResource('records', RecordController::class, [
        'except' => ['destroy'],
        'middleware' => ['auth:sanctum'],
    ]);
    
    Route::get('students/{student}/records', ['uses' => 'RecordController@studentsRecords']);
    Route::get('students/{student}/recordsToday', ['uses' => 'RecordController@todayStudentRecords']);
    Route::get('classes/{class}/records', ['uses' => 'RecordController@classRecords']);

    Route::post('attendances', [
        'uses' => 'RecordController@bulkStore',
        'middleware' => ['auth:sanctum', 'user.teacher'],
    ]);

    Route::get('images/{type}/{file}', function ($type, $file) {
        $path = $type.'/'.$file;

        if (!Storage::exists($path)) {
            $path = 'public/place_holder.png';
        }
        
        $content = Storage::get($path);
        $mime = Storage::mimeType($path);

        return Response::make($content, 200)->header("Content-Type", $mime);   
    });
});

Route::fallback(function () {
    return response()->json([
        'message' => 'API Page Not Found. Please enter the valid URL',
    ], 404);
});