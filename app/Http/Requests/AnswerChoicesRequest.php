<?php

namespace App\Http\Requests;

use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Contracts\Service\Attribute\Required;

class AnswerChoicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $questionType = Question::find($this->question_id)?->question_type;

        return [
            'question_id' => 'required|exists:questions,id',
            'correct_answer' =>  [
                Rule::requiredIf(function () use ($questionType) {
                    return $questionType !== QuestionType::ESSAY->value;
                }),
                'string'
            ],
            'option_text' => [
                Rule::requiredIf(function () use ($questionType) {
                    return $questionType === QuestionType::MULTIPLE_CHOICE->value;
                }),
                'array',
                'nullable'
            ]
        ];
    }
}
