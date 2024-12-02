<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Otp;
use App\Services\Signup\OtpService;
use App\Services\Signup\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Random\RandomException;

class RegistrationController extends Controller
{
    protected OtpService $otpService;
    protected UserService $userService;

    public function __construct(OtpService $otpService, UserService $userService)
    {
        $this->otpService = $otpService;
        $this->userService = $userService;
    }

    public function showRegistrationForm(): View
    {
        $cities = City::with('districts')->get();
        return view('auth.register', compact('cities'));
    }

    /**
     * @throws RandomException
     */
    public function register(Request $request): RedirectResponse
    {
        $validatedData = $this->userService->validateUserData($request->all());
        session(['validatedData' => $validatedData]);

        $this->otpService->generateAndSendOtp($validatedData);

        session(['email' => $validatedData['email']]);
        return redirect()->route('otp.verify')->with('success', 'A verification code has been sent to your email.');
    }

    public function showOtpForm(): View
    {
        return view('auth.verify_otp');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required|digits:6']);
        $email = session('email');

        if (!$email || !$this->otpService->verifyOtp($email, $request->otp)) {
            return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $userData = json_decode(Otp::where('email', $email)->latest()->first()->data, true);
        $this->userService->registerUser($userData);

        return redirect()->intended('account_created')->with('success', 'Your account has been created successfully.');
    }

    /**
     * @throws RandomException
     */
    public function resendOtp(): RedirectResponse
    {
        $email = session('email');
        $validatedData = session('validatedData');

        $this->otpService->generateAndSendOtp($validatedData);

        return redirect()->back()->with('success', 'A new verification code has been sent to your email.');
    }
}
