<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GeneralUser extends Authenticatable
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string'; // 主キーの型設定


    protected $fillable = [
        'user_id',
        'email',
        'password',
        'family_name',
        'name',
        'usage_status',
    ];
}
