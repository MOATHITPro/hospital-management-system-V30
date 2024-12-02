<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClinicFactory extends Factory
{
    protected $model = Clinic::class;

    public function definition(): array
    {
        // اختيار مدينة عشوائية
        $city = City::inRandomOrder()->first();

        // اختيار حي ينتمي لنفس المدينة
        $district = District::where('city_id', $city->id)->inRandomOrder()->first();

        return [
            'name' => $this->faker->company . ' Clinic',
            'city_id' => $city->id,
            'district_id' => $district->id,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
