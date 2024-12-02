<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSlot extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'time_slots';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'duration',
        'created_at',
        'updated_at',
    ];


    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'time_id');
    }
}
