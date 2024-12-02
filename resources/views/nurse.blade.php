<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Table</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
{{--    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap'>--}}
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
            --second-color: #ffffff;
            --black-color: #000000;
            --table-header-bg: #444;
            --secondary-color: #fff;
            --table-row-bg: #f9f9f9;
            --table-text-color: #333;
            --table-row-hover-bg: #e0e0e0;
            --header-bg-color: #eeeeee;
            --header-shadow: rgba(0, 0, 0, 0.15);
        }

        body {
            background-image: url("{{asset('images/backgrond.webp')}}");
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
        }

        .custom-login-box {
            position: relative;
            width: 70vw;
            max-width: 800px;
            backdrop-filter: blur(25px);
            border: 2px solid var(--primary-color);
            border-radius: 15px;
            padding: 10vh 3vw 5vh 3vw;
            color: var(--second-color);
            box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.1);
            margin-top: 30px;
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
            width: 40vw;
            max-width: 350px;
            height: 60px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 8px 10px -5px var(--header-shadow);
        }

        .custom-login-header span {
            font-size: 26px;
            color: var(--black-color);
            font-weight: bold;
        }

        /* Tables */
        .custom-table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 10px;
            font-size: 0.8rem;
        }

        .custom-table thead {
            background-color: var(--table-header-bg);
            color: var(--secondary-color);
        }

        .custom-table th,
        .custom-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .custom-table tbody tr {
            background-color: var(--table-row-bg);
            color: var(--table-text-color);
            transition: background-color 0.3s;
        }

        .custom-table tbody tr:hover {
            background-color: var(--table-row-hover-bg);
        }

        @media only screen and (max-width: 768px) {
            .custom-login-box {
                width: 90vw;
                padding: 5vh 2vw 3vh 2vw;
            }

            .custom-login-header {
                width: 80vw;
            }
        }

        @media only screen and (max-width: 576px) {
            .custom-login-box {
                padding: 5vh 1.5em 3vh 1.5em;
            }

            .custom-login-header {
                width: 90vw;
                max-width: none;
                font-size: 18px;
            }

            .custom-table,
            .custom-table thead,
            .custom-table tbody,
            .custom-table th,
            .custom-table td,
            .custom-table tr {
                display: block;
                width: 100%;
            }

            .custom-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .custom-table tr {
                margin-bottom: 20px;
            }

            .custom-table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .custom-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>
<div class="custom-wrapper">
    <x-user-dropdown-menu/>

    <div class="custom-login-box">
        <div class="custom-login-header">
            <span>Data Table</span>
        </div>
        <div class="table-container">
            <table class="custom-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Start Time</th>
                    <th>Doctor</th>
                    <th>Visit Type</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td data-label="ID">{{ $appointment['id'] }}</td>
                        <td data-label="Patient Name">{{ $appointment['patient']['first_name'] }} {{ $appointment['patient']['last_name'] }}</td>
                        <td data-label="Appointment Date">{{ $appointment['appointment_date'] }}</td>
                        <td data-label="Start Time">
                            @if(isset($appointment->timeSlot->start_time))
                                {{ $appointment->timeSlot->start_time }}
                            @endif
                        </td>
                        <td data-label="Doctor">
                            @if(isset($appointment['doctor']['name']))
                                {{ $appointment['doctor']['name'] }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td data-label="Visit Type">{{$appointment['type']}}</td>
                        <td data-label="Status">{{ $appointment['status'] }}</td>
                        <td data-label="Notes">
                            @if(isset($appointment['notes']) && $appointment['notes'] !== null)
                                {{ $appointment['notes'] }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</body>
</html>
