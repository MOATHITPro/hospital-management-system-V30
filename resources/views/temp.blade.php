<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{--    <title>Operational Report for {{ $reportDate }}</title>--}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; direction: rtl; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h1, h2, h3 { text-align: center; }
    </style>
</head>
<body>
{{--<h1>Operational Report for {{ $reportDate }}</h1>--}}

@foreach($doctors as $doctorData)
    <h2>Dr. {{ $doctorData['doctor']->name }} - {{ $doctorData['doctor']->specialty }}</h2>
    <h3>Clinic: {{ $doctorData['doctor']->clinic->name }}</h3>
    @if($doctorData['appointments']->count() > 0)
        <table>
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($doctorData['appointments'] as $appointment)
                <tr>
                    <td>{{ $appointment->patient->first_name . " " . $appointment->patient->last_name }}</td>
                    <td>
                        {{  \Carbon\Carbon::parse($appointment->appointment_date)->format("Y-m-d")}}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($appointment->timeSlot->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($appointment->timeSlot->end_time)->format('H:i') }}
                    </td>

                    <td>
                        @switch($appointment->status)
                            @case('Done')
                                Checked In and Out
                                @break
                            @case('ToPharmacy')
                                To Pharmacy
                                @break
                            @case('Completed')
                                Completed without Entry
                                @break
                            @case('Cancelled')
                                Cancelled
                                @break
                            @default
                                Unknown
                        @endswitch
                    </td>
                    <td>{{ $appointment->notes ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No appointments for this doctor on this day.</p>
    @endif
@endforeach

<h2>Appointments by Status</h2>

@foreach($statuses as $key => $statusAppointments)
    <h3>
        @switch($key)
            @case('Done')
                Appointments Completed with Doctor Visit
                @break
            @case('ToPharmacy')
                Appointments Moved to Pharmacy
                @break
            @case('Completed')
                Appointments Completed without Doctor Visit
                @break
            @case('Cancelled')
                Appointments Cancelled
                @break
            @default
                Other Cases
        @endswitch
    </h3>
    @if($statusAppointments->count() > 0)
        <table>
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Notes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($statusAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->first_name . " " . $appointment->patient->last_name }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>
                        {{  \Carbon\Carbon::parse($appointment->appointment_date)->format("Y-m-d")}}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($appointment->timeSlot->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($appointment->timeSlot->end_time)->format('H:i') }}
                    </td>
                    <td>{{ $appointment->notes ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No appointments for this status.</p>
    @endif
@endforeach
</body>
</html>
