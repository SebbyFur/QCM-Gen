<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\QuestionsTags;
use App\Models\Answer;

class QATSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::factory()->count(250)->create();

        foreach ($questions as $question) {
            Answer::factory()->count(10)->create(['id_question' => $question->id]);
            $duplicates = QuestionsTags::factory()->count(3)->create(['id_question' => $question->id]);

            //Hackfix pour supprimer les duplicatas... Ce n'est certainement pas la meilleure solution, mais j'en ai marre
            foreach($duplicates as $qt) {
                $verif = QuestionsTags::where(['id_question' => $qt->id_question, 'id_tag' => $qt->id_tag]);
                if ($verif->count() == 2)
                    $verif->first()->delete();
            }
        }
    }
}