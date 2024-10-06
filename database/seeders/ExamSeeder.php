<?php

namespace Database\Seeders;

use Database\Factories\ExamFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamFactory::factory()
                    ->count(10)
                    ->create();
    }
}
