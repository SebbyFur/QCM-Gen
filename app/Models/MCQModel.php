<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQModel extends Model
{
    use HasFactory;

    protected $table = 'mcq_model';

    protected $fillable = [
        'title',
    ];
}
