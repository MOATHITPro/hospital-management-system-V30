<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'type',
        'expiry_date',
        'description'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function pharmacyOrders() : HasMany
    {
        return $this->hasMany(PharmacyOrderMedication::class);
    }
}
