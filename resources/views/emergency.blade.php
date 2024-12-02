<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Booking</title>

    <!-- Google Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&display=swap'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style_rug-booking.css') }}"> <!-- External CSS -->

    <style>
        /* Page and background styling */
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <x-popup-message/>
    <x-user-dropdown-menu/>


    <!-- Main Container -->
    <button class="button return-button" onclick="goToHome()">
        <i class="fas fa-home"></i>
    </button>

    <div class="wrapper">
        <div class="main_box">
            <div class="main-header">
                <span>Vaccine Booking</span>
            </div>

            <!-- Welcome Text -->
            <div class="welcome-text">
                <p>Welcome to the Vaccine Booking Service!</p>
                <p>Please proceed to book your vaccination appointment. Our team will ensure you receive the appropriate vaccine at the scheduled time.</p>
            </div>
        </div>
    </div>

    <script>
        // Navigate to the home page
        function goToHome() {
            window.location.href = "/home"; // Change this to your actual home route
        }
    </script>
</body>
</html>
