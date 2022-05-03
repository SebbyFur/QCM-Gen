<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsTags;
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
}
