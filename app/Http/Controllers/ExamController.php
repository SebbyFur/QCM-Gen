<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateExamRequest;
use App\Http\Requests\DeleteExamRequest;
use App\Models\Exam;
use App\Models\MCQ;
use App\Models\MCQData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ExamController extends Controller
{
    public function create(CreateExamRequest $request) {
        $request->validated();
        
        try {
            $a = Exam::create(['title' => $request->title]);
            $a->save();
        } catch (QueryException $err) {
            $id = Exam::where(['title' => $request->title])->first()->id;

            return response()->json(
            array(
                'status' => 'error',
                'id' => $id,
                'message' => "Un examen avec cet intitulé existe déjà. #$id"
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
            'id' => $a->id,
        ), 200);
    }

    public function delete(DeleteExamRequest $request) {
        $request->validated();

        try {
            $e = Exam::findOrFail($request->id);

            $mcqs = MCQ::where('id_exam', $e->id)->get();
            if (isset($request->remove_mcq)) {
                foreach ($mcqs as $mcq) {
                    MCQData::where('id_mcq', $mcq->id)->delete();
                    $mcq->delete();
                }
            } else {
                foreach ($mcqs as $mcq) {
                    $mcq->update(['id_exam' => NULL]);
                }
            }

            $e->delete();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Cet examen n'existe pas"
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success'
        ), 200);
    }

    public function menuView() {
        return view('exam.menu', ['data' => Exam::all()]);
    }

    public function examView(Request $request) {
        $mcqs = MCQ::where('id_exam', $request->id)->get();

        foreach ($mcqs as $mcq)
            $mcq->title = $mcq->getTitle();

        return view('exam.watch', [
            'id' => $request->id,
            'data' => $mcqs
        ]);
    }
}
