<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.title') }}</title>

    <!-- Google Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('css/style_home_ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/style_home2.css') }}">
    @endif
    <style>
        /* Alert message styling */
        .alert {
            padding: 10px;
            margin: 15px;
            border-radius: 5px;
            font-size: 1em;
            text-align: start;
        }

        .alert-success {
            /*background-color: #d4edda;*/
            color: #fbfffc;
            border: 1px solid #404240;
        }
      .os span {
            margin-inline:50px ;
        }
    </style>
</head>
<body style="direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};">
<x-user-dropdown-menu/>
<x-popup-message/>
<!-- Main Container -->
<div class="wrapper">
    <div class="main_box">
        <div class="main-header">
            <span>{{ __('messages.main_page') }}</span>
        </div>
        <!-- @if (isset($appointmentDetails))
            <div class="alert alert-success">
                <p><span>{{ __('messages.clinic_name') }}:</span> {{ $appointmentDetails['clinic'] }}</p>
                <p class="os"><span>{{ __('messages.appointment_date') }}: {{ $appointmentDetails['appointment_date'] }}</span>
                <span>{{ __('messages.start_time') }}: {{ $appointmentDetails['start_time'] }}</span></p>
            </div>
        @endif -->
        <div class="buttons-container">
            <button class="button" onclick="goToAppointment()">{{ __('messages.book_appointment') }}</button>
            <button class="button" onclick="goToVaccine()">{{ __('messages.vaccine_booking') }}</button>
            <button class="button" onclick="goToDrugBooking()">{{ __('messages.drug_booking') }}</button>
        </div>
    </div>
</div>

<script>
    // Navigate to the Appointment Booking page
    function goToAppointment() {
        window.location.href = "{{ route('showClinic') }}";
    }

    // Navigate to the Vaccine Booking page
    function goToVaccine() {
        window.location.href = "{{ url('/vaccine/showClinic') }}";
    }

    // Navigate to the Medication Booking page
    function goToDrugBooking() {
        window.location.href = "{{ url('/medicine/showClinic') }}";
    }
</script>

<style>
    /* Background styling */
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
