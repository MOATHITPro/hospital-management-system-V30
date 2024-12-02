<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = ['Madinah', 'Jeddah', 'Makkah', 'Riyadh', 'Dammam', 'Abha', 'Buraydah'];

        foreach ($cities as $city) {
            City::create(['name' => $city]);
        }
    }
}
