<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RecordResource;
use App\Models\Record;
use App\Http\Requests\V1\StoreBulkRecordRequest;
use App\Models\Student;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecordController extends Controller
{
    public function index()
    {
        return RecordResource::collection(Record::all());
    }

    public function todayStudentRecords(Student $student) {
        
        $records = Record::with('subject')
            ->where('records.reg_no', '=', $student->reg_no)
            ->whereDate('date', '>=', Carbon::now()->toDate())
            ->whereDate('date', '<=', Carbon::now()->toDate())
            ->get(['subject_id', 'is_present']);
            
        return RecordResource::collection($records);
    }

    public function studentsRecords(Student $student) {
        
        $records = DB::table('records')
            ->selectRaw(DB::raw('records.subject_id'))
            ->selectRaw(DB::raw('subjects.subject_name'))
            ->selectRaw(DB::raw('SUM(records.is_present = 1) as present'))
            ->selectRaw(DB::raw('SUM(records.is_present = 0) as absent'))
            ->selectRaw(DB::raw('round(AVG(records.is_present = 1) * 100, 0) as percentage'))
            ->where('records.reg_no', '=', $student->reg_no)
            ->whereExists(function ($query) {
                $date = request()->input('from');
                if (isset($date)) {
                    $query->whereDate('date', '>=', Carbon::parse($date));
                }
            })
            ->leftjoin('subjects','subjects.subject_id','=','records.subject_id')
            ->whereExists(function ($query) {
                $date = request()->input('until');
                if (isset($date)) {
                    $query->whereDate('date', '<=', Carbon::parse($date));
                }
            })
            ->groupBy('subject_id')
            ->get();

        $subjectId = request()->input('subjectId');
        if (isset($subjectId)) {
            $records = $records->where('subject_id', '=', $subjectId);
        }
            
        return RecordResource::collection($records);
    }

    public function classRecords($classId) {
        
        $records = DB::table('records')
            ->selectRaw(DB::raw('reg_no'))
            ->selectRaw(DB::raw('SUM(is_present = 1) as present'))
            ->selectRaw(DB::raw('SUM(is_present = 0) as absent'))
            ->selectRaw(DB::raw('round(AVG(is_present = 1) * 100, 0) as percentage'))
            ->where('class_id', '=', $classId)
            ->whereExists(function ($query) {
                $date = request()->input('from');
                if (isset($date)) {
                    $query->whereDate('date', '>=', Carbon::parse($date));
                }
            })
            ->whereExists(function ($query) {
                $date = request()->input('until');
                if (isset($date)) {
                    $query->whereDate('date', '<=', Carbon::parse($date));
                }
            })
            ->groupBy('reg_no')
            ->get();
        
        $subjectId = request()->input('subjectId');
        if (isset($subjectId)) {
            $records = $records->where('subject_id', '=', $subjectId);
        }
            
        return RecordResource::collection($records);
    }
    
    public function bulkStore(StoreBulkRecordRequest $request)
    {
        $records = collect($request->all());
        $date = Carbon::now()->toDateTimeString();
        
        foreach (array_values($records['records']) as $value) {
            Record::create(array(
                "subject_id" => $records['subjectId'],
                "teacher_id" => $records['teacherId'],
                "class_id" => $records['classId'],
                "reg_no" => collect($value)['regNo'],
                "is_present" => collect($value)['present'],
                "date" => $date,
            ));
        }
    }

    public function show(Record $record)
    {
        return new RecordResource($record);
    }

}