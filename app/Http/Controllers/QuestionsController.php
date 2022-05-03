<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Requests\FuzzySearchQuestionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionsController extends Controller
{
    public function create(CreateQuestionRequest $request) {
        $request->validated();
        
        $a = Question::create(['question' => $request['question']]);
        $a->save();
        
        return ['true', $a->id];
    }

    public function update(UpdateQuestionRequest $request) {
        $request->validated();

        try {
            if (preg_replace("/\s+/", "", $request->question) == "")
                throw new InvalidArgumentException("O");

            $a = Question::where('id', $request->id)->firstOrFail();
            $a->update(['question' => $request->question]);
        } catch (ModelNotFoundException $err) {
            return 'false';
        } catch (InvalidArgumentException $err) {
            return 'false';
        }
        
        return 'true';
    }

    public function fuzzysearch(FuzzySearchQuestionRequest $request) {
        $request->validated();

        return Question::whereFuzzy('question', $request->field)
        ->get()
        ->makeHidden(['created_at', 'updated_at', 'fuzzy_relevance_question'])
        ->toJson(JSON_PRETTY_PRINT);
    }
}
