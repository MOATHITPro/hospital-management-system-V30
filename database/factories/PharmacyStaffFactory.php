<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Models\PharmacyStaff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PharmacyStaffFactory extends Factory
{
    protected $model = PharmacyStaff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $pharmacy = Pharmacy::all()->random();
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => '12345678',
            'pharmacy_id' => $pharmacy->id, // إنشاء صيدلية جديدة إذا لم تكن موجودة
        ];
    }
}
