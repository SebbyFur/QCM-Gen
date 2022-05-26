<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionsTags;

class Tags extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'tag'
    ];

    public function getValidQuestionsCount() {
        return QuestionsTags::join('questions', 'questions.id', '=', 'questions_tags.id_question')
        ->where(['id_tag' => $this->id, 'is_valid' => true])
        ->count();
    }
}
