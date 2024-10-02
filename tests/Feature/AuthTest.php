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
    private $admin;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->payload = [
            'name' => $this->faker->name, 
            'email' => $this->faker->email, 
            'password' => 'random',
        ];
        $this->admin = $this->createAdminUser();

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

    public function test_applicant_role_can_register()
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

    public function test_admin_can_login()
    {
        $this->withoutExceptionHandling();
        $payload = [
            'email' => $this->admin->email, 
            'password' => 'password'
        ];
        $response = $this->postJson(route('auth.sign-in'), $payload);
        dump($response->json());
        $response->assertStatus(200)
                ->assertJsonStructure([
                   'data' => ['user', 'accessToken', 'role']
                ])
                ->assertJsonPath('data.role.0', 'admin');
    }
}
