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
use App\Models\Correction;
use App\Models\Exam;
use App\Http\Requests\CreateMCQRequest;
use App\Http\Requests\UpdateMCQRequest;
use App\Http\Requests\DeleteMCQRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;

class MCQController extends Controller
{
    public static $maxQuestionsCount = 120;

    public function create(CreateMCQRequest $request) {
        $request->validated();

        $request->questions_count = $request->questions_count > self::$maxQuestionsCount ? self::$maxQuestionsCount : $request->questions_count;

        try {
            switch (true) {
                case isset($request->id_model):
                    $model = MCQModel::findOrFail($request->id_model);
                    if (!isset($request->id_exam) || $request->id_exam == "NONE") $request->id_exam = NULL;
                    $this->createMCQsFromModel($model, $request->student_ids, $request->questions_count, $request->id_exam);
                    break;
                case isset($request->id_tag):
                    $tag = Tags::findOrFail($request->id_tag);
                    if (!isset($request->id_exam) || $request->id_exam == "NONE") $request->id_exam = NULL;
                    $this->createMCQsFromTag($tag, $request->student_ids, $request->questions_count, $request->id_exam);
                    break;
                case isset($request->is_random):
                    if (!isset($request->id_exam) || $request->id_exam == "NONE") $request->id_exam = NULL;
                    $this->createMCQsRandomly($request->student_ids, $request->questions_count, $request->id_exam);
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

            foreach ($mcqdata->get() as $data) {
                $correction = Correction::where(['id_mcq_data' => $data->id])->first();
                if ($correction != NULL) $correction->delete();
            }

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

    private function createMCQsFromModel($model, $studentIds, $maxQuestions, $idExam) {
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);

            $mcq = MCQ::create(['id_student' => $student->id, 'id_model' => $model->id, 'id_exam' => $idExam]);
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

    private function createMCQsFromTag($tag, $studentIds, $maxQuestions, $idExam) {
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);

            $mcq = MCQ::create(['id_student' => $student->id, 'id_tag' => $tag->id, 'id_exam' => $idExam]);
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

    private function createMCQsRandomly($studentIds, $maxQuestions, $idExam) {
        foreach ($studentIds as $studentId) {
            $student = Student::findOrFail($studentId);

            $mcq = MCQ::create(['id_student' => $student->id, 'id_exam' => $idExam]);
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
        DB::table('correction')->delete();
        DB::table('mcq_data')->delete();
        DB::table('mcq')->delete();
    }

    public function update(UpdateMCQRequest $request) {
        $request->validated();

        try {
            $mcq = MCQ::findOrFail($request->id_mcq);
            
            if ($request->id_exam == 'NONE') {
                $request->id_exam = NULL;
            } else {
                Exam::findOrFail($request->id_exam);
            }

            $mcq->update(['id_exam' => $request->id_exam]);
        } catch (ModelNotFoundException $err) {
            return response()->json(
            array(
                'status' => 'error',
                'message' => "Erreur dans la requête."
            ), 500);
        }

        return response()->json(
        array(
            'status' => 'success',
        ), 200);
    }

    public function createView() {
        $models = MCQModel::all();

        foreach ($models as &$model){
            $model->is_generator = $model->isGenerator();
            $model->question_count = $model->getValidQuestionsCount() > self::$maxQuestionsCount ? self::$maxQuestionsCount : $model->getValidQuestionsCount();
        }

        $tags = Tags::all();

        foreach ($tags as &$tag)
            $tag->question_count = $tag->getValidQuestionsCount() > self::$maxQuestionsCount ? self::$maxQuestionsCount : $tag->getValidQuestionsCount();
        
        $groups = Group::all();

        foreach ($groups as &$group)
            $group->students = $group->getStudents();

        $other = new Group([
            'name_group' => 'Autre'
        ]);
        $other->id = -1;
        $other->students = Student::where('group_id', NULL)->get();

        $groups->push($other);

        $questionsCount = Question::where('is_valid', true)->count();
        $questionsCount = $questionsCount > self::$maxQuestionsCount ? self::$maxQuestionsCount : $questionsCount;

        $data = [
            'models' => $models,
            'tags' => $tags,
            'groups' => $groups,
            'question_count' => $questionsCount,
            'exams' => Exam::all()
        ];

        return view('mcq.create', ['data' => $data]);
    }

    public function menuView() {
        $mcqmodel = MCQ::whereNotNull('id_model')->get();
        $mcqtag = MCQ::whereNotNull('id_tag')->get();
        $mcqunclassed = MCQ::whereNull(['id_model', 'id_tag'])->get();
        $exams = Exam::all();

        foreach ($mcqmodel as &$mcq)
            $mcq->title = $mcq->getTitle();

        foreach ($mcqtag as &$mcq)
            $mcq->title = $mcq->getTitle();

        foreach ($mcqunclassed as &$mcq)
            $mcq->title = $mcq->getTitle();

        $data = [
            'mcqmodel' => $mcqmodel,
            'mcqtag' => $mcqtag,
            'mcqunclassed' => $mcqunclassed,
            'exams' => $exams
        ];

        return view('mcq.menu', ['data' => $data]);
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

        return [
            'id' => $id,
            'title' => $title,
            'questions' => $questions
        ];
    }

    public function getPdf(Request $request) {
        $id = $request->id;
        $mcq = MCQ::find($id);
        $student = Student::find($mcq->id_student);

        $data = $this->getWatchData($id);
        $data['qr'] = base64_encode(QrCode::size(200)->generate($id));
        $data['first_name'] = $student->first_name;
        $data['last_name'] = $student->last_name;
        if ($mcq->id_exam == NULL) {
            $data['title'] = 'QCM';
        } else {
            $data['title'] = Exam::find($mcq->id_exam)->title;
        }

        $pdf = PDF::loadView('mcq.pdf', ['data' => $data]);
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download($data['title'].'_'.$data['first_name'].'_'.$data['last_name'].'.pdf');
    }
}
