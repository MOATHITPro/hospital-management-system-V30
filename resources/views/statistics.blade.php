@extends('layouts.admin')

@section('content')
    <div class="statistics-container">
        <h2>Operational Statistics</h2>
        <div>
            <p><strong>Current Appointments:</strong> {{ $currentAppointments }}</p>
            <p><strong>Pharmacy Visits:</strong> {{ $pharmacyVisits }}</p>
            <p><strong>Vaccine Visits:</strong> {{ $vaccineVisits }}</p>
            <p><strong>Doctors:</strong> {{ $doctors }}</p>
        </div>
    </div>
@endsection
