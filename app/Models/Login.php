<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Login extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'login_view'; // اسم الـ View
    public $timestamps = false;

    protected $fillable = [
        'id',
        'username',
        'password',
        'type'
    ];

    // تعريف مفتاح الهوية إذا لزم الأمر
    protected $primaryKey = 'id';
    public $incrementing = false;
}
