<?php

namespace Database\Factories;

use App\Models\Nurse;
use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseFactory extends Factory
{
    protected $model = Nurse::class;

    public function definition(): array
    {
        // اختيار عيادة عشوائية للممرض
        $clinic = Clinic::inRandomOrder()->first();

        return [
            'name' => $this->faker->name,
            'specialty' => $this->faker->randomElement(['General', 'Pediatrics', 'Surgical', 'Emergency', 'ICU']),
            'clinic_id' => $clinic->id,
            'experience' => $this->faker->numberBetween(1, 20),
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => '12345678',
            'Permissions' => $this->faker->randomElement(['normal', 'vaccine', 'medicine'])
        ];
    }
}
