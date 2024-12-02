<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Medication;
use App\Models\Pharmacy;
use App\Models\PharmacyAppointment;
use App\Models\PharmacyOrderMedication;
use App\Services\Login\LoginService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NurseController
{
    public function showPatient()
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        $permission = $user->Permissions;
        $doctors = Doctor::where('clinic_id',$user->clinic_id)->pluck('id')->toArray();

        // Fetch pending appointments with latest symptom
        $appointments = Appointment::with([
            'timeSlot',
            'patient.patientSymptoms' => function ($query) {
                $query->latest()->limit(1);
            }
        ])
            ->whereDate('appointment_date', "=", Carbon::today("+3")->format('Y-m-d'))
            ->where('status', 'Pending')
            ->where('type',$permission)
            ->whereIn('doctor_id',$doctors)
            ->get()
            ->map(function ($item) {
                $item['start_time'] = $item->timeSlot->start_time;
                $item['end_time'] = $item->timeSlot->end_time;
                return $item;
            })
            ->makeHidden(['timeSlot', 'created_at', 'updated_at', 'deleted_at', 'doctor_id', 'time_id', 'patient_id']);

        $appointments->each(function ($appointment) {
            $appointment->patient->makeHidden([
                'created_at', 'updated_at', 'deleted_at', 'city_id',
                'district_id', 'email', 'username', 'id_number'
            ]);

            $appointment->patient['age'] = Carbon::parse($appointment->patient['date_of_birth'])->age;
            $appointment->patient->makeHidden(['date_of_birth']);
            $appointment->patient->patientSymptoms->each->makeHidden([
                'created_at', 'updated_at', 'deleted_at', 'user_id', 'id'
            ]);


            $patientSymptoms = $appointment->patient->patientSymptoms->first();
            if ($patientSymptoms) {
                $symptoms = $patientSymptoms->symptoms ? $patientSymptoms->symptoms : null;
                $level = $patientSymptoms->level ? $patientSymptoms->level : null;
                $appointment->patient['symptoms'] = $symptoms;
                $appointment->patient['level'] = $level;
                unset($appointment->patient->patientSymptoms);
            }
//
        });

        // Sort by date and start time
        $sortedAppointments = $appointments->sortBy([
            ['appointment_date', 'asc'],
            ['start_time', 'asc'],
        ])->values();

        // Assign new sequential IDs
        $appointmentsWithNewIds = $sortedAppointments->values()->map(function ($appointment, $index) {
            $appointment['id_new'] = $index + 1;
            return $appointment;
        });

        if($permission === ''){
            $appointmentPh = PharmacyAppointment::with('patient')
            ->whereDate('date', "=", Carbon::today("+3")->format('Y-m-d'))
            ->whereIn('doctor_id',$doctors)
            ->where('status', 'Pending')
            ->get();
            $sortedAppointmentsPh = $appointmentPh->sortBy([
                ['date', 'asc'],
                ['time', 'asc'],
            ])->values();

            // Assign new sequential IDs
            $appointmentsWithNewIdsPH = $sortedAppointmentsPh->values()->map(function ($appointmentPh, $index) {
                $appointmentPh['id_new'] = $index + 1;
                return $appointmentPh;
            });
            return view('doctor_appoint', ['appointments' => $appointmentsWithNewIdsPH]);
//                    return response()->json($appointmentsWithNewIdsPH);



        }

//        return response()->json($appointmentsWithNewIds);

        return view('doctor_appoint', ['appointments' => $appointmentsWithNewIds]);
    }

    public function showAppointment($appointmentId)
    {
        $user = Auth::guard('doctor')->user();

        $appointments = Appointment::
        with([
            'timeSlot',
            'patient.patientSymptoms' => function ($query) {
                $query->latest()->limit(1);
            }
        ])
            ->where('id', $appointmentId)
            ->whereDate('appointment_date', "=", Carbon::today("+3")->format('Y-m-d'))
            ->where('status', 'Pending')
            ->where('doctor_id', $user->id)
            ->get()
            ->makeHidden(['timeSlot', 'created_at', 'updated_at', 'deleted_at', 'doctor_id', 'time_id', 'patient_id']);

        $appointments->each(function ($appointment) {
            $appointment->patient->makeHidden([
                'created_at', 'updated_at', 'deleted_at', 'city_id',
                'district_id', 'email', 'username', 'id_number'
            ]);
//
            $appointment->patient['age'] = Carbon::parse($appointment->patient['date_of_birth'])->age;
            $appointment->patient->makeHidden(['date_of_birth']);
            $appointment->patient->patientSymptoms->each->makeHidden([
                'created_at', 'updated_at', 'deleted_at', 'user_id', 'id'
            ]);
//
            $patientSymptoms = $appointment->patient->patientSymptoms->first();
            if ($patientSymptoms) {
                $symptoms = $patientSymptoms->symptoms ? $patientSymptoms->symptoms : null;
                $level = $patientSymptoms->level ? $patientSymptoms->level : null;
                $appointment->patient['symptoms'] = $symptoms;
                $appointment->patient['level'] = $level;
                unset($appointment->patient->patientSymptoms);
            }
        });

//        return response()->json($appointments);

        return view('AppointmenDoctor', ['appointment' => $appointments->first() , 'appointmentId' => $appointmentId]);
    }

    /**
     * Transfer patient to pharmacy and assign medications
     */
    public function transferToPharmacy(Request $request, $appointmentId)
    {
        $user = Auth::guard('doctor')->user();

        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string|max:500',
            'medications' => 'required|array',
            'medications.*.selected' => 'sometimes|boolean',
            'medications.*.quantity' => 'required_if:medications.*.selected,1|nullable|integer|min:1',
            'medications.*.dosage' => 'nullable|string|max:100',
            'medications.*.instructions' => 'nullable|string|max:255',
        ], [
            'medications.required' => 'Please select at least one medication.',
            'medications.*.selected.required' => 'Please select each medication that you want to prescribe.',
            'medications.*.quantity.required_if' => 'Quantity is required for each selected medication.',
            'medications.*.quantity.integer' => 'Quantity must be a valid integer.',
            'medications.*.quantity.min' => 'Quantity for each medication must be at least 1.',
            'medications.*.dosage.max' => 'Dosage description must not exceed 100 characters.',
            'medications.*.instructions.max' => 'Instructions must not exceed 255 characters.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointment = Appointment::findOrFail($appointmentId);
        $pharmacy = Pharmacy::where('clinic_id', $user->clinic_id)->first();

        if (!$pharmacy) {
            return redirect()->back()->with('error', 'No associated pharmacy found for this clinic.');
        }

        // التحقق من آخر موعد في نفس اليوم
        $today = now()->toDateString();
        $lastAppointmentToday = PharmacyAppointment::where('pharmacy_id', $pharmacy->id)
            ->whereDate('date', $today)
            ->orderByDesc('time')
            ->first();

        if ($lastAppointmentToday) {
            // إذا كان هناك موعد سابق اليوم، أضف 5 دقائق إليه
            $appointmentDate = $today;
            $appointmentTime = Carbon::parse($lastAppointmentToday->time)->addMinutes(5)->toTimeString();
        } else {
            // إذا لم يكن هناك موعد اليوم، قم بإنشاء موعد جديد
            $appointmentDate = now()->toDateString(); // تعيين اليوم
            $appointmentTime = now()->addMinutes(15)->toTimeString(); // أول موعد بعد 15 دقيقة
        }

        // التأكد أن الموعد في تاريخ اليوم أو تعيينه للغد إذا كان خارج أوقات العمل
        if (Carbon::parse($appointmentTime)->isPast()) {
            $appointmentDate = now()->addDay()->toDateString();
            $appointmentTime = '08:00:00'; // تعيين وقت جديد ليوم الغد
        }

        $pharmacyAppointment = PharmacyAppointment::create([
            'patient_id' => $appointment->patient_id,
            'pharmacy_id' => $pharmacy->id,
            'doctor_id' => $user->id,
            'date' => $appointmentDate,
            'time' => $appointmentTime,
            'status' => 'pending',
            'estimated_pickup_time' => Carbon::parse($appointmentTime)->addHour(), // إضافة ساعة إلى وقت الاستلام المتوقع
            'pharmacy_notes' => $request->input('description')
        ]);


        foreach ($request->input('medications') as $medication) {
            if (isset($medication['selected']) && $medication['selected'] == true) {
//                $medicationRecord = Medication::find($medication['medication_id']);
//                if ($medicationRecord->quantity < $medication['quantity']) {
//                    return redirect()->back()->with('error', 'Insufficient stock for medication: ' . $medicationRecord->name);
//                }
//
//                $medicationRecord->decrement('quantity', $medication['quantity']);

                PharmacyOrderMedication::create([
                    'pharmacy_appointment_id' => $pharmacyAppointment->id,
                    'medication_id' => $medication['medication_id'],
                    'patient_quantity' => $medication['quantity'],
                    'dosage' => $medication['dosage'],
                    'instructions' => $medication['instructions'],
                ]);
            }
        }
        $appointment->update(["status" => "ToPharmacy"]);


        return redirect("/appointments")->with('success', 'Medications have been successfully transferred to the pharmacy.');
    }

    /**
     * Show transfer-to-pharmacy interface with medication list
     */
