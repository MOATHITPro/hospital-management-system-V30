<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'General Medicine', 'General Surgery', 'Internal Medicine', 'Pediatrics',
            'Cardiology', 'Cardiothoracic Surgery', 'Dermatology', 'Psychiatry',
            'Obstetrics and Gynecology', 'Ophthalmology', 'Otolaryngology', 'Dentistry',
            'Neurology', 'Neurosurgery', 'Gastroenterology', 'Nephrology',
            'Orthopedic Surgery', 'Pulmonology', 'Endocrinology', 'Hematology & Oncology',
            'Sports Medicine', 'Anesthesiology', 'Infectious Diseases', 'Emergency Medicine',
            'Physical Medicine & Rehabilitation', 'Plastic Surgery', 'Urology', 'Pathology',
            'Nuclear Medicine', 'Rheumatology' , 'Vaccination Specialist' , 'hospital pharmacist'
        ];

        foreach ($specialties as $specialty) {
            Specialty::create(['name' => $specialty]);
        }
    }
}
