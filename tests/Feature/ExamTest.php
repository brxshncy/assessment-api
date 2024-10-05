<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdminUser();
    }


    public function test_admin_can_create_exam () : void 
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(
            $this->admin
        );

        $payload = [
            'title' => $this->faker->title,
            'type' => 'behavioral',
        ];

        $response = $this->postJson(route('admin.exams.store'), $payload);
        $response->assertStatus(203)
                 ->assertJsonStructure([
                    'data' =>  ['title,', 'type', 'questions']
                 ]);
    }
}
