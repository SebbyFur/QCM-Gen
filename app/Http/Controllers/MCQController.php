<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQModel;
use App\Models\MCQModelData;
use App\Models\MCQ;
use App\Models\MCQData;
use App\Models\Student;
use App\Models\Group;
use App\Models\Tags;
use App\Models\QuestionsTags;
use App\Models\Question;
use App\Models\Answer;
use App\Http\Requests\CreateMCQRequest;
use App\Http\Requests\DeleteMCQRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;

class MCQController extends Controller
{
    public function create(CreateMCQRequest $request) {
        $request->validated();

        try {
            switch (true) {
                case isset($request->id_model):
                    $model = MCQModel::findOrFail($request->id_model);
                    $this->createMCQsFromModel($model, $request->student_ids, $request->questions_count);
                    break;
                case isset($request->id_tag):
                    $tag = Tags::findOrFail($request->id_tag);
                    $this->createMCQsFromTag($tag, $request->student_ids, $request->questions_count);
                    break;
                case isset($request->is_random):
                    $this->createMCQsRandomly($request->student_ids, $request->questions_count);
                    break;
                default:
                    return response()->json(
                    array(
                        'status' => 'error',
                        'message' => "La requête est incorrecte"
                    ), 500);
            }
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "La requête est incorrecte"
            ), 500);
        }

        return response()->json(
            array(
                'status' => 'success',
            ), 200);
    }

    public function delete(DeleteMCQRequest $request) {
        $request->validated();

        try {
            $mcq = MCQ::findOrFail($request->id);
            $mcqdata = MCQData::where('id_mcq', $mcq->id);

            $mcqdata->delete();
            $mcq->delete();
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Le QCM n'existe pas !"
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
        ), 200);
    }

    private function createMCQsFromModel($model, $studentIds, $maxQuestions) {
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);

            $mcq = MCQ::create(['id_student' => $student->id, 'id_model' => $model->id]);
            $mcq->save();

            $questions = MCQModelData::join('questions', 'questions.id', '=', 'mcq_model_data.id_question')
            ->where('mcq_model_data.id_model', $model->id)
            ->get()
            ->random($maxQuestions);

            foreach ($questions as $question) {
                $answers = Answer::where(['id_question' => $question->id, 'is_correct' => true])->get();
                $fakeAnswers = Answer::where(['id_question' => $question->id, 'is_correct' => false])
                ->get()
                ->random($question->answer_count - $answers->count());

                $answers = ($answers->merge($fakeAnswers))->shuffle();

                $count = 1;
                foreach ($answers as $answer) {
                    MCQData::create([
                        'id_mcq' => $mcq->id,
                        'id_question' => $question->id,
                        'id_answer' => $answer->id,
                        'choice' => $count++
                    ])->save();
                }
            }
        }
    }

    private function createMCQsFromTag($tag, $studentIds, $maxQuestions) {
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);

            $mcq = MCQ::create(['id_student' => $student->id, 'id_tag' => $tag->id]);
            $mcq->save();

            $questions = QuestionsTags::join('questions', 'questions.id', '=', 'questions_tags.id_question')
            ->where('questions_tags.id_tag', $tag->id)
            ->get()
            ->random($maxQuestions);

            foreach ($questions as $question) {
                $answers = Answer::where(['id_question' => $question->id, 'is_correct' => true])->get();
                $fakeAnswers = Answer::where(['id_question' => $question->id, 'is_correct' => false])
                ->get()
                ->random($question->answer_count - $answers->count());

                $answers = ($answers->merge($fakeAnswers))->shuffle();

                $count = 1;
                foreach ($answers as $answer) {
                    MCQData::create([
                        'id_mcq' => $mcq->id,
                        'id_question' => $question->id,
                        'id_answer' => $answer->id,
                        'choice' => $count++
                    ])->save();
                }
            }
        }
    }

    private function createMCQsRandomly($studentIds, $maxQuestions) {
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);

            $mcq = MCQ::create(['id_student' => $student->id]);
            $mcq->save();

            $questions = Question::inRandomOrder()->limit($maxQuestions)->get();

            foreach ($questions as $question) {
                $answers = Answer::where(['id_question' => $question->id, 'is_correct' => true])->get();
                $fakeAnswers = Answer::where(['id_question' => $question->id, 'is_correct' => false])
                ->get()
                ->random($question->answer_count - $answers->count());

                $answers = ($answers->merge($fakeAnswers))->shuffle();

                $count = 1;
                foreach ($answers as $answer) {
                    MCQData::create([
                        'id_mcq' => $mcq->id,
                        'id_question' => $question->id,
                        'id_answer' => $answer->id,
                        'choice' => $count++
                    ])->save();
                }
            }
        }
    }

    public function deleteAll() {
        DB::table('mcq_data')->delete();
        DB::table('mcq')->delete();
    }

    public function createView() {
        $models = MCQModel::all();

        foreach ($models as &$model){
            $model->is_generator = $model->isGenerator();
            $model->question_count = $model->getValidQuestionsCount();
        }

        $tags = Tags::all();

        foreach ($tags as &$tag)
            $tag->question_count = $tag->getValidQuestionsCount();
        
        $groups = Group::all();

        foreach ($groups as &$group)
            $group->students = $group->getStudents();

        $other = new Group([
            'name_group' => 'Autre'
        ]);
        $other->id = -1;
        $other->students = Student::where('group_id', NULL)->get();

        $groups->push($other);

        $data = [
            'models' => $models,
            'tags' => $tags,
            'groups' => $groups,
            'question_count' => Question::where('is_valid', true)->count()
        ];

        return view('mcq.create', ['data' => $data]);
    }

    public function menuView() {
        $mcqmodel = MCQ::whereNotNull('id_model')->get();
        $mcqtag = MCQ::whereNotNull('id_tag')->get();
        $mcqunclassed = MCQ::whereNull(['id_model', 'id_tag'])->get();

        foreach ($mcqmodel as &$mcq)
            $mcq->title = $mcq->getTitle();

        foreach ($mcqtag as &$mcq)
            $mcq->title = $mcq->getTitle();

        foreach ($mcqunclassed as &$mcq)
            $mcq->title = $mcq->getTitle();

        $data = [
            'mcqmodel' => $mcqmodel,
            'mcqtag' => $mcqtag,
            'mcqunclassed' => $mcqunclassed
        ];

        return view('mcq.menu', ['data' => $data]);
    }

    public function watchView(Request $request) {
        $id = $request->id;

        return view('mcq.watch', $this->getWatchData($id));
    }

    public function getWatchData($id) {

        $title = MCQ::findOrFail($id)->getTitle();
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
        }

        return ['data' => [
            'id' => $id,
            'title' => $title,
            'questions' => $questions
        ]];
    }

    public function getPdf(Request $request) {
        $id = $request->id;

        $pdf = PDF::loadView('mcq.pdf', $this->getWatchData($id));
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('watch.pdf');
    }
}
