<?php

namespace Database\Seeders;

use App\Models\Locations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Locations::create(['city' => 'Ahmedabad']);
        Locations::create(['city' => 'Anand']);
        Locations::create(['city' => 'Bangalore']);
        Locations::create(['city' => 'Surat']);
        Locations::create(['city' => 'Rajkot']);
    }
}
