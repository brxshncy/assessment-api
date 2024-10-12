<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->word,
            'exam_id' => Exam::factory()
                ->create()
                ->id,
            'question_type' => Arr::random(QuestionType::cases())->value
        ];
    }
}
