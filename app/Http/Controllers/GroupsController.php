<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\DeleteGroupRequest;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class GroupsController extends Controller
{
    public function read() {
        return Group::all();
    }

    public function menuView() {
        return view('students.menu', ['groups' => Group::all()]);
    }

    public function create(CreateGroupRequest $request) {
        $request->validated();

        try {
            $a = Group::create(['name_group' => $request->name_group]);
            $a->save();
        } catch (QueryException $err) {
            $id = Group::where(['name_group' => $request->name_group])->first()->id;

            $returnData = array(
                'status' => 'error',
                'id' => $id,
                'message' => "Un groupe avec ce nom existe déjà. #$id"
            );

            return response()->json($returnData, 500);
        }

        $returnData = array(
            'status' => 'success',
            'id' => $a->id
        );
        
        return response()->json($returnData, 200);
    }

    public function update(UpdateGroupRequest $request) {
        $request->validated();

        try {
            $a = Group::where('id', $request->id_group)->firstOrFail();
            $a->update(['name_group' => $request->name_group]);
        } catch (ModelNotFoundException $err) {
            $returnData = array(
                'status' => 'error',
                'message' => "Ce groupe n'existe pas."
            );

            return response()->json($returnData, 500);
        } catch (QueryException $err) {
            $id = Group::where(['name_group' => $request->name_group])->first()->id;

            $returnData = array(
                'status' => 'error',
                'id' => $id,
                'message' => "Un groupe avec ce nom existe déjà. #$id"
            );

            return response()->json($returnData, 500);
        }
        
        return 'true';
    }

    public function delete(DeleteGroupRequest $request) {
        $request->validated();

        try {
            $a = Group::where('id', $request->id_group)->firstOrFail();
            $b = Student::where('group_id', $a->id)->update(['group_id' => NULL]);
            $a->delete();
        } catch (ModelNotFoundException $err) {
            $returnData = array(
                'status' => 'error',
                'message' => "Ce groupe n'existe pas."
            );

            return response()->json($returnData, 500);
        }

        return 'true';
    }
}
