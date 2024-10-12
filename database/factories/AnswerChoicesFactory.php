<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Helpers\QuestionHelper;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnswerChoices>
 */
class AnswerChoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private $question;


    public function definition(): array
    {
        $question = Question::factory()->create();
        $result = QuestionHelper::getChoicesAndAnswer($question);
        $choices = $result['choices'];
        $correct_answer = $result['correct_answer'];

        return [
            'question_id' => $question->id,
            'option_text' => count($choices) > 0 ? $choices : null,
            'correct_answer' => $correct_answer
        ];
    }
}
