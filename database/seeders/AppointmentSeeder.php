<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = $this->getAllUserIds();
        $uniqueUserIds = $this->getUniqueUserIds();
        $faker = Faker::create();
        $allTime = TimeSlot::where('duration', 15)->get()->pluck('id')->toArray();
        $statuses = ['Done', 'Cancelled', 'Completed', 'ToPharmacy'];

        if (empty($uniqueUserIds)) {
            echo "No unique user IDs available for appointments. Seeder process terminated.\n";
            return;
        }

        // Batch appointment generation with past dates
        for ($i = 0; $i < 510; $i += 10) {
            foreach (range(0, 10) as $x) {
                Appointment::factory()
                    ->withDate('past')
                    ->withUserId($faker->randomElement($userIds))
                    ->create([
                        'status' => $faker->randomElement($statuses),
                        'time_id' => $faker->randomElement($allTime),
                    ]);
            }
        }

        // Loop through each doctor and create appointments with unique users
        Doctor::all()->each(function ($doctor) use ($allTime, &$uniqueUserIds, $faker) {
            $primaryType = $this->getPrimaryAppointmentType($doctor->specialty);

            for ($i = 0; $i < 10; $i++) {
                if (empty($uniqueUserIds)) {
                    echo "No more unique user IDs available for doctor appointments. Stopping generation.\n";
                    return;
                }

                $dateCategory = $i < 5 ? 'today' : 'future';
                $userID = $faker->randomElement($uniqueUserIds);
                $uniqueUserIds = array_values(array_diff($uniqueUserIds, [$userID]));

                Appointment::factory()
                    ->withDate($dateCategory)
                    ->withType($primaryType)
                    ->withUserId($userID)
                    ->create([
                        'doctor_id' => $doctor->id,
                        'status' => 'Pending',
                        'time_id' => $allTime[$i]
                    ]);
            }
        });
    }

    protected function getPrimaryAppointmentType(string $specialty): string
    {
        return match ($specialty) {
            'hospital pharmacist' => 'medicine',
            'Vaccination Specialist' => 'vaccine',
            default => 'normal',
        };
    }

    protected function getUniqueUserIds(): array
    {
        return User::whereDoesntHave('appointments', function ($query) {
            $query->whereColumn('users.id', 'appointments.patient_id')
                ->whereNull('appointments.deleted_at');
        })->pluck('id')->toArray();
    }

    protected function getAllUserIds(): array
    {
        return User::pluck('id')->toArray();
    }
}
