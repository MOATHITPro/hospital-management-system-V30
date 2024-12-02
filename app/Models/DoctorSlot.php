<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DoctorSlot  extends Model
{
    use HasFactory;

    // تحديد اسم الجدول إذا كان يختلف عن الاسم الافتراضي (يجب عدم تكرار ذلك إذا كان الاسم يتبع معايير Laravel الافتراضية)
    protected $table = 'doctor_slots';

    // تعريف الحقول القابلة للتعبئة بشكل جماعي
    protected $fillable = [
        'doctor_id',
        'day',
        'start_time',
        'end_time',
    ];

    // علاقة الارتباط مع جدول الأطباء
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

}
