<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MCQModel;
use App\Models\MCQModelData;
use App\Models\Question;

class MCQModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = MCQModel::factory()->count(15)->create();

        foreach ($models as $model) {
            $questions = Question::all();
            $selected = $questions->random(rand(5, 20));

            foreach ($selected as $question)
                MCQModelData::create(['id_model' => $model->id, 'id_question' => $question->id]);
        }
    }
}
