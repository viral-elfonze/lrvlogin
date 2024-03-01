<?php

namespace Database\Seeders;

use App\Models\EmployeeSkillMatrix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSkillMatrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeSkillMatrix::create(['skill_id' => '1', 'employee_id' => '1', 'relevantexp' => '4', 'competency' => '2']);
        EmployeeSkillMatrix::create(['skill_id' => '2', 'employee_id' => '1', 'relevantexp' => '2', 'competency' => '3']);
        EmployeeSkillMatrix::create(['skill_id' => '3', 'employee_id' => '1', 'relevantexp' => '1', 'competency' => '1']);
        EmployeeSkillMatrix::create(['skill_id' => '4', 'employee_id' => '1', 'relevantexp' => '1', 'competency' => '2']);
    }
}
