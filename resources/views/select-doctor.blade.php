<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.select_doctor') }}</title>

    <!-- اختيار ملف CSS بناءً على اللغة -->
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('css/clinic-style-ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/clinic-style.css') }}">
    @endif

    <style>
        body {
            background-image: url("{{ asset('images/backgrond.webp') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body style="direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};">
<div class="wrapper">
    <div class="main_box">
        <div class="main-header">
            <span>{{ __('messages.select_doctor') }}</span>
        </div>
        <div class="buttons-container">
            @foreach ($doctors as $doctor)
                <a href="{{ url($path . '/' . $doctor->id) }}" class="clinic-card">
                    <img src="{{ asset('images/image_dector.webp') }}" alt="Doctor">
                    <div class="card-content">
                        <h2>{{ $doctor->name }}</h2>
                        <button type="button" class="button">{{ __('messages.book_now') }}</button>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    function selectDoctor(doctorName) {
        alert(`{{ __('messages.selected_doctor') }}: ${doctorName}`);
    }
</script>
</body>

</html>
