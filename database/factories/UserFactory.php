<?php
namespace Database\Factories;
use App\Models\User;
use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        // Select a random city
        $city = City::inRandomOrder()->first();

        // Select a district within the chosen city
        $district = District::where('city_id', $city->id)->inRandomOrder()->first();

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',
            'city_id' => $city->id,
            'district_id' => $district->id,
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'), // Ensuring reasonable birth date
            'id_number' => $this->faker->unique()->numerify('##########'), // Unique ID with 10 digits
        ];
    }
}
