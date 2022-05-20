<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsAnswers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\AnswerList;
use App\Http\Requests\CreateAnswerRequest;
use App\Http\Requests\DeleteAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class AnswersController extends Controller
{
    public function create(CreateAnswerRequest $request) {
        $request->validated();

        try {
            $a = Answer::create(['id_question' => $request->id_question, 'answer' => $request->answer]);
            $a->save();

            $b = Question::find($request->id_question);
            $b->update(['is_valid' => $b->isValid()]);
        } catch (QueryException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => 'Erreur lors de la création de la réponse !',
            ), 500);
        }
        
        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id
        ), 200);
    }

    public function delete(DeleteAnswerRequest $request) {
        $request->validated();

        try {
            $answer = Answer::findOrFail($request->id_answer);
            $answer->delete();
        } catch (ModelNotFoundException $err) {
            return 'false';
        }

        return 'true';
    }

    public function update(UpdateAnswerRequest $request) {
        $request->validated();

        try {
            $answer = Answer::findOrFail($request->id_answer);
            $answer->update($request->all());

            if (!isset($answer->answer))
                $answer->update(['is_correct' => 0]);

            $b = Question::find($answer->id_question);
            $b->update(['is_valid' => $b->isValid()]);
        } catch (ModelNotFoundException $err) {
            return 'false';
        }

        return 'true';
    }
}
