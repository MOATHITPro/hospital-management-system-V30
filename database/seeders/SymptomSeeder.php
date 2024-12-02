<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Symptom;

class SymptomSeeder extends Seeder
{
    /**
     * تشغيل seeder.
     *
     * @return void
     */
    public function run(): void
    {
        $symptoms = [
            ['name' => 'Sneezing', 'is_emergency' => false],
            ['name' => 'Headache', 'is_emergency' => false],
            ['name' => 'Nausea', 'is_emergency' => false],
            ['name' => 'General Checkup', 'is_emergency' => false],
            ['name' => 'Vomiting', 'is_emergency' => false],
            ['name' => 'High Blood Pressure', 'is_emergency' => true],
            ['name' => 'Severe Abdominal Pain', 'is_emergency' => true],
            ['name' => 'Diabetic Attack', 'is_emergency' => true],
            ['name' => 'High Fever', 'is_emergency' => true],
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }
    }
}
