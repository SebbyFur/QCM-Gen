<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsTags extends Model
{
    use HasFactory;

    protected $table = 'questions_tags';

    protected $fillable = [
        'question_id',
        'tag_id'
    ];
}
