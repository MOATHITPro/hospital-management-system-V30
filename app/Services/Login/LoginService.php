<?php

namespace App\Services\Login;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\GeneralStaff;
use App\Models\Login;
use App\Models\Nurse;
use App\Models\User;
use App\Models\PharmacyStaff; // إضافة النموذج لموظفي الصيدلية
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function validateUserCredentials(array $credentials): ?Login
    {
        $user = Login::where('username', $credentials['username'])->first();

        // Check if user exists and the password is correct
        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    public function loginAs(Login $user): array
    {
        if ($user->type === 'admin') {
            $adminUser = Admin::find($user->id);
            Auth::guard('admin')->login($adminUser);
            return ['path' => 'admin', 'message' => 'Welcome Admin!'];
        } elseif ($user->type === 'staff') {
            $staffUser = GeneralStaff::find($user->id);
            Auth::guard('general_staff')->login($staffUser);
            return ['path' => 'staff', 'message' => 'Welcome Staff!'];
        } elseif ($user->type === 'nurse'){
            $nurseUser = Nurse::find($user->id);
            Auth::guard('nurse')->login($nurseUser);
            return ['path' => 'nurse', 'message' => 'Welcome Nurse!'];
        } elseif ($user->type === 'doctor'){
            $doctorUser = Doctor::find($user->id);
            Auth::guard('doctor')->login($doctorUser);
            return ['path' => 'appointments', 'message' => 'Welcome Doctor !'];
        } elseif ($user->type === 'pharmacy_staff') { // إضافة موظفي الصيدلية
            $pharmacyStaffUser = PharmacyStaff::find($user->id);
            Auth::guard('pharmacy_staff')->login($pharmacyStaffUser);
            return ['path' => 'pharmacy/dashboard', 'message' => 'Welcome Pharmacy Staff!'];
        } else {
            $regularUser = User::find($user->id);
            Auth::login($regularUser);
            return ['path' => 'home', 'message' => 'Welcome User!'];
        }
    }

    public static function isAuthenticatedAcrossGuards(): User|Authenticatable|null
    {
        $guards = ['web', 'admin', 'nurse', 'general_staff', 'doctor', 'pharmacy_staff']; // إضافة 'pharmacy_staff'
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user(); // Return the authenticated user
            }
        }
        return null; // Return null if no authentication
    }


    public static function typeOfUser()
    {
        $user = LoginService::isAuthenticatedAcrossGuards();
        $type = Login::where('username', $user->username)->get(['type']);
        return $type[0]->type;

    }
}
