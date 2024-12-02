<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Services\Login\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Show the login form.
     *
     */
    public function showLoginForm()
    {
        $username = $this->loginService->isAuthenticatedAcrossGuards();
        if ($username) {
            $type = Login::where('username', $username->username)->first()->type;

            $redirectRoutes = [
                'admin' => 'admin',
                'staff' => 'staff',
                'nurse' => 'nurse',
                'user' => 'home',
                'doctor' => 'appointments',
                'pharmacy_staff' => 'pharmacy/dashboard',
            ];

            return redirect('/'.$redirectRoutes[$type]);
        }
        return view('auth.login');
    }

    /**
         * Handle the login request.
         *
         * @param Request $request
         * @return RedirectResponse
         */
        function login(Request $request): RedirectResponse
        {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'password' => 'required|string',
            ], [
                'username.required' => 'Please enter your username.',
                'password.required' => 'Please enter your password.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Authenticate the user
            $credentials = $request->only('username', 'password');
            $user = $this->loginService->validateUserCredentials($credentials);

            if (!$user) {
                return redirect()->back()
                    ->withErrors(['loginError' => 'Invalid username or password. Please try again.'])
                    ->withInput();
            }

            $loginResult = $this->loginService->loginAs($user);

            // Regenerate the session for security
            $request->session()->regenerate();

            // Redirect to the appropriate page with a success message
            return redirect()->intended($loginResult['path'])->with('success', $loginResult['message']);
        }

        /**
         * Handle the logout request.
         *
         * @param Request $request
         * @return RedirectResponse
         */
        public
        function logout(Request $request): RedirectResponse
        {
            // Log the user out
            Auth::logout();

            // Invalidate and regenerate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('success', 'You have successfully logged out.');
        }
    }
