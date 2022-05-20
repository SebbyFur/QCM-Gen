<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\MCQModelData;
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

    public function readAllView() {
        return view('qat.menu', ['ret' => Question::paginate(15)]);
    }

    public function readAll() {
        return Question::paginate(15);
    }

    public function readOuterJoin(Request $request) {
        return MCQModelData::rightJoin('questions', function($join) use (&$request) {
            $join->on('questions.id', '=', 'mcq_model_data.id_question');
            $join->where('mcq_model_data.id_model', $request->id);
        })
        ->where(['id_question' => NULL])
        ->paginate(15);
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

    public function fuzzysearch(Request $request) {
        if ($request->content == '')
            return Question::all()->take(15);

        return Question::whereFuzzy('question', $request->content)
        ->get()
        ->makeHidden(['fuzzy_relevance_question', '_fuzzy_relevance_'])
        ->take(15)
        ->toJson(JSON_PRETTY_PRINT);
    }
}
