<?php

namespace Database\Factories;

use App\Models\GeneralStaff;
use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralStaffFactory extends Factory
{
    protected $model = GeneralStaff::class;

    public function definition(): array
    {
        $clinic = Clinic::inRandomOrder()->first();

        return [
            'name' => $this->faker->name,
            'role' => $this->faker->randomElement(['Receptionist', 'Security', 'Cleaner', 'Maintenance']),
            'clinic_id' => $clinic->id,
            'experience' => $this->faker->numberBetween(1, 20),
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => '12345678',
        ];
    }
}
