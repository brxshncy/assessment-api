<?php

namespace App\Http\Controllers;

use App\Enums\QuestionType;
use App\Http\Requests\AnswerChoicesRequest;
use App\Models\AnswerChoices;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerChoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnswerChoicesRequest $request)
    {
        $question = Question::findOrFail($request->question_id);

        if ($question->question_type == QuestionType::MULTIPLE_CHOICE->value) {
            $request->merge(['option_text' => json_encode($request->option_text)]);
        }
        return response()->success(AnswerChoices::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnswerChoicesRequest $request, AnswerChoices $answerChoices)
    {
        $question = Question::findOrFail($request->question_id);

        if ($question->question_type == QuestionType::MULTIPLE_CHOICE->value) {
            $request->merge(['option_text' => json_encode($request->option_text)]);
        }
        tap($answerChoices)->update($request->all());
        return response()->success($answerChoices);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
