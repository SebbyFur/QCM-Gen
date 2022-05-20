<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQModel;
use App\Models\Student;
use App\Models\Group;
use App\Models\Tags;

class MCQController extends Controller
{
    public function createView() {
        $models = MCQModel::all();

        foreach ($models as &$model)
            $model->is_generator = $model->isGenerator();

        $tags = Tags::all();
        
        $groups = Group::all();

        $data = [
            'models' => $models,
            'tags' => $tags,
            'groups' => $groups
        ];

        return view('mcq.create', ['data' => $data]);
    }

    public function menuView() {
        return view('mcq.menu');
    }
}
