    <div class="select-doctor-buttons-container">
        @foreach($doctors as $doctor)
            <div class="select-doctor-clinic-card" onclick="selectDoctor('{{ $doctor->name }}')">
                <img src="{{ asset('images/image_dector.webp') }}" alt="Doctor {{ $doctor->name }}">
                <div class="select-doctor-card-content">
                    <h2>{{ $doctor->name }}</h2>
                    <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
                    <p><strong>Clinic:</strong> {{ $doctor->clinic->name }}</p>
                    <button class="select-doctor-button" data-clinic-id="{{ $doctor->id }}">View Reservations</button>
                </div>
            </div>
        @endforeach
    </div>
