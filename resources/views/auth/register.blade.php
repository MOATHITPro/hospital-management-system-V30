<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/style_singnup2.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Custom Styles -->
    <style>
        /* Add your custom styles here */
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }
        .wrapper {
            /* Your wrapper styles */
        }
        .login_box {
            /* Your login box styles */
        }
        /* Continue with your styles... */
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 1em;
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
<x-popup-message/>

    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <h1>Sign Up</h1>
            </div>

            <!-- Success or Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger">
                    Please fix the errors below.
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="form-container">
                @csrf

                <!-- First Name -->
                <div class="input_box">
                    <input type="text" name="first_name" class="input-field" value="{{ old('first_name') }}" required autofocus>
                    <label class="label">First Name</label>
                    <i class="bx bx-user icon"></i>
                    @error('first_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="input_box">
                    <input type="text" name="last_name" class="input-field" value="{{ old('last_name') }}" required>
                    <label class="label">Last Name</label>
                    <i class="bx bx-user icon"></i>
                    @error('last_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                <div class="input_box">
                    <input type="text" name="username" class="input-field" value="{{ old('username') }}" required>
                    <label class="label">Username</label>
                    <i class="bx bx-user icon"></i>
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input_box">
                    <input type="email" name="email" class="input-field" value="{{ old('email') }}" required>
                    <label class="label">Email</label>
                    <i class="bx bx-envelope icon"></i>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input_box">
                    <input type="password" name="password" class="input-field" required>
                    <label class="label">Password</label>
                    <i class="bx bx-lock-alt icon"></i>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="input_box">
                    <input type="password" name="password_confirmation" class="input-field" required>
                    <label class="label">Confirm Password</label>
                    <i class="bx bx-lock-alt icon"></i>
                </div>

                <!-- Date of Birth -->
                <div class="input_box">
                    <input type="text" id="dob" name="date_of_birth" class="input-field" value="{{ old('date_of_birth') }}" required>
                    <label class="label">Date of Birth</label>
                    <i class="bx bx-calendar icon"></i>
                    @error('date_of_birth')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ID Number -->
                <div class="input_box">
                    <input type="text" name="id_number" class="input-field" value="{{ old('id_number') }}" required>
                    <label class="label">ID Number</label>
                    <i class="bx bx-id-card icon"></i>
                    @error('id_number')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- City -->
                <div class="input_box">
                    <select id="city" name="city_id" class="input-field" required onchange="updateDistricts()">
                        <option value="" disabled selected>Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <i class="bx bx-map icon"></i>
                    @error('city_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- District -->
                <div class="input_box">
                    <select id="district" name="district_id" class="input-field" required>
                        <option value="" disabled selected>Select District</option>
                        <!-- District options will be populated by JavaScript -->
                    </select>
                    <i class="bx bx-map icon"></i>
                    @error('district_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="input-submit">Sign Up</button>

                <div class="register">
                    <span>Already have an account? <a href="{{ route('login') }}">Login</a></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize date picker
        flatpickr("#dob", {
            dateFormat: "Y-m-d",
            maxDate: "today",
        });

        // Get cities and districts data from the controller
        const cities = @json($cities);

        function updateDistricts() {
            const citySelect = document.getElementById("city");
            const districtSelect = document.getElementById("district");
            const selectedCityId = citySelect.value;

            districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';

            const selectedCity = cities.find(city => city.id == selectedCityId);

            if (selectedCity) {
                selectedCity.districts.forEach(function (district) {
                    const option = document.createElement("option");
                    option.value = district.id;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
            }
        }

        // Prepopulate districts if city is already selected
        window.onload = function() {
            if (document.getElementById("city").value) {
                updateDistricts();
                document.getElementById("district").value = "{{ old('district_id') }}";
            }
        };
    </script>
</body>
</html>
