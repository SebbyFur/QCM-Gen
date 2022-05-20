<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQModel;
use App\Models\MCQModelData;
use App\Models\Question;
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
            $mcqdata = MCQModelData::where('id_model', $request->id);
            $mcq = MCQModel::findOrFail($request->id);
            $mcqdata->delete();
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

    public function readView(Request $request) {
        return view('model.edit', [
            'model' => MCQModel::findOrFail($request->id),
            'data' => Question::join('mcq_model_data', function($join) {
                $join->on('questions.id', '=', 'mcq_model_data.id_question');
            })->where('id_model', $request->id)->get()
            ->makeHidden(['id_mcq'])
        ]);
    }

    public function menuView(Request $request) {
        $models = MCQModel::all();

        return view('model.menu', ['models' => $models]);
    }
}
