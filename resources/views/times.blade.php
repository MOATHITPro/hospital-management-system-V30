<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.book_appointment') }}</title>

    <!-- تضمين Flatpickr للواجهة التاريخية -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset(app()->getLocale() === 'ar' ? 'css/style_time_ar.css' : 'css/style_time22.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body style="direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};">
<x-home />
<x-user-dropdown-menu />

<div class="wrapper">
    <div class="calendar_box">
        <div class="calendar-header">
            <h2>{{ __('messages.select_date_time') }}</h2>
        </div>
        <div id="calendar" class="flatpickr-inline"></div>
        <div id="times-container">
            <p id="instruction">{{ __('messages.select_date_instruction') }}</p>
            <div id="times-list"></div>
        </div>
        <div class="book-btn">
            <button id="book-now" disabled onclick="submitBooking()"><span>🕒</span> {{ __('messages.book_now') }}</button>
        </div>
    </div>
</div>

<form id="booking-form" method="POST" action="{{ url($path) }}">
    @csrf
    <input type="hidden" name="time_slot" id="time_slot_input" value="">
    <input type="hidden" name="appointment_date" id="appointment_date_input" value="">
</form>

<script>
    // إعداد البيانات
    const availableTimes = @json($availableTimes) ?? {};
    const enabledDates = Object.keys(availableTimes);

    let selectedDate = null;
    let selectedTime = null;

    // تهيئة التقويم
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#calendar", {
            altInput: true,
            altFormat: "{{ app()->getLocale() === 'ar' ? 'F j, Y' : 'F j, Y' }}",
            dateFormat: "Y-m-d",
            inline: true,
            minDate: "today",
            locale: "{{ app()->getLocale() }}",
            enable: enabledDates, // التواريخ المفعّلة فقط
            onChange: function (selectedDates, dateStr) {
                selectedDate = dateStr;
                displayAvailableTimes(dateStr);
            },
        });
    });

    function displayAvailableTimes(date) {
        const timesList = document.getElementById('times-list');
        const instruction = document.getElementById('instruction');
        timesList.innerHTML = '';
        selectedTime = null;
        document.getElementById('book-now').disabled = true;

        if (availableTimes[date] && availableTimes[date].slots.length > 0) {
            instruction.textContent = "{{ __('messages.select_preferred_time') }}";

            availableTimes[date].slots.forEach(slot => {
                const timeElement = document.createElement('button');
                timeElement.className = 'time-slot';
                timeElement.innerText = formatTime(slot.start_time);
                timeElement.setAttribute('type', 'button');

                timeElement.addEventListener('click', function () {
                    clearSelectedSlots();
                    timeElement.classList.add('selected');
                    selectedTime = slot.start_time;
                    selectTimeSlot(date, slot.id);
                });

                timesList.appendChild(timeElement);
            });
        } else {
            instruction.textContent = "{{ __('messages.no_available_times') }}";
        }
    }

    function formatTime(timeString) {
        const [hour, minute] = timeString.split(':');
        const hourInt = parseInt(hour, 10);
        const amPm = hourInt >= 12 ? 'PM' : 'AM';
        const formattedHour = hourInt % 12 || 12;
        return `${formattedHour}:${minute} ${amPm}`;
    }

    function selectTimeSlot(date, timeSlotId) {
        document.getElementById('time_slot_input').value = timeSlotId;
        document.getElementById('appointment_date_input').value = date;
        document.getElementById('book-now').disabled = false;
    }

    function submitBooking() {
        if (selectedDate && selectedTime) {
            const confirmationMessage = `{{ __('messages.confirm_booking') }} ${selectedDate} {{ __('messages.at') }} ${selectedTime}`;
            if (confirm(confirmationMessage)) {
                document.getElementById('booking-form').submit();
            }
        } else {
            alert("{{ __('messages.select_date_time_error') }}");
        }
    }

    function clearSelectedSlots() {
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
    }
</script>
</body>

</html>
