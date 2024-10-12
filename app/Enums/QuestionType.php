<?php

namespace App\Enums;

enum QuestionType: string
{
    case MULTIPLE_CHOICE = 'multiple_choice';
    case TRUE_OR_FALSE = 'true_or_false';
    case FILL_IN_THE_BLANK = 'fill_in_the_blank';
    case ESSAY = 'essay';
}
