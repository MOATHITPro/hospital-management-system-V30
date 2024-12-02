<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.book_appointment') }}</title>

    <!-- خطوط وأيقونات -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&display=swap'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <!-- اختيار ملف CSS بناءً على اللغة -->
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('css/style_appointment_ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/style_appointment.css') }}">
    @endif

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
<x-user-dropdown-menu />
<x-popup-message />

<!-- زر الرجوع للصفحة الرئيسية -->
<button class="return-button" onclick="goToHome()">
    <i class="fas fa-home"></i>
</button>

<div class="wrapper">
    <div class="main_box">
        <!-- عنوان الصفحة -->
        <div class="main-header">
            <span>{{ __('messages.book_appointment') }}</span>
        </div>

        <!-- النص الترحيبي -->
        <div class="welcome-text">
            <p>{{ __('messages.select_primary_symptom') }}</p>
        </div>

        <!-- نموذج الحجز -->
        <form id="appointment-form" method="POST" action="{{ route('appointment.store') }}" onsubmit="prepareSymptoms();">
            @csrf

            <!-- اختيار العرض الأساسي -->
            <div class="dropdown-container">
                <label for="primary-symptom">{{ __('messages.primary_symptom') }}:</label>
                <select id="primary-symptom" name="primary_symptom" class="dropdown" onchange="updateSeverity();">
                    <option value="" disabled selected>{{ __('messages.select_symptom') }}</option>
                    @foreach($symptoms as $symptom)
                        <option value="{{ $symptom->name }}" data-type="{{ $symptom->is_emergency ? 'urgent' : 'normal' }}">
                            {{ $symptom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- خانات اختيار الأعراض الإضافية -->
            <div id="checkbox-container" class="checkbox-container" style="display: none;">
                <h3>{{ __('messages.additional_symptoms') }}:</h3>
                @foreach($symptoms as $symptom)
                    <div class="checkbox">
                        <input type="checkbox" id="{{ $symptom->name }}" name="additional_symptoms[]"
                               value="{{ $symptom->name }}"
                               data-type="{{ $symptom->is_emergency ? 'urgent' : 'normal' }}"
                               onchange="updateSeverity()">
                        <label for="{{ $symptom->name }}">{{ $symptom->name }}</label>
                    </div>
                @endforeach
            </div>

            <!-- زر عرض المزيد -->
            <div class="buttons-container">
                <button type="button" class="button" id="showMoreButton" onclick="showCheckboxes()">
                    {{ __('messages.add_more_symptoms') }}
                </button>
            </div>

            <input type="hidden" id="symptoms-list" name="symptoms_list">

            <!-- زر الإرسال -->
            <div class="buttons-container">
                <button class="button default" id="submitButton" type="submit">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    // النصوص الديناميكية
    const messages = {
        highSeverity: "{{ __('messages.high_severity') }}",
        mediumSeverity: "{{ __('messages.medium_severity') }}",
        lowSeverity: "{{ __('messages.low_severity') }}",
        submit: "{{ __('messages.submit') }}",
    };

    // وظيفة عرض خانات الاختيار
    function showCheckboxes() {
        const checkboxContainer = document.getElementById("checkbox-container");
        const addMoreButton = document.getElementById("showMoreButton");

        if (checkboxContainer) {
            checkboxContainer.style.display = "block"; // عرض خانات الاختيار
            if (addMoreButton) {
                addMoreButton.style.display = "none"; // إخفاء زر عرض المزيد
            }
        }
    }

    // تحديث حالة الزر بناءً على الأعراض
    function updateSeverity() {
        const submitButton = document.getElementById("submitButton");
        const primaryOption = document.getElementById("primary-symptom").selectedOptions[0];
        const selectedTypePrimary = primaryOption ? primaryOption.getAttribute('data-type') : null;

        const additionalCheckboxes = document.querySelectorAll("#checkbox-container .checkbox input:checked");
        let normalCount = 0;
        let urgentCount = 0;

        // تحقق من نوع العرض الأساسي
        if (selectedTypePrimary === 'normal') {
            normalCount += 1;
        } else if (selectedTypePrimary === 'urgent') {
            urgentCount += 1;
        }

        // تحقق من الأعراض الإضافية
        additionalCheckboxes.forEach(checkbox => {
            const type = checkbox.getAttribute('data-type');
            if (type === 'normal') {
                normalCount += 1;
            } else if (type === 'urgent') {
                urgentCount += 1;
            }
        });

        // إزالة كل الفئات السابقة
        submitButton.classList.remove('green', 'yellow', 'red', 'default');

        // تحديد اللون بناءً على عدد الأعراض
        if (urgentCount >= 1) {
            submitButton.classList.add('red');
            submitButton.textContent = messages.highSeverity; // شدة عالية
        } else if (normalCount === 1) {
            submitButton.classList.add('green');
            submitButton.textContent = messages.lowSeverity; // شدة منخفضة
        } else if (normalCount >= 2) {
            submitButton.classList.add('yellow');
            submitButton.textContent = messages.mediumSeverity; // شدة متوسطة
        } else {
            submitButton.classList.add('default');
            submitButton.textContent = messages.submit; // الحالة الافتراضية
        }
    }

    // إعداد الأعراض قبل الإرسال
    function prepareSymptoms() {
        const selectedSymptom = document.getElementById("primary-symptom").value;
        const checkboxes = document.querySelectorAll("#checkbox-container .checkbox input:checked");

        const symptoms = [];
        if (selectedSymptom) symptoms.push(selectedSymptom);
        checkboxes.forEach(checkbox => symptoms.push(checkbox.value));

        document.getElementById("symptoms-list").value = JSON.stringify(symptoms);
    }

    // الانتقال إلى الصفحة الرئيسية
    function goToHome() {
        window.location.href = "/home";
    }

    // تحديث الحالة عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function () {
        updateSeverity();
    });
</script>
</body>

</html>
