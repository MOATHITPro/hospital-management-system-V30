<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\City;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $districts = [
            "Madinah" => [
                ["name" => "Ad Dar", "population" => 10000],
                ["name" => "Al Ghabah", "population" => 12000],
                ["name" => "Al Aqool", "population" => 10000],
                ["name" => "Ar Ranuna", "population" => 10000],
                ["name" => "Qaba", "population" => 15000]
            ],
            "Jeddah" => [
                ["name" => "Al Naeem", "population" => 20000],
                ["name" => "Al Sharafeyah", "population" => 25000],
                ["name" => "Al Balad", "population" => 30000],
                ["name" => "Al Samer", "population" => 18000],
                ["name" => "Al Safa", "population" => 22000]
            ],
            "Makkah" => [
                ["name" => "Al Shoqiyah", "population" => 15000],
                ["name" => "Al Khalidiyyah", "population" => 20000],
                ["name" => "Al Iskan", "population" => 25000],
                ["name" => "Al Buhayrat", "population" => 10000],
                ["name" => "Al Khadra", "population" => 18000]
            ],
            "Riyadh" => [
                ["name" => "Al Olaya", "population" => 30000],
                ["name" => "Al Mutamarat", "population" => 15000],
                ["name" => "Al Yasmin", "population" => 12000],
                ["name" => "Al Hamra", "population" => 25000],
                ["name" => "Al Aziziyah", "population" => 18000]
            ],
            "Dammam" => [
                ["name" => "Taybah", "population" => 10000],
                ["name" => "Al Jalawiyah", "population" => 10000],
                ["name" => "Al Mazruiyah", "population" => 10000],
                ["name" => "An Nada", "population" => 10000],
                ["name" => "Uhud", "population" => 12000]
            ],
            "Abha" => [
                ["name" => "Al Khasha", "population" => 10000],
                ["name" => "An Nasab", "population" => 40000],
                ["name" => "Al Wardatain", "population" => 30000],
                ["name" => "Al Wasayif", "population" => 20000],
                ["name" => "Shamasan", "population" => 10000]
            ],
            "Buraydah" => [
                ["name" => "Al Fayziyyah", "population" => 15000],
                ["name" => "Al Qadisyah", "population" => 10000],
                ["name" => "Al Hilal", "population" => 12000],
                ["name" => "An Naziyah", "population" => 20000],
                ["name" => "Ayn Adh Dhib", "population" => 40000]
            ]
        ];

        foreach ($districts as $city => $districtList) {
            $cityModel = City::where('name', $city)->first();

            foreach ($districtList as $districtData) {
                District::create([
                    'name' => $districtData['name'],
                    'city_id' => $cityModel->id,
                    'population' => $districtData['population'], // إضافة عدد السكان
                ]);
            }
        }
    }

}
