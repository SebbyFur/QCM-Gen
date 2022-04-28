<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddQuestionRequest;
use App\Http\Requests\FuzzySearchQuestionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionsController extends Controller
{
    public function store(AddQuestionRequest $request) {
        $request->validated();
        
        $a = DB::table('questions')->where('question', $request['question'])->first();
        if ($a != null) return ['true', $a->id];

        $a = Question::create(['question' => $request['question']]);
        $a->save();
        
        return ['false', $a->id];
    }

    public function fuzzysearch(FuzzySearchQuestionRequest $request) {
        $request->validated();

        return Question::whereFuzzy('question', $request->field)
        ->get()
        ->makeHidden(['created_at', 'updated_at', 'fuzzy_relevance_question'])
        ->toJson(JSON_PRETTY_PRINT);
    }
}
