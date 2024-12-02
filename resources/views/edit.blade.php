<!-- Staff Container Styling -->
    <form action="{{ route('delete-some') }}" method="POST" id="deleteForm">
        @csrf
        @foreach($clinics as $clinic)
            <!-- Clinic Header -->
            <h2>{{ $clinic->name }}</h2>
{{--            <p>Location: {{ $clinic->city->name }}, {{ $clinic->district->name }}</p>--}}

            <!-- Doctors Section -->
            <div class="staff-container">
                <h4>Doctors</h4>
                <div class="staff-list">
                    @foreach($clinic->doctors as $doctor)
                        <div class="staff-item">
                            <input type="checkbox" name="doctor_ids[]" value="{{ $doctor->id }}" id="doctor{{ $doctor->id }}">
                            <label for="doctor{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialty }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Nurses Section -->
            <div class="staff-container">
                <h4>Nurses</h4>
                <div class="staff-list">
                    @foreach($clinic->nurses as $nurse)
                        <div class="staff-item">
                            <input type="checkbox" name="nurse_ids[]" value="{{ $nurse->id }}" id="nurse{{ $nurse->id }}">
                            <label for="nurse{{ $nurse->id }}">{{ $nurse->name }} - {{ $nurse->specialty }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- General Staff Section -->
            <div class="staff-container">
                <h4>General Staff</h4>
                <div class="staff-list">
                    @foreach($clinic->general_staff as $staff)
                        <div class="staff-item">
                            <input type="checkbox" name="general_staff_ids[]" value="{{ $staff->id }}" id="staff{{ $staff->id }}">
                            <label for="staff{{ $staff->id }}">{{ $staff->name }} - {{ $staff->role }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="form-actions">
            <button type="submit" class="delete-button" onclick="return confirmDeletion()">Delete Selected</button>
            <button type="button" class="cancel-button" onclick="window.history.back()">Cancel</button>
        </div>
    </form>


<script>
    function confirmDeletion() {
        const selectedDoctors = Array.from(document.querySelectorAll('input[name="doctor_ids[]"]:checked'));
        const selectedNurses = Array.from(document.querySelectorAll('input[name="nurse_ids[]"]:checked'));
        const selectedStaff = Array.from(document.querySelectorAll('input[name="general_staff_ids[]"]:checked'));

        const allSelectedIds = [...selectedDoctors, ...selectedNurses, ...selectedStaff];
        const allSelectedNames = allSelectedIds.map(checkbox => checkbox.nextElementSibling.innerText);

        if (allSelectedIds.length > 0) {
            return confirm(`Are you sure you want to delete the following members:\n${allSelectedNames.join('\n')}?`);
        } else {
            alert("No staff members selected for deletion.");
            return false;
        }
    }
</script>
