<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacyOrderMedication extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'pharmacy_appointment_id',
        'medication_id',
        'patient_quantity',
        'dosage',
        'instructions'
    ];

    public function pharmacyAppointment(): BelongsTo
    {
        return $this->belongsTo(PharmacyAppointment::class);
    }

    public function medication() :BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('notDeleted', function (Builder $builder) {
            $builder->whereNull('deleted_at');
        });
    }
}
