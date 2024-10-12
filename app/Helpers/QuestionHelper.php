<?php

namespace App\Helpers;

use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Support\Arr;

class QuestionHelper
{
    public static function getChoicesAndAnswer(Question $question): array
    {
        $choices = [];
        $correct_answer = '';

        if ($question->question_type === QuestionType::MULTIPLE_CHOICE->value) {
            $choices = ['test a', 'test b', 'test c', 'test d'];
            $correct_answer = Arr::random(['test a', 'test b', 'test c', 'test d']);
        } else if ($question->question_type === QuestionType::TRUE_OR_FALSE->value) {
            $correct_answer = Arr::random(['true', 'false']);
        } else if ($question->question_type === QuestionType::FILL_IN_THE_BLANK->value) {
            $correct_answer = 'random_text';
        }

        return ['choices' => $choices, 'correct_answer' => $correct_answer];
    }
}
