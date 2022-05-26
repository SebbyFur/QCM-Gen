<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQData extends Model
{
    use HasFactory;

    protected $table = 'mcq_data';

    protected $fillable = [
        'id_question',
        'id_answer',
        'id_mcq',
        'choice'
    ];
}
