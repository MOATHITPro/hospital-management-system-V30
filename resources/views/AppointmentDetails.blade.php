<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.appointment_confirmation') }}</title>

    <!-- خطوط وأيقونات -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&display=swap'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <!-- ملفات CSS -->
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('css/style_Appointment_Confirmation_ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/style_Appointment_Confirmation.css') }}">
    @endif
</head>

<body style="direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};">
<x-popup-message />
<x-user-dropdown-menu />
<x-home />

<div class="wrapper">
    <div class="appointment-box">
        <h2>{{ __('messages.appointment_details') }}</h2>
        <div class="appointment-details">
            <p><span>{{ __('messages.clinic_name') }}:</span> {{ $appointmentDetails['clinic'] }}</p>
            <p><span>{{ __('messages.doctor_name') }}:</span> {{ $appointmentDetails['doctor'] }}</p>
            <p><span>{{ __('messages.appointment_date') }}:</span> {{ $appointmentDetails['appointment_date'] }}</p>
            <p><span>{{ __('messages.start_time') }}:</span> {{ $appointmentDetails['start_time'] }}</p>

            @if(isset($appointmentDetails['symptoms']))
                <p><span>{{ __('messages.symptoms') }}:</span></p>
                <ul>
                    @foreach ($appointmentDetails['symptoms'] as $symptom)
                        <li>{{ $symptom }}</li>
                    @endforeach
                </ul>
            @endif

            
        </div>
        <div class="countdown-title">{{ __('messages.time_remaining') }}</div>
        <div class="countdown-container" id="countdown">
            <div class="countdown-item">
                <div id="days">0</div>
                <span>{{ __('messages.days') }}</span>
            </div>
            <div class="countdown-item">
                <div id="hours">0</div>
                <span>{{ __('messages.hours') }}</span>
            </div>
            <div class="countdown-item">
                <div id="minutes">0</div>
                <span>{{ __('messages.minutes') }}</span>
            </div>
            <div class="countdown-item">
                <div id="seconds">0</div>
                <span>{{ __('messages.seconds') }}</span>
            </div>
        </div>
        <button class="cancel-appointment-button" id="cancelButton">{{ __('messages.cancel_appointment') }}</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>
<script>
    function cancelAppointment() {
        Notiflix.Confirm.show(
            "{{ __('messages.cancel_appointment') }}",
            "{{ __('messages.confirm_cancel_appointment') }}",
            "{{ __('messages.yes_cancel') }}",
            "{{ __('messages.no_keep') }}",
            function okCallback() {
                window.location.href = '{{ url($path) }}';
            },
            function cancelCallback() {
                Notiflix.Notify.info("{{ __('messages.appointment_not_cancelled') }}");
            }
        );
    }

    document.getElementById("cancelButton").addEventListener("click", cancelAppointment);

    function startCountdown() {
        const appointmentDate = new Date("{{ $appointmentDetails['appointment_date'] }}T{{ $appointmentDetails['start_time'] }}");

        function updateCountdown() {
            const now = new Date();
            const timeDifference = appointmentDate - now;

            if (timeDifference <= 0) {
                document.getElementById("countdown").innerHTML = "{{ __('messages.appointment_time_arrived') }}";
                clearInterval(interval);
                return;
            }

            const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("minutes").innerHTML = minutes;
            document.getElementById("seconds").innerHTML = seconds;
        }

        const interval = setInterval(updateCountdown, 1000);
        updateCountdown();
    }

    document.addEventListener("DOMContentLoaded", startCountdown);
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
