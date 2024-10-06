<?php

namespace Tests\Feature;

use App\Enums\ExamType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;
    private $exam_types = [];
    private $exam;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdminUser();
        $this->exam_types = ExamType::cases();
        $this->exam = $this->createExam();
    }

    public function test_admin_can_view_all_exams(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin
        );
        $response = $this->getJson(route('admin.exams.index'));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' =>  ['*' => ['title', 'type', 'questions']]
            ]);
    }

    public function test_admin_can_view_details_of_exam(): void
    {

        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin
        );
        $response = $this->getJson(route('admin.exams.show', $this->exam->id));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['title', 'type', 'questions']
            ]);
    }

    public function test_admin_can_create_exam(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin
        );

        $payload = [
            'title' => $this->faker->title,
            'type' => Arr::random($this->exam_types)->value
        ];

        $response = $this->postJson(route('admin.exams.store'), $payload);
        $response->assertStatus(status: 201)
            ->assertJsonStructure([
                'data' =>  ['title', 'type']
            ]);
    }

    public function test_admin_can_update_exam(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin
        );

        $payload = [
            'title' => $this->faker->words(2, true),
            'type' => Arr::random($this->exam_types)->value
        ];

        $response = $this->putJson(route('admin.exams.update', $this->exam), $payload);
        $response->assertStatus(203)
            ->assertJsonStructure([
                'data' => ['title', 'type'],
            ])
            ->assertJsonFragment([
                'updated' => true
            ]);;
    }

    public function test_admin_can_delete_exam(): void
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin
        );
        $response = $this->deleteJson(route('admin.exams.destroy', $this->exam));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Exam deleted'
            ]);
    }
}
