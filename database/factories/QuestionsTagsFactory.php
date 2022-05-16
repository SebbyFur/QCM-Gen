<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tags;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionsTags>
 */
class QuestionsTagsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tags = Tags::pluck('id')->toArray();

        return [
            'id_tag' => $tags[array_rand($tags)]
        ];
    }
}
