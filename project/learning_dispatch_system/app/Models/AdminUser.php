<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class AdminUser extends Authenticatable
{
    use HasFactory, SoftDeletes;

    // protected $casts = [
    //     'lock_duration' => 'datetime',
    // ];

    protected $fillable = [
        'email',
        'password',
        'family_name',
        'name',
        'usage_status',
        'mistake_num',
        'lock_duration'
    ];

    protected $append = [
        'full_name'
    ];

    /** アクセサ **/
    protected function lockDuration(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value !== null ? Carbon::parse($value) : null,
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->family_name . ' ' . $this->name
        );
    }
}
