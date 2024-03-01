<?php

namespace Database\Seeders;

use App\Models\Skills;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skills::create(['skill' => 'Java']);
        Skills::create(['skill' => 'PHP']);
        Skills::create(['skill' => 'Angular']);
        Skills::create(['skill' => 'React Js']);
        Skills::create(['skill' => 'AWS']);
    }
}
