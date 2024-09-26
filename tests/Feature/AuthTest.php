<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $payload;
    protected function setUp(): void 
    {
        parent::setUp();
        $this->payload = [
            'name' => $this->faker->name, 
            'email' => $this->faker->email, 
            'password' => 'random',
        ];
    }

    public function test_admin_role_register()
    {
        $this->withoutExceptionHandling();
        $this->payload = array_merge($this->payload, ['role' => 'admin']);
        $response = $this->postJson(route('auth.sign-up'), $this->payload);
        $response->assertStatus(203)
                ->assertJsonStructure([
                    'data' => ['email', 'name', 'roles']
                ])
                ->assertJsonPath('data.roles.0.name', 'admin');
    }

    public function test_appplicant_role_can_register()
    {
        $this->withoutExceptionHandling();
        $this->payload = array_merge($this->payload, ['role' => 'applicant']);
        $response = $this->postJson(route('auth.sign-up'), $this->payload);
        $response->assertStatus(203)
                ->assertJsonStructure([
                    'data' => ['email', 'name', 'roles']
                ])
                ->assertJsonPath('data.roles.0.name', 'applicant');

    }

}
