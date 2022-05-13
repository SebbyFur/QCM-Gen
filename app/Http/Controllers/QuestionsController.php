<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Requests\FuzzySearchQuestionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class QuestionsController extends Controller
{
    public function create(CreateQuestionRequest $request) {
        $request->validated();
        
        try {
            $a = Question::create(['question' => $request['question']]);
            $a->save();
        } catch (QueryException $err) {
            return $err;
            $id = Question::where(['question' => $request['question']])->first()->id;

            return response()->json(
            array(
                'status' => 'error',
                'id' => $id,
                'message' => "Une question avec cet intitulé existe déjà. #$id"
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id,
        ), 200);
    }

    public function update(UpdateQuestionRequest $request) {
        $request->validated();

        try {
            $a = Question::where('id', $request->id)->firstOrFail();
            $a->update(['question' => $request->question]);
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Cette question n'existe pas."
            ), 500);
        } catch (QueryException $err) {
            $id = Question::where(['question' => $request['question']])->first()->id;

            return response()->json(
            array(
                'status' => 'error',
                'id' => $id,
                'message' => "Une question avec cet intitulé existe déjà. #$id"
            ), 500);
        }
        
        return response()->json(
        array(
            'status' => 'success',
        ), 200);
    }

    public function fuzzysearch(FuzzySearchQuestionRequest $request) {
        $request->validated();

        return Question::whereFuzzy('question', $request->field)
        ->get()
        ->makeHidden(['created_at', 'updated_at', 'fuzzy_relevance_question'])
        ->toJson(JSON_PRETTY_PRINT);
    }
}
