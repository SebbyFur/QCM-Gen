<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\DeleteStudentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function delete(DeleteStudentRequest $request) {
        $request->validated();

        try {
            $a = Student::findOrFail($request->student_id);
            $a->delete();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => 'Etudiant.e non trouvé !',
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
        ), 200);
    }
    
    public function update(UpdateStudentRequest $request) {
        $request->validated();

        try {
            $a = Student::findOrFail($request->student_id);
            $a->update($request->all());
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => 'Etudiant.e non trouvé !',
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
        ), 200);
    }
}
