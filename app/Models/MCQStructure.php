<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQStructure extends Model
{
    use HasFactory;

    protected $table = 'mcqstructure';

    protected $fillable = [
        'id_answer',
        'id_question',
        'id_mcq',
        'choice',
    ];
}