//    public function showTransferToPharmacy($appointmentId)
//    {
//        $medication = Medication::all()->makeHidden(['quantity']);
////        return response()->json($medication);
//
//        return view('midication', ['medications' => $medication ,'appointmentId' => $appointmentId,]);
//    }

    public function showTransferToPharmacy(Request $request, $appointmentId)
    {
        $user = Auth::guard('doctor')->user();
        $appointment = Appointment::findOrFail($appointmentId);
        $pharmacy = Pharmacy::where('clinic_id', $user->clinic_id)->first();

        if (!$pharmacy) {
            return redirect()->back()->with('error', 'No associated pharmacy found for this clinic.');
        }

        // التحقق من آخر موعد في نفس اليوم
        $today = now()->toDateString();
        $lastAppointmentToday = PharmacyAppointment::where('pharmacy_id', $pharmacy->id)
            ->whereDate('date', $today)
            ->orderByDesc('time')
            ->first();

        if ($lastAppointmentToday) {
            // إذا كان هناك موعد سابق اليوم، أضف 5 دقائق إليه
            $appointmentDate = $today;
            $appointmentTime = Carbon::parse($lastAppointmentToday->time)->addMinutes(5)->toTimeString();
        } else {
            // إذا لم يكن هناك موعد اليوم، قم بإنشاء موعد جديد
            $appointmentDate = now()->toDateString(); // تعيين اليوم
            $appointmentTime = now()->addMinutes(15)->toTimeString(); // أول موعد بعد 15 دقيقة
        }

        // التأكد أن الموعد في تاريخ اليوم أو تعيينه للغد إذا كان خارج أوقات العمل
        if (Carbon::parse($appointmentTime)->isPast()) {
            $appointmentDate = now()->addDay()->toDateString();
            $appointmentTime = '08:00:00'; // تعيين وقت جديد ليوم الغد
        }

        $pharmacyAppointment = PharmacyAppointment::create([
            'patient_id' => $appointment->patient_id,
            'pharmacy_id' => $pharmacy->id,
            'doctor_id' => $user->id,
            'date' => $appointmentDate,
            'time' => $appointmentTime,
            'status' => 'pending',
            'estimated_pickup_time' => Carbon::parse($appointmentTime)->addHour(), // إضافة ساعة إلى وقت الاستلام المتوقع
            'pharmacy_notes' => $request->input('description')
        ]);
        $appointment->update(["status" => "ToPharmacy"]);
        return redirect("/appointments")->with('success', 'Medications have been successfully transferred to the pharmacy.');

    }
    public function finish($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->update(["status" => "Done"]);
        $appointment->delete();

        return redirect("/appointments")->with("success", "Appointment finished");
    }
}
