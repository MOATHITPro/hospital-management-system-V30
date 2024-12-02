<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class PharmacyAppointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'pharmacy_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'estimated_pickup_time',
        'pharmacy_notes'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function medications(): HasMany
    {
        return $this->hasMany(PharmacyOrderMedication::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('notDeleted', function (Builder $builder) {
            $builder->whereNull('deleted_at');
        });

        static::saving(function ($model) {
            $model->checkAppointmentDate();
            $model->handleSoftDelete();
            $model->checkConflict();
        });
    }

    protected function checkAppointmentDate()
    {
        $today = Carbon::today()->startOfDay();
        $appointmentDate = Carbon::parse($this->date)->startOfDay();

        if ($appointmentDate->lessThan($today)) {
            $this->delete();
        }
    }

    protected function handleSoftDelete()
    {
        if (in_array($this->status, ['Done', 'Cancelled', 'Completed'])) {
            $this->delete();
        }
    }

    protected function checkConflict()
    {
        if ($this->status === 'Pending') {
            $exists = self::where('date', $this->date)
                ->where('time', $this->time)
                ->where('doctor_id', $this->doctor_id)
                ->whereNull('deleted_at')
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'error' => 'This appointment slot is already taken for the specified status.',
                ]);
            }
        }
    }
}
