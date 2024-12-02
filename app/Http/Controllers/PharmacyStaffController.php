<?php

namespace App\Http\Controllers;

use App\Models\PharmacyAppointment;
use App\Models\Medication;
use App\Models\PharmacyOrderMedication;
use App\Services\Login\LoginService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class PharmacyStaffController extends Controller
{

    public function index(){
        $user = LoginService::isAuthenticatedAcrossGuards();

        $s = Medication::all();

        // جلب الطلبات مع العلاقات المطلوبة
        $appointments = PharmacyAppointment::with([
            'patient',
            'doctor',
            'medications.medication'
        ])
            ->where('pharmacy_id', $user->pharmacy_id) // استخدام الفلترة هنا بدلاً من كل البيانات
            ->where('status','=','Pending')
            ->get();

//        return response()->json($appointments);

        // تمرير البيانات إلى صفحة Blade
        return view('pharmacyDashboard', ['s' => $s, 'orders' => $appointments]);
    }

    /**
     * عرض المواعيد في الصيدلية
     */
    public function viewAppointments()
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        // جلب جميع المواعيد التي تخص الصيدلية الخاصة بموظف الصيدلية الحالي
        $appointments = PharmacyAppointment::with(['patient', 'doctor'])
            ->where('pharmacy_id', $user->pharmacy_id)
            ->where('status', 'pending')
//            ->orderBy('appointment_date')
            ->get();

        return response()->json($appointments);

//        return view('pharmacy.appointments', ['appointments' => $appointments]);
    }

    /**
     * عرض تفاصيل العلاجات لموعد معين
     */
    public function viewAppointmentDetails($appointmentId)
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        // جلب الموعد والتأكد من أنه يخص الصيدلية الحالية
        $appointment = PharmacyAppointment::with(['medications.medication', 'patient', 'doctor'])
            ->where('id', $appointmentId)
            ->where('pharmacy_id', $user->pharmacy_id)
            ->firstOrFail();

        return view('pharmacy.appointment_details', [
            'appointment' => $appointment,
        ]);
    }

    public function completeAppointment($appointmentId)
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        $appointment = PharmacyAppointment::findOrFail($appointmentId);

        if ($appointment->pharmacy_id !== $user->pharmacy_id) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->update(['status' => 'complete']);

        return redirect()->back()->with('status', 'Appointment marked as complete.');
    }

    public function addMedication(Request $request)
    {
        try {
            // Custom validation rules and messages
            $validator = Validator::make($request->all(), [
                'Name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'Type' => 'required|string',
                'expiryDate' => 'required|date|after:today',
                'description' => 'nullable|string|max:500',
            ], [
                'Name.required' => 'Please enter the medication name.',
                'Name.max' => 'The medication name must not exceed 255 characters.',
                'Name.unique' => 'This medication already exists.',
                'quantity.required' => 'Please specify the quantity.',
                'quantity.integer' => 'Quantity must be a valid integer.',
                'quantity.min' => 'Quantity should be at least 1.',
                'Type.required' => 'Please specify the type of medication.',
                'expiryDate.required' => 'Please provide the expiry date.',
                'expiryDate.date' => 'Expiry date must be a valid date.',
                'expiryDate.after' => 'Expiry date must be in the future.',
                'description.max' => 'Description should not exceed 500 characters.',
            ]);

            // If validation fails, redirect back with errors and old input
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('showForm', 'Form');
            }

            // Create the new medication entry in the database
            Medication::create([
                'name' => $request->Name,
                'quantity' => $request->quantity,
                'type' => $request->Type,
                'expiry_date' => $request->expiryDate,
                'description' => $request->description ?? null,
            ]);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Medication added successfully!');
        } catch (Exception $e) {
            // Handle any unexpected errors and return a generic error message
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function cancel($appointmentId)
    {
        // البحث عن الموعد بناءً على رقم المعرف
        $app = PharmacyAppointment::where('id', $appointmentId)->first();
        $orders = PharmacyOrderMedication::where('pharmacy_appointment_id',$app->id)->get()->pluck('id')->toArray();

        if (!empty($orders)) {
            foreach ($orders as $id) {
                PharmacyOrderMedication::find($id)?->delete();
            }
        }

        // التحقق من وجود الموعد وحالته الحالية
        if ($app && $app->status === 'Pending') {
            $app->update(['status' => 'Cancelled']); // تحديث الحالة إلى "Cancelled"

            return redirect()->back()->with('success', 'Appointment has been successfully cancelled.');
        } else {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function done($appointmentId)
    {
        // البحث عن الموعد بناءً على رقم المعرف
        $app = PharmacyAppointment::where('id', $appointmentId)->first();
        $orders = PharmacyOrderMedication::where('pharmacy_appointment_id',$app->id)->get()->pluck('id')->toArray();

        if (!empty($orders)) {
            foreach ($orders as $id) {
                PharmacyOrderMedication::find($id)?->delete();
            }
        }

        // التحقق من وجود الموعد وحالته الحالية
        if ($app && $app->status === 'Pending') {
            $app->update(['status' => 'Done']); // تحديث الحالة إلى "Done"
            return redirect()->back()->with('success', 'Appointment has been marked as done successfully.');
        } else {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }



}
