<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQModelData extends Model
{
    use HasFactory;

    protected $table = 'mcq_model_data';

    protected $hidden = ['updated_at', 'created_at'];

    protected $fillable = [
        'id_model',
        'id_question'
    ];
}
