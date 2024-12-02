<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.select_clinic') }}</title>

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
            <span>{{ __('messages.select_clinic') }}</span>
        </div>
        <div class="buttons-container">
            @foreach ($clinics as $clinic)
                <div class="clinic-card" onclick="window.location.href='{{ url($path . '/' . $clinic->id) }}'">
                    <img src="{{ asset('images/image.webp') }}" alt="Clinic">
                    <div class="card-content">
                        <h2>{{ $clinic->name }}</h2>
                        <p class="clinic-location">
                            <span>{{ __('messages.city') }}: {{ $clinic->city->name }}</span> &#x2192;
                            <span>{{ __('messages.district') }}: {{ $clinic->district->name }}</span>
                        </p>
                        <button class="button">{{ __('messages.book_now') }}</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>

</html>
