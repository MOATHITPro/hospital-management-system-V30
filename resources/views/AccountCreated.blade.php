<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>
    <!-- Link to Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="{{ asset('css/style_created.css') }}">
</head>

<body>
<x-popup-message/>

    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <span>Account Created</span>
            </div>
            <!-- Icon Section using Google Material Icons -->
            <span class="material-icons icon">check_circle</span>
            <!-- Message Section -->
            <p class="message">Your account has been created successfully!</p>
            <p class="description">You can now log in to your account by clicking the button below.</p>
            <!-- Button -->
            <button class="input-submit" onclick="redirectToLogin()">Log In</button>
        </div>
    </div>

    <script>
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}"; // Change this URL to your actual login page
        }
        setTimeout(redirectToLogin, 5000);
    </script>
    <style>
         body {
      background-image: url("{{ asset('images/backgrond.webp') }}");
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    </style>
</body>

</html>
