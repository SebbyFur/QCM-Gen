<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GetQATRequest;
use App\Http\Requests\DeleteQATRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Question;
use App\Models\Tags;
use App\Models\Answer;
use App\Models\QuestionsTags;
use App\Http\Controller\QuestionsController;
use App\Http\Controller\AnswersController;
use App\Http\Controller\QuestionsTagsController;
use App\Http\Controller\QuestionsAnswersController;

class QATController extends Controller
{
    public function read(Request $request) {
        $ret = [
            'question' => Question::findOrFail($request->id)->get()
                            ->makeHidden(['created_at', 'updated_at']),
            'answers'  => Answer::where('id_question', $request->id)->get()
                            ->makeHidden(['created_at', 'updated_at', 'id_question', 'id_answer']),
            'tags'     => Tags::join('questions_tags', function($join) {
                            $join->on('tags.id', '=', 'questions_tags.id_tag');
                            })->where('questions_tags.id_question', $request->id)->get()
                            ->makeHidden(['id', 'created_at', 'updated_at', 'id_question']),
        ];

        return view('qat.edit', ['ret' => $ret]);
    }

    public function delete(DeleteQATRequest $request) {
        $request->validated();

        try {
            $q = Question::findOrFail($request->id);
            Answer::where(['id_question' => $request->id])->delete();
            QuestionsTags::where(['id_question' => $request->id])->delete();
            $q->delete();
        } catch (ModelNotFoundException $err) {
            return 'false';
        }

        return 'true';
    }
}
