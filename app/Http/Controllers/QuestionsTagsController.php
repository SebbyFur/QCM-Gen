<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsTags;
use App\Models\Tags;
use App\Http\Requests\CreateQuestionsTagsRequest;
use App\Http\Requests\DeleteQuestionsTagsRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class QuestionsTagsController extends Controller
{
    public function create(CreateQuestionsTagsRequest $request) {
        $request->validated();

        try {
            $a = QuestionsTags::firstOrNew(['id_tag' => $request->id_tag, 'id_question' => $request->id_question]);
            $a->save();
        } catch (QueryException $err) {
            return 'false';
        }
        
        return 'true';
    }

    public function delete(DeleteQuestionsTagsRequest $request) {
        $request->validated();

        try {
            $a = QuestionsTags::where(['id_tag' => $request->id_tag, 'id_question' => $request->id_question])->firstOrFail();
            $a->delete();
        } catch (ModelNotFoundException $err) {
            return 'false';
        }

        return 'true';
    }

    public function countTagQuestions(Request $request) {
        try {
            Tags::findOrFail($request->id);
            $count = QuestionsTags::where('id_tag', $request->id)
            ->count();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Ce modèle n'existe pas"
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
            'questions' => $count
        ), 200);
    }
}
