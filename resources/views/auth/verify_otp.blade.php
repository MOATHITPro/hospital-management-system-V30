<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>


    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/style_otp.css') }}">

    <!-- Custom Styles -->
    <style>
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }
        .wrapper {
            /* Your wrapper styles */
        }
        .login_box {
            /* Your login box styles */
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-msg {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
        .btn-link {
            background: none;
            border: none;
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
            font-size: 1em;
            padding: 0;
            margin-top: 10px;
        }
        .btn-link:disabled {
            color: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<x-popup-message/>

<div class="wrapper">
    <div class="login_box">
        <div class="login-header">
            <h1>Verify OTP</h1>
        </div>

        <!-- Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @elseif (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-container">
            <p>We’ve sent a verification code to your email. Please enter it below:</p>

            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf

                <!-- Hidden email field -->
                <input type="hidden" name="email" value="{{ session('email') }}">

                <div class="input_box">
                    <input type="text" name="otp" class="input-field" maxlength="6" required>
                    <label class="label">OTP</label>
                    <i class="bx bx-lock icon"></i>
                    @error('otp')
                    <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="input-submit">Verify OTP</button>
            </form>

{{--            @php--}}
{{--                // حساب الوقت المتبقي قبل السماح بإعادة إرسال OTP--}}
{{--                $lastOtp = \App\Models\Otp::where('email', session('email'))->latest()->first();--}}
{{--                $secondsRemaining = 0;--}}
{{--                if ($lastOtp) {--}}
{{--                    // استخدم 'timezone' لضمان توافق الوقت--}}
{{--                    $createdAt = \Carbon\Carbon::parse($lastOtp->created_at)->timezone(config('app.timezone'));--}}
{{--                    $now = \Carbon\Carbon::now()->timezone(config('app.timezone'));--}}
{{--                    $secondsRemaining = 60 - $now->diffInSeconds($createdAt);--}}
{{--                    if ($secondsRemaining < 0) {--}}
{{--                        $secondsRemaining = 0; // تأكد من عدم ظهور أوقات سلبية--}}
{{--                    }--}}
{{--                }--}}
{{--            @endphp--}}

{{--            @if ($secondsRemaining > 0)--}}
{{--                <!-- عرض الرسالة إذا كانت هناك فترة انتظار -->--}}
{{--                <p class="mt-3 text-danger">Please wait {{ $secondsRemaining }} seconds before requesting a new OTP.</p>--}}
{{--                <!-- تعطيل زر Resend OTP -->--}}
{{--                <button class="btn-link" disabled>Resend OTP</button>--}}
{{--            @else--}}
{{--                <!-- السماح بإعادة إرسال OTP إذا لم تكن هناك فترة انتظار -->--}}
                <form method="POST" action="{{ route('otp.resend') }}">
                    @csrf
                    <button type="submit" class="btn-link">Resend OTP</button>
                </form>
{{--            @endif--}}

        </div>
    </div>
</div>

<!-- Include any additional scripts if necessary -->
</body>
</html>
