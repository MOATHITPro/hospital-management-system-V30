<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>
    <!-- Link to Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="{{ asset('css/style_created.css') }}">
</head>

<body>
<x-user-dropdown-menu/>


<div class="wrapper">
    <div class="login_box">
        <div class="login-header">
            <span>Booking Created</span>
        </div>
        <!-- Icon Section using Google Material Icons -->
{{--        <span class="material-icons icon">check_circle</span>--}}
        <!-- Message Section -->
        <p class="message">Your booking has been created successfully!</p>
        <!-- Button -->
        <button class="input-submit" onclick="redirectToLogin()">Home</button>
    </div>
</div>

<script>
    function redirectToLogin() {
        window.location.href = "{{ route('home') }}"; // Change this URL to your actual login page
    }
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
