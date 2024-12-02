<?php
namespace App\Models;

use App\Traits\DetectsRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;


class Doctor extends Authenticatable
{
    use SoftDeletes,HasFactory,DetectsRelationships;


    protected $fillable = [
        'name',
        'specialty',
        'clinic_id',
        'experience',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'deleted_at',
        'created_at'
    ];


    public $timestamps = false;


    protected static function booted()
    {
        parent::boot();
        static::deleting(function ($doctor) {
            // Delete all related appointments when a doctor is deleted
            $doctor->appointments()->delete(); // This will also respect soft deletes on appointments
        });
        static::created(function ($doctor) {
            // List of working days
            if($doctor->specialty === 'Vaccination Specialist') {
                $workingDays = ['Tuesday'];

                // Work hours
                $startTime = '08:00:00';
                $endTime = '17:00:00';

                // Create slots for each working day
                foreach ($workingDays as $day) {
                    DoctorSlot::create([
                        'doctor_id' => $doctor->id,
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                }
            } elseif ($doctor->specialty === 'hospital pharmacist') {
                $workingDays = ['Thursday'];

                // Work hours
                $startTime = '08:00:00';
                $endTime = '17:00:00';

                // Create slots for each working day
                foreach ($workingDays as $day) {
                    DoctorSlot::create([
                        'doctor_id' => $doctor->id,
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                }
            }
            else {
                $workingDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];

                // Work hours
                $startTime = '08:00:00';
                $endTime = '17:00:00';

                // Create slots for each working day
                foreach ($workingDays as $day) {
                    DoctorSlot::create([
                        'doctor_id' => $doctor->id,
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                }
            }
        });
    }


    // Relationship with Clinic
    public function clinic(): BelongsTo

    {
        return $this->belongsTo(Clinic::class);
    }
    public function slots(): HasMany
    {
        return $this->hasMany(DoctorSlot::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function specialty_name(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'specialty', 'name');
    }

    public function pharmacy_appointment(): HasMany
    {
        return $this->hasMany(PharmacyAppointment::class);
    }

}




