<?php
namespace App\Models;

use App\Traits\DetectsRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use HasFactory,softDeletes,DetectsRelationships;
    protected $table = 'clinics';



    protected $fillable = [
        'name',
        'city_id',
        'district_id',
        'address',
        'phone',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'created_at'
    ];


    // Relationship with Doctor

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    // Relationship with City
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Relationship with District
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function nurses(): HasMany
    {
        return $this->hasMany(Nurse::class);
    }

    public function general_staff(): HasMany
    {
        return $this->hasMany(GeneralStaff::class);
    }

    protected static function booted()
    {
        static::created(function ($clinic) {
            Pharmacy::create([
                'clinic_id' => $clinic->id,
            ]);
        });
        }
}
