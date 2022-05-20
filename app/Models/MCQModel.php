<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\MCQModelData;

class MCQModel extends Model
{
    use HasFactory;

    protected $table = 'mcq_model';

    protected $fillable = [
        'title',
    ];

    public function isGenerator() : bool {
        $data = MCQModelData::where('id_model', $this->id)->pluck('id_question');
        if (count($data) == 0) return false;

        foreach ($data as $id)
            if (!Question::find($id)->isValid()) return false;

        return true;
    }
}