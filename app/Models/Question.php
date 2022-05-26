<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $hidden = ['updated_at', 'created_at'];

    protected $fillable = [
        'question',
        'is_valid',
        'answer_count'
    ];

    public function isValid() : bool {
        $id = $this->id;

        $answers = Answer::where('id_question', $id)->get();

        $hasFalse = false;
        $hasTrue = false;
        
        foreach ($answers as $answer) {
            if ($answer->is_correct) {
                $hasTrue = true;                
            } else {
                $hasFalse = true;
            }

            if (empty($answer->answer)) return false;
        }

        return ($hasFalse && $hasTrue);
    }

    public function getMinPossibleAnswers() {
        return Answer::where(['id_question' => $this->id, 'is_correct' => true])->count() + 1;
    }
}
