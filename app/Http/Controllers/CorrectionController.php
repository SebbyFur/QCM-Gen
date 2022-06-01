<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correction;
use App\Models\MCQ;
use App\Models\MCQData;
use App\Models\Question;
use App\Http\Requests\CreateCorrectionRequest;
use App\Http\Requests\DeleteCorrectionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CorrectionController extends Controller
{
    public function create(CreateCorrectionRequest $request) {
        $request->validated();
        
        try {
            $a = Correction::create(['id_mcq_data' => $request->id_mcq_data]);
            $a->save();
        } catch (QueryException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Ce champ de correction existe déjà."
            ), 500);
        }

        $mark = MCQ::find(MCQData::find($request->id_mcq_data)->id_mcq)->getMark();

        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id,
            'mark' => $mark
        ), 200);
    }

    public function delete(DeleteCorrectionRequest $request) {
        $request->validated();

        try {
            $answer = Correction::where(['id_mcq_data' => $request->id_mcq_data])->firstOrFail();
            $answer->delete();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Aucun champ portant cet id !"
            ), 500);
        }

        $mark = MCQ::find(MCQData::find($request->id_mcq_data)->id_mcq)->getMark();

        return response()->json(
        array(
            'status' => 'success',
            'mark' => $mark
        ), 200);
    }

    public function watchView(Request $request) {
        $id = $request->id;

        $mcq = MCQ::findOrFail($id);
        $title = $mcq->getTitle();
        $questions = MCQData::join('questions', 'questions.id', '=', 'mcq_data.id_question')
        ->where('id_mcq', $id)
        ->select('questions.id')
        ->groupBy('id')
        ->get();

        foreach ($questions as &$question) {
            $question->question = Question::findOrFail($question->id)->question;
            $question->answers = MCQData::join('answers', 'answers.id', '=', 'mcq_data.id_answer')
            ->where(['mcq_data.id_mcq' => $id, 'mcq_data.id_question' => $question->id])
            ->get();

            foreach ($question->answers as &$answer) {
                $id_mcq_data = MCQData::where(['id_mcq' => $answer->id_mcq, 'id_answer' => $answer->id_answer, 'id_question' => $answer->id_question])->first()->id;
                $answer->checked = Correction::where(['id_mcq_data' => $id_mcq_data])->first() != NULL ? true : false;
                $answer->id_mcq_data = $id_mcq_data;
            }
        }

        $data = [
            'id' => $id,
            'title' => $title,
            'questions' => $questions,
            'mark' => $mcq->getMark()
        ];

        return view('correction.watch', ['data' => $data]);
    }
}
