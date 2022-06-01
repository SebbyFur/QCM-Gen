<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Correction;
use App\Models\Answer;

class MCQ extends Model
{
    use HasFactory;

    protected $table = 'mcq';

    protected $hidden = ['updated_at', 'created_at'];

    protected $fillable = [
        'id_student',
        'id_model',
        'id_exam',
        'id_tag'
    ];

    public function getTitle() {
        $student = Student::find($this->id_student);
        $first_name = $student->first_name;
        $last_name = $student->last_name;

        if ($this->id_tag == NULL && $this->id_model == NULL) {
            return '(Non classé) '.$first_name.' '.$last_name;
        } else if ($this->id_model == NULL) {
            $tag = Tags::find($this->id_tag)->tag;
            return '('.$tag.') '.$first_name.' '.$last_name;
        } else {
            $modelTitle = MCQModel::find($this->id_model)->title;
            return '('.$modelTitle.') '.$first_name.' '.$last_name;
        }
    }

    public function getMark() {
        $mcqdata = Answer::join('mcq_data', 'answers.id', '=', 'mcq_data.id_answer')
        ->where(['mcq_data.id_mcq' => $this->id])
        ->get();
        $max = Answer::join('mcq_data', 'answers.id', '=', 'mcq_data.id_answer')
        ->where(['mcq_data.id_mcq' => $this->id, 'answers.is_correct' => true])
        ->get()
        ->count();

        $mark = 0;

        foreach ($mcqdata as $data) {
            $correction = Correction::where(['id_mcq_data' => $data->id])->first();
            $answer = Answer::find($data->id_answer);
            if ($correction != NULL)
                $answer->is_correct ? $mark++ : $mark--;
        }

        $mark = $mark < 0 ? 0 : $mark;

        return round($mark / $max * 100, 2);
    }
}
