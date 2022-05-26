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
        'id_student',
        'id_model',
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
}
