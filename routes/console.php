<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//Artisan::command('app:check-appointments', function () {
//    Artisan::call('app:check-appointments');
//})->purpose('Check and update expired appointments')->everyFiveMinutes()->runInBackground();
