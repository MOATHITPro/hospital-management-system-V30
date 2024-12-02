<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorSlot;
use App\Models\PatientSymptom;
use App\Models\Symptom;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    protected static $test = [];

    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        $today = Carbon::today('+3');
        $dateOption = $this->faker->randomElement(['past', 'today', 'future']);
        $appointmentDate = $this->getAppointmentDate($dateOption, $today);

        $clinic = Clinic::inRandomOrder()->first();
        $doctor = Doctor::where('clinic_id', $clinic->id)->inRandomOrder()->first();

        if (!$clinic || !$doctor) {
            throw new \Exception("Clinic or doctor is unavailable for appointment.");
        }

        $patient = User::inRandomOrder()->first();
        if (!$patient) {
            throw new \Exception("No unique patient available.");
        }

        $symptoms = $this->getSymptoms();
        $severityLevel = $this->determineSeverityLevel($symptoms);

        if (!in_array($doctor->specialty, ['hospital pharmacist', 'Vaccination Specialist'])) {
            $this->createPatientSymptom($patient->id, $symptoms, $severityLevel);
        }

        return [
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'time_id' => null,
            'appointment_date' => Carbon::parse($appointmentDate)->format('Y-m-d'),
            'status' => null,
            'type' => 'normal',
            'notes' => $this->faker->optional()->sentence,
        ];
    }

    private function getAppointmentDate(string $dateOption, Carbon $today): \DateTime|Carbon
    {
        return match ($dateOption) {
            'past' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
            'today' => $today,
            'future' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
        };
    }

    private function getSymptoms()
    {
        $symptomCount = $this->faker->numberBetween(1, 3);
        return Symptom::select(['name', 'is_emergency'])
            ->inRandomOrder()
            ->limit($symptomCount)
            ->get();
    }


    private function determineSeverityLevel($symptoms): int
    {
        $hasEmergency = $symptoms->contains('is_emergency', 1);
        return $hasEmergency ? 3 : ($symptoms->count() > 1 ? 2 : 1);
    }

    private function createPatientSymptom(int $patientId, $symptoms, int $severityLevel): void
    {
        $mm = $symptoms->pluck('name')->toArray();
        PatientSymptom::create([
            'user_id' => $patientId,
            'symptoms' => json_encode($mm),
            'level' => $severityLevel,
        ]);
    }

    private function getSpecialtyTimeSlots(int $doctorId, $appointmentDate): array
    {
        $day = Carbon::parse($appointmentDate)->format('l');
        $times = DoctorSlot::where('doctor_id', $doctorId)
            ->where('day', $day)
            ->get();

        return $times->isNotEmpty()
            ? [$times->first()->start_time, $times->last()->end_time]
            : ['08:00:00', '17:00:00'];
    }

    public function withDate(string $dateOption): static
    {
        $appointmentDate = $this->getAppointmentDate($dateOption, Carbon::today("+3"));
        return $this->state([
            'appointment_date' => Carbon::parse($appointmentDate)->format('Y-m-d'),
        ]);
    }

    public function withType(string $type): static
    {
        return $this->state(['type' => $type]);
    }

    public function withUserId(int $patientId): static
    {
        return $this->state(['patient_id' => $patientId]);
    }
}
