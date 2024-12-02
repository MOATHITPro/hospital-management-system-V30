<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&display=swap'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style_appointment.css') }}">
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
<body>
<x-popup-message/>


<button class="return-button" onclick="goToHome()">
    <i class="fas fa-home"></i>
</button>

<div class="wrapper">
    <div class="main_box">
        <div class="main-header">
            <span>Book an Appointment</span>
        </div>

        <div class="welcome-text">
            <p>Select your primary symptom from the dropdown. You can add more symptoms using the checkboxes below.</p>
        </div>

        <form id="appointment-form" method="POST" action="{{ route('appointment.store') }}" onsubmit="prepareSymptoms();">
            @csrf

            <div class="dropdown-container">
                <label for="primary-symptom">Primary Symptom:</label>
                <select id="primary-symptom" name="primary_symptom" class="dropdown" onchange="updateCheckboxes()">
                    <option value="" disabled selected>Select Symptom</option>
                    @foreach($symptoms as $symptom)
                        @if($symptom->is_emergency == 1)
                            <option value="{{ $symptom->name }}" data-type="urgent">
                                {{ $symptom->name }}
                            </option>
                        @else
                            <option value="{{ $symptom->name }}" data-type="normal">
                                {{ $symptom->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div id="checkbox-container" class="checkbox-container" style="display: none;">
                <h3>Additional Symptoms:</h3>
                @foreach($symptoms as $symptom)
                    <div class="checkbox">
                        <input type="checkbox" id="{{ $symptom->name }}" name="additional_symptoms[]"
                               value="{{ $symptom->name }}" data-type="{{ $symptom->severity }}" onchange="updateSeverity()">
                        <label for="{{ $symptom->name }}">{{ $symptom->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="buttons-container">
                <button type="button" class="button" id="addMoreSymptomsButton" onclick="showCheckboxes()">Add More Symptoms</button>
            </div>

            <input type="hidden" id="symptoms-list" name="symptoms_list">

            <div class="buttons-container">
                <button class="button" id="submitButton" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show additional symptoms checkboxes
    function showCheckboxes() {
        document.getElementById("checkbox-container").style.display = "block";
        document.getElementById("addMoreSymptomsButton").style.display = "none";
    }

    // Update checkbox visibility based on selected primary symptom
    function updateCheckboxes() {
        const selectedSymptom = document.getElementById("primary-symptom").value;
        const checkboxes = document.querySelectorAll("#checkbox-container .checkbox input");

        checkboxes.forEach(checkbox => {
            checkbox.parentElement.style.display = checkbox.value === selectedSymptom ? 'none' : 'block';
        });
    }

    // Prepare the symptoms list for submission
    function prepareSymptoms() {
        const selectedSymptom = document.getElementById("primary-symptom").value;
        const checkboxes = document.querySelectorAll("#checkbox-container .checkbox input:checked");

        const symptoms = [];
        if (selectedSymptom) symptoms.push(selectedSymptom);
        checkboxes.forEach(checkbox => symptoms.push(checkbox.value));

        document.getElementById("symptoms-list").value = JSON.stringify(symptoms);
    }

    // Navigate to home page
    function goToHome() {
        window.location.href = "/home";
    }
</script>
</body>
</html>
