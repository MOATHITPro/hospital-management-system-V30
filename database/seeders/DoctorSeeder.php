<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\GeneralStaff;
use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create([
            'name' => 'Khaled',
            'username' => 'Khaled',
            'email' => 'oodfnksjn@gmail.com',
            'password' => bcrypt("12345678"),
            'specialty' => 'Anesthesiology',
            'clinic_id' => 1,
            'experience' => 20,
        ]);

        Clinic::with('district')->each(function ($clinic) {
            $population = $clinic->district->population;
//            $population = $district ? $district->population : 0;

            // حدد الحد الأقصى للأطباء بناءً على عدد السكان
            if ($population <= 10000) {
                $doctorLimit = 3;
                $nurseLimit = 5;
                $staffLimit = 3;
            } elseif ($population <= 20000) {
                $doctorLimit = 6;
                $nurseLimit = 8;
                $staffLimit = 5;
            } elseif ($population <= 30000) {
                $doctorLimit = 10;
                $nurseLimit = 12;
                $staffLimit = 8;
            } else {
                $doctorLimit = 10;
                $nurseLimit = 12;
                $staffLimit = 8;
            }
            if($clinic->id === 1){
                $doctorLimit = $doctorLimit-1;
            }

            Doctor::factory()->count($doctorLimit)->create(['clinic_id' => $clinic->id]);

            Nurse::factory()->count($nurseLimit)->create(['clinic_id' => $clinic->id]);

            GeneralStaff::factory()->count($staffLimit)->create(['clinic_id' => $clinic->id]);


            Doctor::factory()->count(1)->create(['clinic_id' => $clinic->id , 'specialty' => 'hospital pharmacist']);
            Doctor::factory()->count(1)->create(['clinic_id' => $clinic->id , 'specialty' => 'Vaccination Specialist']);
        });
    }
}
