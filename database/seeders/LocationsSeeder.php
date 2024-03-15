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
        Locations::truncate();

        Locations::create(['city' => 'Bangalore']);
        Locations::create(['city' => 'Bhubaneswar']);
        Locations::create(['city' => 'Pune']);

        // Locations::create(['city' => 'Ahmedabad']);
        // Locations::create(['city' => 'Mumbai']);
        // Locations::create(['city' => 'Delhi']);
        // Locations::create(['city' => 'Kolkata']);
        // Locations::create(['city' => 'Chennai']);
        // Locations::create(['city' => 'Hyderabad']);
        // Locations::create(['city' => 'Jaipur']);
        // Locations::create(['city' => 'Lucknow']);
        // Locations::create(['city' => 'Kanpur']);
        // Locations::create(['city' => 'Nagpur']);
        // Locations::create(['city' => 'Visakhapatnam']);
        // Locations::create(['city' => 'Indore']);
        // Locations::create(['city' => 'Thane']);
        // Locations::create(['city' => 'Bhopal']);
        // Locations::create(['city' => 'Patna']);
        // Locations::create(['city' => 'Vadodara']);
        // Locations::create(['city' => 'Ghaziabad']);
        // Locations::create(['city' => 'Ludhiana']);
        // Locations::create(['city' => 'Agra']);
        // Locations::create(['city' => 'Nashik']);
        // Locations::create(['city' => 'Faridabad']);
        // Locations::create(['city' => 'Meerut']);
        // Locations::create(['city' => 'Varanasi']);
        // Locations::create(['city' => 'Srinagar']);
        // Locations::create(['city' => 'Kochi']);
        // Locations::create(['city' => 'Coimbatore']);
        // Locations::create(['city' => 'Madurai']);
        // Locations::create(['city' => 'Vijayawada']);
        // Locations::create(['city' => 'Mysore']);
        // Locations::create(['city' => 'Tiruchirappalli']);
        // Locations::create(['city' => 'Guwahati']);
        // Locations::create(['city' => 'Jodhpur']);
        // Locations::create(['city' => 'Amritsar']);
        // Locations::create(['city' => 'Shimla']);
        // Locations::create(['city' => 'Gangtok']);
        // Locations::create(['city' => 'Chandigarh']);
        // Locations::create(['city' => 'Dehradun']);
        // Locations::create(['city' => 'Jammu']);
        // Locations::create(['city' => 'Thiruvananthapuram']);
        // Locations::create(['city' => 'Mangalore']);
        // Locations::create(['city' => 'Ranchi']);
        // Locations::create(['city' => 'Siliguri']);
        // Locations::create(['city' => 'Raipur']);
        // Locations::create(['city' => 'Bokaro']);
        // Locations::create(['city' => 'Surat']);
        // Locations::create(['city' => 'Goa']);
        // Locations::create(['city' => 'Jabalpur']);
        // Locations::create(['city' => 'Gwalior']);
        // Locations::create(['city' => 'Ujjain']);
        // Locations::create(['city' => 'Kanpur']);
        // Locations::create(['city' => 'Allahabad']);
    }
}
