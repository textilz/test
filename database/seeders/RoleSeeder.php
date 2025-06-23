<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'Ученик',
        ]);
        Role::factory()->create([
            'name' => 'Родитель',
        ]);
        Role::factory()->create([
            'name' => 'Преподаватель',
        ]);
        Role::factory()->create([
            'name' => 'Админ',
        ]);
    }
}
