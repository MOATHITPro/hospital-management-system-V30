<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorSlot;
use App\Models\TimeSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MedicationController
{
    private string $rootRoute = '';

    /**
     * Display the booking form or appointment details.
     *
     * @param Request $request
     * @return View
     */
    public function showBookingForm(Request $request): View
    {
        $appointmentDetails = $this->checkAppointment();
        $path = "{$this->rootRoute}/cancel-appointment";

        if ($appointmentDetails) {
            return view('AppointmentDetails', compact('appointmentDetails', 'path'));
        }

        return $this->showTimeChoose($request);
    }

    /**
     * Show available time slots for booking.
     *
     * @param Request $request
     * @return View
     */
    public function showTimeChoose(Request $request): View
    {
        $appointmentDetails = $this->checkAppointment();
        $path = "{$this->rootRoute}/cancel-appointment";

        if ($appointmentDetails) {
            return view('AppointmentDetails', compact('appointmentDetails', 'path'));
        }

        $user = Auth::guard('web')->user();
        $doctorId = $request->session()->get('doctor_id');
        $districtId = $user->district_id;

        // Calculate time slot duration based on district population
        // $population = District::where('id', $districtId)->value('population');
        $timeSlotDuration = 15;

        // Get today's date and one month ahead
        $today = Carbon::today();
        $endDate = $today->copy()->addMonth();

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->where('status', '!=', 'Done')
            ->whereBetween('appointment_date', [$today, $endDate])
            ->get(['appointment_date', 'time_id']);

        $bookedAppointmentsByDate = $appointments->isEmpty()
            ? []
            : $appointments->groupBy('appointment_date');

        $timeSlots = TimeSlot::where('duration', $timeSlotDuration)
            ->where('start_time', '>=', '08:00:00')
            ->where('end_time', '<=', '17:00:00')
            ->get(['id', 'start_time', 'duration']);

        $doctorAvailability = DoctorSlot::where('doctor_id', $doctorId)
            ->get(['day', 'start_time', 'end_time'])
            ->keyBy('day');

        $availableSlotsByDate = [];

        foreach ($today->daysUntil($endDate) as $date) {
            $dayOfWeek = $date->format('l');

            // Check doctor availability
            if (!$doctorAvailability->has($dayOfWeek)) {
                continue;
            }

            $doctorStartTime = $doctorAvailability[$dayOfWeek]->start_time;
            $doctorEndTime = $doctorAvailability[$dayOfWeek]->end_time;
            $appointmentsForDate = $bookedAppointmentsByDate[$date->toDateString()] ?? collect();
            $bookedTimeIds = $appointmentsForDate->pluck('time_id')->toArray();

            // Filter slots based on bookings and doctor availability
            $availableSlots = $timeSlots->filter(function ($slot) use ($bookedTimeIds, $doctorStartTime, $doctorEndTime) {
                return !in_array($slot->id, $bookedTimeIds) &&
                    $slot->start_time >= $doctorStartTime &&
                    $slot->start_time <= $doctorEndTime;
            })->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => $slot->start_time,
                ];
            });

            $availableSlotsByDate[$date->toDateString()] = [
                'day' => $dayOfWeek,
                'slots' => $availableSlots->values()->toArray(),
            ];
        }

        ksort($availableSlotsByDate);

        // $path holds the fully qualified class name
        $path = "{$this->rootRoute}/bookslot";

        return view('times', [
            'availableTimes' => $availableSlotsByDate,
            'path' => $path,
        ]);
    }

    /**
     * Book an appointment.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bookSlot(Request $request): RedirectResponse
    {
        $appointmentDetails = $this->checkAppointment();
        $path = "{$this->rootRoute}/cancel-appointment";

        if ($appointmentDetails) {
            return view('AppointmentDetails', compact('appointmentDetails', 'path'));
        }

        $validatedData = $request->validate([
            'time_slot' => 'required|integer|exists:time_slots,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ], [
            'time_slot.required' => 'You must select a time slot.',
            'time_slot.exists' => 'The selected time slot does not exist.',
            'appointment_date.required' => 'The appointment date is required.',
            'appointment_date.after_or_equal' => 'The appointment date must be today or in the future.',
        ]);

        $user = Auth::user();
        $timeSlot = TimeSlot::findOrFail($validatedData['time_slot']);
        $appointmentDate = Carbon::parse($validatedData['appointment_date']);
        $doctorId = $request->session()->get('doctor_id');

        $appointment = Appointment::where([
            'doctor_id' => $doctorId,
            'patient_id' => $user->id,
            'appointment_date' => $appointmentDate,
            'type' => '',
            'time_id' => $timeSlot->id,
        ])  ->where('status', 'cancelled')
            ->latest()->first();

        if ($appointment) {
            $appointment->restore();
            $appointment->update(['status' => 'Pending']);
        } else {
            Appointment::create([
                'doctor_id' => $doctorId,
                'patient_id' => $user->id,
                'appointment_date' => $appointmentDate,
                'type' => '',
                'time_id' => $timeSlot->id,
                'status' => 'Pending',
            ]) ;
        }

        return redirect()->route('success')->with('success', 'Your appointment has been successfully booked!');
    }

    /**
     * Update appointment data.
     *
     * @return void
     */
    public function updateData(): void
    {
        $now = Carbon::now();
        $todayDate = $now->toDateString();
        $currentTime = $now->toTimeString();

        // Delete past appointments that are not done
        Appointment::where('appointment_date', '<', $todayDate)
            ->where('status', value:  'Pending')
            ->update(['status' => 'Completed']);
        Appointment::where("status","Completed")->whereNull("deleted_at")
            ->delete();
        // Delete today's appointments that have passed the current time and are not done
        $todaysAppointments = Appointment::where('appointment_date', $todayDate)
            ->where('status', "Pending")
            ->get();

        foreach ($todaysAppointments as $appointment) {
            $timeSlot = TimeSlot::find($appointment->time_id);

            if ($timeSlot && $timeSlot->end_time <= $currentTime) {
                $appointment->update(['status' => 'Completed']);
                $appointment->delete();
            }
        }
    }

    /**
     * Cancel an appointment.
     *
     * @return RedirectResponse
     */
    public function cancelAppointment(): RedirectResponse
    {
        $user = Auth::user();
        // $doctorId = session()->get('doctor_id');

        $appointment = Appointment::where('patient_id', $user->id)
            // ->where('doctor_id', $doctorId)
            ->where('status', 'Pending')
            ->where('type', '')
            ->get();

        if ($appointment->isNotEmpty()) {
            // Delete each appointment
            foreach ($appointment as $appointment) {
                $appointment->update(['status' => 'Cancelled']);
                $appointment->delete();
            }
        }

        if ($appointment) {
            return redirect()->intended('home')->with(
                'success' ,'Appointment cancelled successfully.'
            );
        }

        return redirect()->back()->with(
            'error','No active appointment found.'
        );
    }


    /**
     * Show clinics.
     *
     * @return View
     */
    public function showClinic(): View
    {
        $appointmentDetails = $this->checkAppointment();
        $path = "{$this->rootRoute}/cancel-appointment";

        if ($appointmentDetails) {
            return view('AppointmentDetails', compact('appointmentDetails', 'path'));
        }

        $clinics = Clinic::with(['city', 'district', 'doctors'])
            ->get()
            ->makeHidden(['created_at', 'updated_at'])
            ->filter(function ($clinic) {
                // Check if "Vaccination Specialist" is in the clinic's specialties
                return $clinic->doctors->pluck('specialty')->contains('hospital pharmacist');
            });

        $path = "{$this->rootRoute}/showDoctor";

        return view('clinic-selection', [
            'clinics' => $clinics,
            'path' => $path,
        ]);
    }

    /**
     * Show doctors in a clinic.
     *
     * @param int $clinicId
     * @return View
     */
    public function showDoctor(int $clinicId): View
    {
        $appointmentDetails = $this->checkAppointment();
        $path = "{$this->rootRoute}/cancel-appointment";

        if ($appointmentDetails) {
            return view('AppointmentDetails', compact('appointmentDetails', 'path'));
        }

        $doctors = Doctor::withoutTrashed()
            ->where('clinic_id', $clinicId)
            ->where('specialty',  'hospital pharmacist')
            ->get()
            ->makeHidden(['created_at', 'updated_at', 'deleted_at']);

        $path = "{$this->rootRoute}/save-doctor";

        return view('select-doctor', [
            'doctors' => $doctors,
            'path' => $path,
        ]);
    }

    /**
     * Save selected doctor to session.
     *
     * @param int $doctorId
     * @return RedirectResponse
     */
    public function saveDoctor(int $doctorId): RedirectResponse
    {
        session(['doctor_id' => $doctorId]);

        return redirect("/{$this->rootRoute}/book-appointment");
    }

    /**
     * Check for existing appointment.
     *
     * @return array|bool
     */
    public function checkAppointment()
    {
        $this->updateData();
        $user = Auth::user();

        $appointmentDetails = Appointment::with(['doctor.clinic', 'timeSlot'])
            ->where('status', "=",'Pending')
            ->where('patient_id', $user->id)
            ->where('type', '')
            ->get()
            ->map(function ($appointment) {
                return [
                    'appointment_date' => $appointment->appointment_date,
                    'start_time' => $appointment->timeSlot->start_time ?? null,
                    'doctor' => $appointment->doctor->name,
                    'clinic' => $appointment->doctor->clinic->name,
                ];
            })
            ->first();

        return $appointmentDetails ?: false;
    }
}
