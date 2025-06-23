<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::factory()->create([
            'name' => 'Английский язык'
        ]);
        Subject::factory()->create([
            'name' => 'Баскетбол'
        ]);
        Subject::factory()->create([
            'name' => 'ОГЭ по математике'
        ]);
        Subject::factory()->create([
            'name' => 'ОГЭ по русскому'
        ]);
    }
}
