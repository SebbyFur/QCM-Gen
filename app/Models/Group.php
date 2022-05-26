<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_group'
    ];

    public function getStudents() {
        return Student::where(['group_id' => $this->id])->get();
    }
}
