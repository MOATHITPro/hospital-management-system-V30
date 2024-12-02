<?php

namespace App\Providers;

use App\Http\Controllers\VaccineController;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\GeneralStaff;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Observers\ModelObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Clinic::observe(ModelObserver::class);
        User::observe(ModelObserver::class);
        Doctor::observe(ModelObserver::class);
        Nurse::observe(ModelObserver::class);
        GeneralStaff::observe(ModelObserver::class);
        Appointment::observe(ModelObserver::class);
        Admin::observe(ModelObserver::class);
    }
}
