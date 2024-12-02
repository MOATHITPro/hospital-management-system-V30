<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Record extends Model
{
    protected $fillable = [
        'event_type',
        'entity_id',
        'entity_type',
        'action',
        'description',
        'meta_data',
        'occurred_at',
        'status',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'occurred_at' => 'datetime',
    ];

    /**
     * Get the admin that performed the action.
     */
    public function admin(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the entity that the record pertains to.
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
