<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MidicationPharmacyController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PharmacyStaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccineController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AppointmentController;

// Route for the main page showing the login form
Route::get('/', function () {
    return redirect()->route('login');
//    return view('auth.login'); // Show the login page
});

// Routes for user authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // Show login form
Route::post('/login', [LoginController::class, 'login'])->name('login.post'); // Process login
Route::get('/logout', [LoginController::class, 'logout'])->name('logout'); // Logout route

// Routes accessible without login
Route::get('/otp', function () {
    return view('auth.otp'); // Show OTP page
})->name('otp');

Route::get('/emergency', function () {
    return view('emergency'); // Show emergency page
})->name('emergency');

Route::get('/dispense_medications', function () {
    return view('dispense_medications'); // Show dispense medications page
})->name('dispense_medications');

Route::get('/change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) { // Validate supported languages
        session(['locale' => $lang]);   // Store language in session
    }
    return redirect()->back();         // Redirect to the previous page
})->name('change-language');


Route::get("/ZPI",fn()=>view("AR.home"));
// Group of routes that require authentication
Route::middleware('language')->group(function () {

    Route::get('/home',[UserController::class , 'showHomePage'])->name('home'); // Name the route for easier referencing
    Route::post("/bookslot",[AppointmentController::class,'bookSlot'])->name('book.slot');
    Route::get('/showTimes', [AppointmentController::class, 'showTimeChoose'])->name('showTimes');

    Route::get('/book-appointment', [AppointmentController::class, 'showBookingForm']); // Show booking form
    Route::post('/book-appointment', [AppointmentController::class, 'storePatientSymptoms'])->name('appointment.store');
    Route::get('/cancel-appointment', [AppointmentController::class, 'cancelAppointment'])->name('cancel.appointment');
    Route::get("/showClinic", [AppointmentController::class , 'showClinic'])->name('showClinic');
    Route::get("/showDoctor/{clinicId}", [AppointmentController::class , 'showDoctor'])->name('showDoctor');
    Route::get('/save-doctor/{doctor_id}', [AppointmentController::class, 'saveDoctor']);

    Route::prefix('vaccine')->group(function () {
        Route::post("/bookslot",[VaccineController::class,'bookSlot']);
        Route::get('/showTimes', [VaccineController::class, 'showTimeChoose']);
        Route::get('/book-appointment', [VaccineController::class, 'showBookingForm']); // Show booking form
        Route::get('/cancel-appointment', [VaccineController::class, 'cancelAppointment']);
        Route::get("/showClinic", [VaccineController::class , 'showClinic']);
        Route::get("/showDoctor/{clinicId}", [VaccineController::class , 'showDoctor']);
        Route::get('/save-doctor/{doctor_id}', [VaccineController::class, 'saveDoctor']);

    });
    Route::prefix('medicine')->group(function () {
        Route::post("/bookslot",[MedicationController::class,'bookSlot']);
        Route::get('/showTimes', [VaccineController::class, 'showTimeChoose']);
        Route::get('/book-appointment', [MedicationController::class, 'showBookingForm']); // Show booking form
        Route::get('/cancel-appointment', [MedicationController::class, 'cancelAppointment']);
        Route::get("/showClinic", [MedicationController::class , 'showClinic']);
        Route::get("/showDoctor/{clinicId}", [MedicationController::class , 'showDoctor']);
        Route::get('/save-doctor/{doctor_id}', [MedicationController::class, 'saveDoctor']);

    });





});
Route::get("checkAppointment",[VaccineController::class,'checkAppointment']);
Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin');
    Route::get("/showClinicDetails/{clinic_id}/{page}", [AdminController::class, 'clinicDetails']);
    Route::post('/add-clinic', [AdminController::class, 'addClinic'])->name('add-clinic');
    Route::get("/deleteClinic/{clinicID}", [AdminController::class, 'deleteClinic'])->name('deleteClinic');
    Route::post('/add-admin', [AdminController::class, 'addAdmin'])->name('add-admin');
    Route::post("/add-nurse", [AdminController::class, 'addNurse'])->name('add-nurse');
    Route::post("/add-staff", [AdminController::class, 'addGeneralStaff'])->name('add-staff');
    Route::post('/add-doctor', [AdminController::class, 'addDoctor'])->name('add-doctor');
    Route::get("/showDoctorDetails", [AdminController::class, 'showDoctor']);
    Route::get("/doctorBooking/{doctor_id}", [AdminController::class, 'DoctorBooking'])->name('doctorBooking');
    Route::post("/deleteSomething", [AdminController::class, 'deleteSome'])->name('deleteSomething');

});

Route::get("/records", [AdminController::class, 'Records']);

