<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\City;
use App\Models\District;
use App\Models\Login;
use App\Models\PatientSymptom;
use App\Models\PharmacyAppointment;
use App\Models\User;
use App\Services\Login\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function showHomePage()
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        $pharmacy_appointments = PharmacyAppointment::with(['doctor.clinic'])
            ->where('patient_id',"=",$user->id)
            ->where('status',  '=','Pending')
            ->get()
            ->map(function ($appointment) {
                return [
                    'appointment_date' => $appointment->date,
                    'start_time' => $appointment->time ?? null,
                    'doctor' => $appointment->doctor->name,
                    'clinic' => $appointment->doctor->clinic->name,
                ];
            });
        if($pharmacy_appointments->isNotEmpty()){
            return view('home',['appointmentDetails' => $pharmacy_appointments->last()]);
//            return response()->json($pharmacy_appointments);
        } else{
            return view('home');
        }
    }
    /**
     * Update the specified user's information with custom validation.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function updateUser(Request $request)
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        try {
            // Custom validation rules and messages
            $validator = Validator::make($request->all(), [
                'first_name' => 'sometimes|required|string|max:255',
                'last_name' => 'sometimes|required|string|max:255',
                'username' => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'date_of_birth' => 'sometimes|required|date',
                'id_number' => 'sometimes|required|string|max:255|unique:users,id_number,' . $user->id,
                'city_id' => 'sometimes|required|exists:cities,id',
                'district_id' => 'sometimes|required|exists:districts,id',
            ], [
                'first_name.required' => 'Please enter a first name.',
                'first_name.max' => 'The first name must not exceed 255 characters.',
                'last_name.required' => 'Please enter a last name.',
                'last_name.max' => 'The last name must not exceed 255 characters.',
                'username.required' => 'Please enter a username.',
                'username.max' => 'The username must not exceed 255 characters.',
                'username.unique' => 'This username is already taken.',
                'email.required' => 'Please enter an email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'The email must not exceed 255 characters.',
                'email.unique' => 'This email address is already taken.',
                'password.min' => 'The password must be at least 8 characters long.',
                'password.confirmed' => 'The password confirmation does not match.',
                'date_of_birth.required' => 'Please enter the date of birth.',
                'date_of_birth.date' => 'Please enter a valid date.',
                'id_number.required' => 'Please enter an ID number.',
                'id_number.unique' => 'This ID number is already registered.',
                'city_id.required' => 'Please select a valid city.',
                'city_id.exists' => 'The selected city does not exist.',
                'district_id.required' => 'Please select a valid district.',
                'district_id.exists' => 'The selected district does not exist.',
            ]);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Extra username and email checks
            if (
                Login::where('username', $request->username)->where('username', '!=', $user->username)->exists()
//                ||
//                Login::where('email', $request->email)->where('id', '!=', $user->email)->exists()
            ) {
                return redirect()->back()->with('error', 'This username or email address is already in use.')->withInput();
            }


            if (!$user) {
                return redirect()->back()->with('error', 'User not found.');
            }

            if(isset($request->password) && $request->password != ""){
                $user->update($request->only([
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                    'password',
                    'date_of_birth',
                    'id_number',
                    'city_id',
                    'district_id',
                ]));
            } else {
                $user->update($request->only([
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                    'date_of_birth',
                    'id_number',
                    'city_id',
                    'district_id',
                ]));
            }

            // Update the user's information


            // Redirect back with success message
            return redirect("/home")->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            // Catch unexpected errors and return a generic error message
            return redirect()->back()->with('error', $e);
        }
    }

    public function editUser()
    {
        // Fetch the user data
        $user = LoginService::isAuthenticatedAcrossGuards();

        // Fetch available cities and districts (adjust as needed based on your data)
        $cities = City::all();
        $districts = District::all();

        // Pass the user, cities, and districts data to the view
        return view('testing', compact('user', 'cities', 'districts'));
    }
    public function showHistory()
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        $visitData = Appointment::with(['doctor.clinic', 'timeSlot'])
            ->where('status',  '!=','Pending')
            ->withoutGlobalScope("notDeleted")
            ->onlyTrashed()
            ->where('patient_id', $user->id)
            ->get();
        $visitData->each(function ($item) {
           $item["start_time"] = $item->timeSlot->start_time;
           $item["end_time"] = $item->timeSlot->end_time;
           $item['duration'] = $item->timeSlot->duration;
        });

        $sortedAppointments = $visitData->sortBy([
            ['appointment_date', 'asc'],
            ['start_time', 'asc'],
        ])->values();


        $appointmentsWithNewIds = $sortedAppointments->values()->map(function ($appointment, $index) {
            $appointment['id'] = $index + 1;
            return $appointment;
        });


        return view("previous_visits",['visitData' => $appointmentsWithNewIds->reverse()]);
//        return response()->json($visitData);

//        if ($appointmentDetails->isNotEmpty()) {
//            return v
//        }
    }
}
