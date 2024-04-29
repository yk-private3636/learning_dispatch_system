<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class AdminUser extends Authenticatable
{
    use HasFactory;

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

    /** ミュータテ **/
    protected function lockDuration(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value),
        );
    }
}
