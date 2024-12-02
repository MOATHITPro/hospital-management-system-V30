<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\GeneralStaff;
use App\Models\Medication;
use App\Models\Nurse;
use App\Models\Pharmacy;
use App\Models\PharmacyStaff;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(SpecialtySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(SymptomSeeder::class);
        $this->call(TimeSlotsSeeder::class);


        Clinic::factory()->count(10)->create();

        $this->call(DoctorSeeder::class);

        $this->call(UsersTableSeeder::class);


        $this->call(AdminTableSeeder::class);
        $this->call(AppointmentSeeder::class);

        $pharmacies = Pharmacy::all()->pluck('id')->toArray();
        foreach ($pharmacies as $id) {
            PharmacyStaff::factory()->create([
                'pharmacy_id' => $id,
            ]);
        }
        Medication::factory()->count(20)->create();


    }
}
