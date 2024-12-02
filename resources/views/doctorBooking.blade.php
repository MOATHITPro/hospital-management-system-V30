<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Patient Name</th>
        <th>Doctor Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($appointments as $key => $appointment)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $appointment['patient']['first_name'] }} {{ $appointment['patient']['last_name'] }}</td>
            <td>{{$appointment->doctor->name}}</td> <!-- Assuming you want to dynamically add the doctor name later -->
            <td>{{ $appointment->appointment_date}}</td>
            <td>{{ $appointment->timeSlot->start_time}}</td>
            <td>{{ $appointment['status'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
