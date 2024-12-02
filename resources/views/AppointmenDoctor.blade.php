<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment Actions</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>
    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        :root {
            --primary-color: #c6c3c3;
            --secondary-color: #ffffff;
            --black-color: #000000;
            --end-button-color: #ff6b6b;
            --pharmacy-button-color: #4da6ff;
            --end-button-hover: #ff4c4c;
            --pharmacy-button-hover: #338fff;
            --header-bg-color: #eeeeee;
            --header-shadow: rgba(0, 0, 0, 0.15);
            --card-bg: rgba(255, 255, 255, 0.1);
            --card-border: rgba(255, 255, 255, 0.3);
        }

        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .custom-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .custom-login-box {
            position: relative;
            width: 60vw;
            max-width: 400px;
            padding: 8vh 2vw 4vh 2vw;
            backdrop-filter: blur(20px);
            border: 1.5px solid var(--primary-color);
            border-radius: 12px;
            box-shadow: 0px 0px 15px 4px rgba(0, 0, 0, 0.2);
            background-color: var(--card-bg);
            color: var(--secondary-color);
            text-align: center;
        }

        .custom-login-header {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            width: 35vw;
            max-width: 280px;
            height: 50px;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 6px 8px -4px var(--header-shadow);
        }

        .custom-login-header span {
            font-size: 20px;
            color: var(--black-color);
            font-weight: bold;
        }

        /* Patient Information */
        .patient-info {
            text-align: left;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            line-height: 1.5;
        }

        .patient-info h3 {
            font-size: 1.1rem;
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .patient-info .info-row {
            display: flex;
            align-items: center;
            margin: 6px 0;
            font-size: 0.9rem;
        }

        .patient-info .info-row i {
            margin-right: 8px;
            color: #ffd700;
        }

        .patient-info .info-row strong {
            margin-right: 5px;
            color: var(--secondary-color);
        }

        /* Buttons */
        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
        }

        .action-btn {
            color: white;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 0.9rem;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* End Appointment Button */
        .end-btn {
            background: linear-gradient(135deg, var(--end-button-color), #ff9b9b);
        }

        .end-btn:hover {
            background: linear-gradient(135deg, var(--end-button-hover), #ff8c8c);
            transform: scale(1.05);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        /* Transfer to Pharmacy Button */
        .pharmacy-btn {
            background: linear-gradient(135deg, var(--pharmacy-button-color), #7abfff);
        }

        .pharmacy-btn:hover {
            background: linear-gradient(135deg, var(--pharmacy-button-hover), #5ca9ff);
            transform: scale(1.05);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .action-btn:active {
            transform: scale(1.02);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        @media only screen and (max-width: 768px) {
            .custom-login-box {
                width: 85vw;
                padding: 4vh 2vw 3vh 2vw;
            }

            .custom-login-header {
                width: 75vw;
            }
        }
    </style>
</head>

<body>
<div class="custom-wrapper">
    <div class="custom-login-box">
        <div class="custom-login-header">
            <span>Appointment Actions</span>
        </div>

        <!-- Patient Information Section -->
        <div class="patient-info">
            <h3>Patient Details</h3>
            <div class="info-row"><i class="fas fa-user"></i> <strong>Name:</strong> {{ $appointment->patient->first_name}} {{ $appointment->patient->last_name }}</div>
            <div class="info-row"><i class="fas fa-birthday-cake"></i> <strong>Age:</strong> {{ $appointment->patient->age }}</div>
            <div class="info-row"><i class="fas fa-notes-medical"></i> <strong>Type:</strong> {{ ucfirst($appointment->type) }}</div>
            <div class="info-row"><i class="fas fa-sticky-note"></i> <strong>Notes:</strong> {{ $appointment->notes }}</div>
            @if($appointment->patient->symptoms)
            <div class="info-row"><i class="fas fa-syringe"></i> <strong>Symptoms:</strong> {{ implode(', ', json_decode($appointment->patient->symptoms, true)) }}</div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="actions">
            <form action="/appointment/{{$appointment['id']}}/finish" method="get">
            <button class="action-btn end-btn">
                <i class="fas fa-check-circle"></i> End Appointment
            </button>
            </form>
            <form action="/appointment/{{$appointment['id']}}/show-transfer-pharmacy" method="get">
            <button class="action-btn pharmacy-btn" >
                <i class="fas fa-pills"></i> Transfer to Pharmacy
            </button>
            </form>
        </div>
    </div>
</div>

</body>

</html>
