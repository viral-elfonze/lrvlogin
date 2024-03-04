<?php

namespace Database\Seeders;

use App\Models\EmployeeDetails as ModelsEmployeeDetails;
use Illuminate\Database\Seeder;

class EmployeeDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsEmployeeDetails::create(['employee_code' => 'ET1208', 'employee_firstname'  => 'Dixita', 'employee_middlename'  => 'Bhupendrabhai', 'employee_lastname'  => 'Pande', 'resumelink' => '', 'employement_type' => 'Full Stack Developer', 'startdate' => '2023-02-28', 'enddate' => null, 'location' => 'Ahmedabad', 'totalexp' => '6', 'relevantexp' => '3', 'employee_image' => 1, 'isactive' => 1]);
    }
}
