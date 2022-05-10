<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Requests\CreateStudentRequest;

class StudentsController extends Controller
{
    public function create(CreateStudentRequest $request) {
        $request->validated();
        
        if ($request->group_id == 'NONE') $request['group_id'] = NULL;
        $a = Student::create($request->all());
        $a->save();

        $a = Student::find($a->id);

        return response()->json(
        array(
            'status' => 'success',
            'first_name' => $a->first_name,
            'last_name' => $a->last_name,
            'id' => $a->id,
        ), 200);
    }

    public function readFromGroup(Request $request) {
        if ($request->group_id == 'NONE') $request->group_id = NULL;
        return Student::where(['group_id' => $request->group_id])->get()->makeHidden(['created_at', 'updated_at']);
    }
}
