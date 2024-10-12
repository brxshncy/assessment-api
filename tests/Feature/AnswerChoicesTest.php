<?php

namespace Tests\Feature;

use App\Enums\QuestionType;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnswerChoicesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;
    private $question_type;
    private $questionMultipleChoice;
    private $question;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdminUser();
        $this->question_type = Arr::random(QuestionType::cases())->value;
        $this->questionMultipleChoice = $this->createQuestion([
            'question' => $this->faker->word(),
            'exam_id' => Exam::factory()->create()->id,
            'question_type' => QuestionType::MULTIPLE_CHOICE
        ]);
        $this->question = $this->createQuestion();
    }
    public function test_admin_can_create_multiple_choices_for_a_question(): void
    {
        $this->withoutExceptionHandling();

        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $choices = [];
        $correct_answer = "";


        $choices = ['test a', 'test b', 'test c', 'test d'];
        $correct_answer = Arr::random(['test a', 'test b', 'test c', 'test d']);

        $payload = [
            'question_id' => $this->questionMultipleChoice->id,
            'option_text' =>  $choices,
            'correct_answer' => $correct_answer
        ];

        $response = $this->postJson(route('admin.answer-choices.store'), $payload);
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['option_text', 'correct_answer']]);
    }

    public function test__all_question_types_can_create_answer_choices(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $choices = [];
        $correct_answer = '';

        if ($this->question->question_type === QuestionType::MULTIPLE_CHOICE->value) {
            $choices = ['test a', 'test b', 'test c', 'test d'];
            $correct_answer = Arr::random(['test a', 'test b', 'test c', 'test d']);
        } else if ($this->question->question_type === QuestionType::TRUE_OR_FALSE->value) {
            $correct_answer = Arr::random(['true', 'false']);
        } else if ($this->question->question_type === QuestionType::FILL_IN_THE_BLANK->value) {
            $correct_answer = 'random_text';
        }

        $payload = [
            'question_id' => $this->question->id,
            'option_text' => count($choices) > 0 ? $choices : null,
            'correct_answer' => $correct_answer
        ];


        $response = $this->postJson(route('admin.answer-choices.store'), $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['option_text', 'correct_answer']]);
    }
}
