<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrganizationSeeder::class,
            RoleSeeder::class,
            SubjectSeeder::class,
        ]);

        User::factory()->create([
            'role_id' => Role::ADMIN,
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
    }
}
