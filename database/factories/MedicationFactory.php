<?php

namespace Database\Factories;

use App\Models\Medication;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), // Generates a random word for the medication name
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity between 1 and 100
            'type' => $this->faker->word(),
            'expiry_date' =>  $this->faker->dateTimeBetween('+1 year', '+2 year')->format('Y-m-d'),
        ];
    }
}
