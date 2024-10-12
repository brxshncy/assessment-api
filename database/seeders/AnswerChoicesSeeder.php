<?php

namespace Database\Seeders;

use Database\Factories\AnswerChoicesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerChoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        AnswerChoicesFactory::factory()->create();
    }
}
