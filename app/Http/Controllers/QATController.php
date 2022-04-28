<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GetQATRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Tags;
use App\Models\Answer;
use App\Models\QuestionsAnswers;
use App\Models\QuestionsTags;
use App\Http\Controller\QuestionsController;
use App\Http\Controller\AnswersController;
use App\Http\Controller\QuestionsTagsController;
use App\Http\Controller\QuestionsAnswersController;

class QATController extends Controller
{
    public function get(GetQATRequest $request) {
        $request->validated();

        return Answer::join('qanda', function($join) {
            $join->on('answers.id', '=', 'qanda.id_answer')
            ->where('id_question', $request->id);
            //Accéder à la variable depuis la fonction anonyme
        })->get();

        $ret = [
            'question' => Question::where('id', $request->id)->first()->question,
            'answers' => QuestionsAnswers::crossJoin(DB::table('qanda'))->get(),
            'tags' => QuestionsTags::where('id_question', $request->id)->get()
        ];

        return json_encode($ret);
    }
}
