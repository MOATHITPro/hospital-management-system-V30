<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('css/vcc_style.css') }}">
    <style>
        body {
            background-image: url({{asset('images/backgrond.webp')}});
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <x-home />
    <div class="visit_details_box">
        <div class="visit-header">
            <span>
                Previous Visit Details
            </span>
        </div>
    @foreach($visitData as $visit)
            <div class="details-container">
                <div class="visit-card">
                    <div class="card-header">Visit Information</div>
                    <div class="card-body">
                        <div class="visit-info">
                            <div class="visit-row">
                                <strong>Visit ID:</strong> <span>{{ $visit['id'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Appointment Date:</strong> <span>{{ $visit['appointment_date'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Status:</strong> <span>{{ $visit['status'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Visit Type:</strong> <span>{{ $visit['type'] }}</span>
                            </div>
                        </div>

                        <div class="doctor-info">
                            <div class="visit-row">
                                <strong>Doctor's Name:</strong> <span>{{ $visit['doctor']['name'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Specialty:</strong> <span>{{ $visit['doctor']['specialty'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Experience:</strong> <span>{{ $visit['doctor']['experience'] }} years</span>
                            </div>
                        </div>

                        <div class="clinic-info">
                            <div class="visit-row">
                                <strong>Clinic Name:</strong> <span>{{ $visit['doctor']['clinic']['name'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Clinic Address:</strong> <span>{{ $visit['doctor']['clinic']['address'] }}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Clinic Phone:</strong> <span>{{ $visit['doctor']['clinic']['phone'] }}</span>
                            </div>
                        </div>

                        <div class="time-info">
                            <div class="visit-row">
                                <strong>Appointment Time:</strong> <span>{{ $visit->start_time }} - {{ $visit->end_time}}</span>
                            </div>
                            <div class="visit-row">
                                <strong>Duration:</strong> <span>{{ $visit['duration'] }} minutes</span>
                            </div>
                        </div>
                    </div>
                </div>
    @endforeach
            </div>
    </div>
</div>
</body>

</html>
