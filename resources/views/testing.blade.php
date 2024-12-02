<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Information</title>

    <!-- استيراد التنسيقات العامة للموقع -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <div class="main_box">
        <div class="main-header">
            <span>Update User Information</span>
        </div>
        <!-- عرض رسالة النجاح أو الخطأ -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('user.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- حقول الإدخال للبيانات الأساسية -->
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                @error('first_name')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required disabled>
                @error('username')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- حقل إدخال كلمة المرور -->
            <div class="form-group">
                <label for="password">Password (Leave blank to keep current)</label>
                <input type="password" id="password" name="password">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="text" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" required>
                @error('date_of_birth')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="id_number">ID Number</label>
                <input type="text" id="id_number" name="id_number" value="{{ old('id_number', $user->id_number) }}" required>
                @error('id_number')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- القائمة المنسدلة للمدينة -->
            <div class="form-group">
                <label for="city_id">City</label>
                <select id="city_id" name="city_id" required>
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- القائمة المنسدلة للمنطقة -->
            <div class="form-group">
                <label for="district_id">District</label>
                <select id="district_id" name="district_id" required>
                    <option value="">Select District</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ $user->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                @error('district_id')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- زر الإرسال -->
            <button type="submit" class="submit-button">Update</button>
        </form>
    </div>
</div>

<script>
    flatpickr("#date_of_birth", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });
</script>

<!-- تنسيقات CSS داخلية -->
<style>
    body {
        background-image: url("{{ asset('images/backgrond.webp') }}");
        /* تأكد من مسار الصورة الصحيح */
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .update-user-form {
        display: flex;
        flex-direction: column;
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
        color: #333;
    }

    input, select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 5px;
    }

    .submit-button {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #3490dc;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-button:hover {
        background-color: #2879bd;
    }

    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
        text-align: center;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .error {
        font-size: 14px;
        color: #e3342f;
        margin-top: 5px;
    }
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
    }


    .wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: rgba(0, 0, 0, 0.2);
        padding: 50px;
    }

    .main_box {
        position: relative;
        width: 900px;
        height: auto;
        backdrop-filter: blur(25px);
        border: 2px solid var(--primary-color);
        border-radius: 15px;
        padding: 7.5em 2.5em 4em 2.5em;
        color: var(--second-color);
        box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.2);
        text-align: center;
        margin-top: 50px;
    }

    .main-header {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-color);
        width: 250px;
        height: 70px;
        border-radius: 0 0 20px 20px;
    }

    .main-header span {
        font-size: 30px;
        color: var(--black-color);
    }

    .main-header::before,
    .main-header::after {
        content: "";
        position: absolute;
        top: 0;
        width: 30px;
        height: 30px;
        background: transparent;
    }

    .main-header::before {
        left: -30px;
        border-top-right-radius: 50%;
        box-shadow: 15px 0 0 0 var(--primary-color);
    }

    .main-header::after {
        right: -30px;
        border-top-left-radius: 50%;
        box-shadow: -15px 0 0 0 var(--primary-color);
    }

    .button {
        background-color: #ececec;
        color: var(--black-color);
        padding: 20px;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        width: 100%;
        /* جعل الأزرار تملأ العرض بالكامل */
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: var(--second-color);
        color: var(--black-color);
    }

    .buttons-container {
        display: grid;
        grid-template-columns: 1fr;
        /* كل زر يأخذ عرض العمود بالكامل */
        gap: 20px;
        /* مسافة بين الأزرار */
        padding-top: 30px;
    }

    @media only screen and (max-width: 564px) {
        .wrapper {
            padding: 20px;
        }

        .main_box {
            padding: 7.5em 1.5em 4em 1.5em;
        }

        .buttons-container {
            grid-template-columns: 1fr;
            /* يبقى كل زر يأخذ عرض كامل في الشاشات الصغيرة */
        }
    }

</style>

</body>
</html>
