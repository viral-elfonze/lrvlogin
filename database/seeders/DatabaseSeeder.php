<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create([
            'password'=> "test"
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dixita',
            'email' => 'dixita.dm@elfonze.com',
            'password'=> "test"
        ]);

        $this->call([
            RolesSeeder::class,
            RoleUserSeeder::class,
            LocationsSeeder::class,
            SkillSeeder::class,
            EmployeeDetailsSeeder::class,
            EmployeeSkillMatrixSeeder::class
        ]);
    }
}
