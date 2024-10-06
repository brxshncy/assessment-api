<?php

namespace Tests\Feature;

use App\Models\Exam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    private $admin;
    private $question;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdminUser();
        $this->question = $this->createQuestion();
    }

    public function test_admin_can_view_questions_of_exam(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $response = $this->getJson(route('admin.question.index'));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['*' => ['question']]
            ]);
    }
    public function test_admin_can_create_a_question(): void
    {
        $this->withoutExceptionHandling();
        $payload = [
            'question' => 'Test Question',
            'exam_id' => Exam::inRandomOrder()->first() ? Exam::inRandomOrder()->first()->id : Exam::factory()->create()->id,
        ];
        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $response = $this->postJson(route('admin.question.store'), $payload);
        $response->assertStatus(203)
            ->assertJsonStructure([
                'data' => ['question']
            ]);
    }

    public function test_admin_view_sepcific_questions_of_exam(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $response = $this->getJson(route('admin.question.show', $this->question->id));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['question']
            ]);
    }

    public function test_admin_can_update_question_of_exam(): void
    {
        $this->withoutExceptionHandling();
        $payload = [
            'question' => 'Update Question',
            'exam_id' => Exam::inRandomOrder()->first() ? Exam::inRandomOrder()->first()->id : Exam::factory()->create()->id,
        ];
        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $response = $this->postJson(route('admin.question.store'), $payload);
        $response->assertStatus(203)
            ->assertJsonStructure([
                'data' => ['question']
            ]);
    }


    public function test_admin_delete_questions_of_exam(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
        $response = $this->deleteJson(route('admin.question.show', $this->question->id));
        dump($response->getContent());
        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Question deleted'
            ]);
    }
}
