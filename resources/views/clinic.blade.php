<!-- Clinic Staff Overview Section -->

    <!-- Loop through each clinic -->
    @foreach ($clinics as $clinic)
        <h2>{{ $clinic['name'] }}</h2>
        <div class="clinic-overview-info-section">
            <!-- City -->
            <div class="clinic-overview-info-card">
                <i class="fas fa-map-marker-alt"></i>
                <div class="clinic-overview-info-text">City: <span>{{ $clinic['city']['name'] }}</span></div>
            </div>

            <!-- District -->
            <div class="clinic-overview-info-card">
                <i class="fas fa-building"></i>
                <div class="clinic-overview-info-text">District: <span>{{ $clinic['district']['name'] }}</span></div>
            </div>

            <!-- Placeholder for Appointments -->
            <div class="clinic-overview-info-card">
                <i class="fas fa-calendar-check"></i>
                <div class="clinic-overview-info-text">Appointments: <span>{{$counts}}</span></div> <!-- Adjust as needed -->
            </div>
        </div>

        <!-- Doctors Section -->
        <div class="clinic-overview-staff-section">
            <div class="clinic-overview-section-title">Doctors</div>
            @foreach($clinic['doctors'] as $doctor)
                <div class="clinic-overview-staff-item doctor">
                    <span>{{ $doctor['name'] }} - {{ $doctor['specialty'] }}</span>
                </div>
            @endforeach
        </div>

        <!-- Nurses Section -->
        <div class="clinic-overview-staff-section">
            <div class="clinic-overview-section-title">Nurses</div>
            @foreach($clinic['nurses'] as $nurse)
                <div class="clinic-overview-staff-item nurse">
                    <span>{{ $nurse['name'] }} - {{ $nurse['specialty'] }}</span>
                </div>
            @endforeach
        </div>

        <!-- General Staff Section -->
        <div class="clinic-overview-staff-section">
            <div class="clinic-overview-section-title">General Staff</div>
            @foreach($clinic['general_staff'] as $staff)
                <div class="clinic-overview-staff-item general-staff">
                    <span>{{ $staff['name'] }} - {{ $staff['role'] }}</span>
                </div>
            @endforeach
        </div>

    @endforeach
