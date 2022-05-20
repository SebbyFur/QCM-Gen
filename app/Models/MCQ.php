<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQ extends Model
{
    use HasFactory;

    protected $table = 'mcq';

    protected $hidden = ['updated_at', 'created_at'];

    protected $fillable = [
        'title'
    ];
}
