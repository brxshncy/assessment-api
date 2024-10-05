<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    private $admin;

    protected function setUp(): void 
    {
        parent::setUp();
        $this->admin = $this->createAdminUser();
    }
    public function test_admin_can_create_a_question(): void
    {
        $this->withoutExceptionHandling();
        $payload = [
            'question' => 'Test Question'
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

}
