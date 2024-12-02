<?php

namespace App\Models;

use App\Traits\DetectsRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Nurse extends Authenticatable
{
    use HasFactory,DetectsRelationships;

    protected $table = 'nurses';
    protected $fillable = ['name', 'specialty', 'clinic_id', 'experience', 'email',
        'username',
        'password',
        'Permissions'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
}
