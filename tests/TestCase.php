<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAdminRole();
        $this->createApplicant();
    }

    public function createAdminRole (): ContractsRole
    {
       return Role::create(['guard_name' => 'api', 'name' => 'admin']);
    }

    public function createApplicant (): ContractsRole
    {
       return Role::create(['guard_name' => 'api', 'name' => 'applicant']);
    }
    
    public function createAdminUser (Array $attributes = []): User 
    {
        return User::factory()
                    ->create($attributes)
                    ->assignRole(Role::where('name', 'admin')->first());
    }
}
