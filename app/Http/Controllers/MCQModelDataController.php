<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQModelData;
use App\Models\Question;
use App\Http\Requests\CreateMCQModelDataRequest;
use App\Http\Requests\DeleteMCQModelDataRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class MCQModelDataController extends Controller
{
    public function create(CreateMCQModelDataRequest $request) {
        $request->validated();
        
        $a = MCQModelData::firstOrNew($request->all());
        if ($a->exists) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => 'Les données sont déjà présentes.'
            ), 500);
        }

        $a->save();

        $q = Question::where('id', $request->id_question)->get(['question', 'is_valid'])->first();
        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id,
            'id_question' => $request->id_question,
            'question' => $q->question,
            'is_valid' => $q->is_valid
        ), 200);
    }

    public function delete(DeleteMCQModelDataRequest $request) {
        $request->validated();
        
        try {
            $a = MCQModelData::findOrFail($request->id_mcqdata);
            $a->delete();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => "error",
                'message' => "Les données n'existent pas."
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success'
        ), 200);
    }
}
