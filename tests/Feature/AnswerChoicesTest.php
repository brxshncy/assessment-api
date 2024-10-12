<?php

namespace Tests\Feature;

use App\Enums\QuestionType;
use App\Helpers\QuestionHelper;
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
    private $answerChoices;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdminUser();
        $this->question_type = Arr::random(QuestionType::cases())->value;
        $this->questionMultipleChoice = $this->createQuestion([
            'question' => $this->faker->word(),
            'exam_id' => Exam::factory()->create()->id,
            'question_type' => QuestionType::MULTIPLE_CHOICE->value
        ]);
        $this->question = $this->createQuestion();
        $this->answerChoices = $this->createAnswerChoices();
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
        $result = QuestionHelper::getChoicesAndAnswer($this->question);
        $choices = $result['choices'];
        $correct_answer = $result['correct_answer'];
        $payload = [
            'question_id' => $this->question->id,
            'option_text' => count($choices) > 0 ? $choices : null,
            'correct_answer' => $correct_answer
        ];
        dump($this->question);
        dump($payload);

        $response = $this->postJson(route('admin.answer-choices.store'), $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['option_text', 'correct_answer']]);
    }

    // public function test_admin_can_update_choices_for_multiple_choices_type_of_question(): void
    // {
    //     $this->withoutExceptionHandling();
    //     Sanctum::actingAs(
    //         $this->admin,
    //         ['*']
    //     );
    //     $payload = [
    //         'question_id' => $this->questionMultipleChoice->id,
    //         'option_text' => ['update choice a', 'updated choice b'],
    //         'correct_answer' => 'updated_answer'
    //     ];

    //     $response = $this->putJson(route('admin.answer-choices.update', $this->answerChoices->id), $payload);
    //     // dump($this->questionMultipleChoice->getAttributes());
    //     // dump($this->answerChoices->getAttributes());
    //     dump($response->getContent());
    //     $response->assertStatus(200)
    //         ->assertJsonFragment([
    //             'option_text' => ['update choice a', 'updated choice b'],
    //             'correct_answer' => 'updated_answer'
    //         ]);
    // }
}
