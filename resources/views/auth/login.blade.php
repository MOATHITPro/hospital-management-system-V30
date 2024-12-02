<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://fonts.googleapis.com/css2?family=Poppins&display=swap' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- External stylesheet -->
</head>
<body>
<x-popup-message/>
    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <h1>Login</h1> <!-- Login page title -->
            </div>

            <!-- Display success or error messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}"> <!-- Login route -->
                @csrf <!-- CSRF protection -->

                <!-- Username Input -->
                <div class="input_box">
                    <input type="text" name="username" id="user" class="input-field" required value="{{ old('username') }}"> <!-- Username field -->
                    <label for="user" class="label">Username</label> <!-- Username label -->
                    <i class="bx bx-user icon"></i> <!-- User icon -->

                    <!-- Error message for username -->
                    @error('username')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="input_box">
                    <input type="password" name="password" id="pass" class="input-field" required> <!-- Password field -->
                    <label for="pass" class="label">Password</label> <!-- Password label -->
                    <i class="bx bx-lock-alt icon"></i> <!-- Lock icon -->

                    <!-- Error message for password -->
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> <!-- Remember me checkbox -->
                        <label for="remember">Remember me</label>
                    </div>
                    <div class="forgot">
                        <a href="#">Forgot password?</a> <!-- Forgot password link -->
                    </div>
                </div>

                <!-- Custom error message for login issues -->
                @if($errors->has('loginError'))
                    <div class="error-msg">{{ $errors->first('loginError') }}</div>
                @endif

                <!-- Submit Button -->
                <div class="input_box">
                    <input type="submit" class="input-submit" value="Login"> <!-- Login button -->
                    <div class="register">
                        <span>Don't have an account? <a href="{{ route('register') }}">Register</a></span> <!-- Registration link -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Display error message using Notiflix Report without background color
                Notiflix.Report.failure(
                    'Error!',
                    '{{ session('error') }}',
                    'OK',
                    {
                        messageMaxLength: 400,
                        plainText: true,
                        cssAnimationStyle: 'zoom',
                        backOverlay: false,
                        failure: {
                            backgroundColor: 'transparent',
                            textColor: '#333',
                        }
                    }
                );
            });
        </script>
    @endif


    <style>
        /* Background styling */
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Error message styling */
        .error-msg {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }

        /* Alert message styling */
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 1em;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</body>
</html>