Route::group(['middleware' => ['auth:admin']], function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin');


    // Clinic-related Routes
    Route::prefix('clinic')->group(function () {
        Route::post('/add', [AdminController::class, 'addClinic'])->name('clinic/add');
        Route::get('/{clinic_id}/details/{page?}', [AdminController::class, 'ClinicDetails'])->name('clinic.details')
            ->where('clinic_id', '[0-9]+'); // Ensure clinic_id is numeric
        Route::get('/{clinicID}/delete', [AdminController::class, 'deleteClinic'])->name('deleteClinic')
            ->where('clinicID', '[0-9]+'); // Ensure clinicID is numeric
    });



    // Doctor-related Routes
    Route::prefix('doctor')->group(function () {
        Route::post('/add', [AdminController::class, 'addDoctor'])->name('doctor/add');
        Route::get('/details/{type}', [AdminController::class, 'showDoctor'])->name('doctor.details');
        Route::get('/{doctor_id}/booking', [AdminController::class, 'DoctorBooking'])->name('doctorBooking')
            ->where('doctor_id', '[0-9]+'); // Ensure doctor_id is numeric
        Route::get('/change-clinic', [AdminController::class, 'changeDoctorClinic'])->name('changeDoctorClinic');
    });

    // Other staff and management routes
    Route::post('/add-admin', [AdminController::class, 'addAdmin'])->name('add-admin');
    Route::post('/add-nurse', [AdminController::class, 'addNurse'])->name('add-nurse');
    Route::post('/add-staff', [AdminController::class, 'addGeneralStaff'])->name('add-staff');

    // Bulk delete route
    Route::post('/delete-some', [AdminController::class, 'deleteSome'])->name('delete-some');

    Route::get("report/{clinicId}", [AdminController::class , "generateReports"]);
});
Route::get("check",[AppointmentController::class , "checkAppointment"]);
Route::get('/user/edit', [UserController::class, 'editUser'])->name('user.edit');

// Route to handle the form submission
Route::put('/user/update', [UserController::class, 'updateUser'])->name('user.update');

Route::get('/user/previous-visits',[UserController::class,'showHistory']);

Route::get("lastDate/{clinicId}" , [AdminController::class , "getEndDate"]);


Route::group(['middleware' => ['auth:doctor']], function () {
    Route::get("/appointments/", [DoctorController::class, 'showPatient']);
    Route::post('/appointment/{appointmentId}/transfer-pharmacy', [DoctorController::class, 'transferToPharmacy']);
    Route::get('/appointment/{appointmentId}/show-transfer-pharmacy', [DoctorController::class, 'showTransferToPharmacy']);
    Route::get('/appointment/{appointmentId}/finish', [DoctorController::class, 'finish']);

    // Added route for showAppointments
    Route::get('/appointment/{appointmentId}/show-appointment', [DoctorController::class, 'showAppointment']);
    Route::get("/medicationsDoctor",[DoctorController::class,'Medication']);





});


Route::group(['middleware' => ['auth:nurse']], function () {
    Route::get("/nurse", [NurseController::class, 'showPatient']);
    Route::get('/appointment/{appointmentId}/finish', [DoctorController::class, 'finish']);

});

Route::group(['middleware' => ['auth:general_staff']], function () {
    Route::get("/staff",[NurseController::class,'showPatient'])->name("staff");
});

Route::get('/account_created',function(){return view("AccountCreated");})->name('account_created');



Route::get('register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegistrationController::class, 'register']);

Route::get('otp/verify', [RegistrationController::class, 'showOtpForm'])->name('otp.verify');
Route::post('otp/verify', [RegistrationController::class, 'verifyOtp']);

Route::post('otp/resend', [RegistrationController::class, 'resendOtp'])->name('otp.resend');



Route::get("/success",function(){return view("test");})->name('success');



Route::prefix('pharmacy')->middleware('auth:pharmacy_staff')->group(function () {
    Route::get('/dashboard', [PharmacyStaffController::class, 'index'])->name('pharmacy.dashboard');
    Route::get('/appointments/{appointment}/details', [PharmacyStaffController::class, 'viewAppointmentDetails'])->name('pharmacy.viewAppointmentDetails');
    Route::put('/appointments/{appointment}/complete', [PharmacyStaffController::class, 'completeAppointment'])->name('pharmacy.completeAppointment');
    Route::post('/medications/add', [MidicationPharmacyController::class, 'addMedication']);
    Route::post('/medication/{id}/update', [MidicationPharmacyController::class, 'updateMedication'])->name('medication.update');
    Route::get('/medication/{id}/delete', [MidicationPharmacyController::class, 'deleteMedication'])->name('medication.delete');
    Route::get('/appointments/{appointmentId}/cancel', [PharmacyStaffController::class, 'cancel']);
    Route::get('/appointments/{appointmentId}/finish', [PharmacyStaffController::class, 'done']);

});









