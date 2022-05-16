<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQModel;
use App\Http\Requests\CreateMCQModelRequest;
use App\Http\Requests\DeleteMCQModelRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MCQModelController extends Controller
{
    public function create(CreateMCQModelRequest $request) {
        $request->validated();
        
        $a = MCQModel::create(['title' => $request['title']]);
        $a->save();

        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id,
        ), 200);
    }

    public function delete(DeleteMCQModelRequest $request) {
        $request->validated();

        try {
            $mcq = MCQModel::findOrFail($request->id);
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
        return view('model.edit', ['model' => MCQModel::findOrFail($request->id)]);
    }

    public function menuView(Request $request) {
        $models = MCQModel::all();

        return view('model.menu', ['models' => $models]);
    }
}
