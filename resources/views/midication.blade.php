<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Medications</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <script defer src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>
    <style>
        /* Basic Reset and Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #ffffff;
            --black-color: #333333;
            --highlight-bg: rgba(255, 255, 255, 0.8);
            --border-color: #e0e0e0;
            --hover-color: #f5f5f5;
        }
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .custom-box {
            position: relative;
            width: 70vw;
            max-width: 700px;
            backdrop-filter: blur(25px);
            border: 2px solid var(--primary-color);
            border-radius: 15px;
            padding: 7.5em 2.5em 4em 2.5em;
            color: var(--black-color);
            background-color: var(--highlight-bg);
            box-shadow: 0px 0px 15px 4px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .custom-header {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            width: 450px;
            max-width: 100%;
            height: 70px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 6px 8px -4px rgba(0, 0, 0, 0.2);
            color: var(--secondary-color);
        }
        .custom-header span {
            font-size: 30px;
            color: var(--black-color);
            font-weight: bold;
        }
        .search-bar {
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-size: 1rem;
            color: var(--black-color);
            margin-bottom: 15px;
        }
        .medications-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 400px;
            overflow-y: auto;
        }
        .medication-item {
            display: flex;
            flex-direction: column;
            padding: 12px;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .medication-item:hover {
            background-color: var(--hover-color);
        }
        .medication-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .medication-name {
            font-weight: bold;
            color: var(--black-color);
            flex: 1;
        }
        .medication-controls input[type="checkbox"] {
            accent-color: var(--primary-color);
            cursor: pointer;
        }
        .additional-fields {
            display: none;
            margin-top: 10px;
        }
        .additional-fields input[type="number"],
        .additional-fields input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            font-size: 0.9rem;
        }
        .submit-button {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--secondary-color);
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-button:hover {
            background-color: #45a049;
        }

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
</head>
<body>
<div class="custom-box">
    <div class="custom-header">
        <span>Select Medications</span>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <input type="text" id="searchInput" class="search-bar" placeholder="Search medications..." onkeyup="filterMedications()">
    <form action="/appointment/{{$appointmentId}}/transfer-pharmacy" method="POST" onsubmit="return validateForm()">
        @csrf
        <div class="medications-list" id="medicationsList"></div>
        <button type="submit" class="submit-button">Submit Selected Medications</button>
    </form>
</div>

<script>
    const medications = @json($medications);
    const medicationsList = document.getElementById("medicationsList");

    function renderMedications(medicationsToDisplay) {
        medicationsList.innerHTML = "";
        medicationsToDisplay.forEach(medication => {
            const medicationItem = document.createElement("div");
            medicationItem.className = "medication-item";
            medicationItem.innerHTML = `
                <div class="medication-top">
                    <span class="medication-name">${medication.name}</span>
                    <input type="checkbox" id="med-${medication.id}" name="medications[${medication.id}][selected]" value="1" onchange="toggleAdditionalFields(this)">
                    <input type="hidden" name="medications[${medication.id}][medication_id]" value="${medication.id}">
                </div>
                <div class="additional-fields" id="fields-${medication.id}">
                    <input type="number" name="medications[${medication.id}][quantity]" min="1" placeholder="Quantity">
                    <input type="text" name="medications[${medication.id}][dosage]" placeholder="Dosage">
                    <input type="text" name="medications[${medication.id}][instructions]" placeholder="Instructions">
                </div>`;
            medicationsList.appendChild(medicationItem);
        });
    }

    function toggleAdditionalFields(checkbox) {
        const fields = document.getElementById(`fields-${checkbox.id.split('-')[1]}`);
        const inputs = fields.querySelectorAll("input");
        if (checkbox.checked) {
            fields.style.display = 'block';
            inputs.forEach(input => input.required = true);
        } else {
            fields.style.display = 'none';
            inputs.forEach(input => input.required = false);
        }
    }

    function filterMedications() {
        const searchInput = document.getElementById("searchInput").value.toLowerCase();
        const filteredMedications = medications.filter(medication => medication.name.toLowerCase().includes(searchInput));
        renderMedications(filteredMedications);
    }

    function validateForm() {
        const selectedMedications = document.querySelectorAll('input[type="checkbox"]:checked');
        if (selectedMedications.length === 0) {
            Notiflix.Report.failure(
                'Error!',
                'Please select at least one medication.',
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
            return false;
        }
        return true;
    }

    renderMedications(medications);
</script>

<!-- Check for errors in session data -->
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Notiflix.Report.failure(
                'Error',
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

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Notiflix.Report.success(
                'Success!',
                '{{ session('success') }}',
                'OK',
                {
                    messageMaxLength: 400,
                    plainText: true,
                    cssAnimationStyle: 'zoom',
                    backOverlay: false,
                    success: {
                        backgroundColor: 'transparent',
                        textColor: '#333',
                    }
                }
            );
        });
    </script>
@endif

</body>
</html>
