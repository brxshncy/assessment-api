<?php

namespace Tests;

use App\Models\AnswerChoices;
use App\Models\Exam;
use App\Models\Question;
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
        $this->createApplicantRole();
    }

    public function createAdminRole(): ContractsRole
    {
        return Role::firstOrCreate(['guard_name' => 'api', 'name' => 'admin']);
    }

    public function createApplicantRole(): ContractsRole
    {
        return Role::firstOrCreate(['guard_name' => 'api', 'name' => 'applicant']);
    }

    public function createAdminUser(array $attributes = []): User
    {
        return User::factory()
            ->create($attributes)
            ->assignRole(
                Role::where('name', 'admin')->first()
            );
    }
    public function createApplicantUser(array $attributes = []): User
    {
        return User::factory()
            ->create($attributes)
            ->assignRole(
                Role::where('name', 'applicant')->first()
            );
    }

    public function createExam(array $attributes = []): Exam
    {
        return Exam::factory()->create($attributes);
    }

    public function createQuestion(array $attributes = []): Question
    {
        return Question::factory()->create($attributes);
    }

    public function createAnswerChoices(array $attributes = []): AnswerChoices
    {
        return AnswerChoices::factory()->create($attributes);
    }
}
