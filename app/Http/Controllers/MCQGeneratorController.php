<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQGenerator;
use App\Http\Requests\CreateMCQGeneratorRequest;
use App\Http\Requests\DeleteMCQGeneratorRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MCQGeneratorController extends Controller
{
    public function create(CreateMCQGeneratorRequest $request) {
        $request->validated();
        
        $a = MCQGenerator::create(['title' => $request['title']]);
        $a->save();

        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id,
        ), 200);
    }

    public function delete(DeleteMCQGeneratorRequest $request) {
        $request->validated();

        try {
            $mcq = MCQGenerator::findOrFail($request->id);
            $mcq->delete();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => 'Aucun QCM avec cet ID !'
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
        ), 200);
    }

    public function read(Request $request) {
        return view('mcq.edit', ['mcq' => MCQGenerator::findOrFail($request->id)]);
    }

    public function menuView(Request $request) {
        $mcqs = MCQGenerator::all();

        return view('mcq.menu', ['mcqs' => $mcqs]);
    }
}
