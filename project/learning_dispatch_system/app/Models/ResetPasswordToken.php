<?php

namespace App\Models;

use App\Models\AdminUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ResetPasswordToken extends Model
{
    use HasFactory;

    const CREATED_AT = 'sended_at';
    /** 無効の場合 **/
    // const CREATED_AT = null;

    protected $fillable = [
        'email',
        'token',
        'user_division'
    ];

    public function adminUser(): HasOne
    {
        return $this->hasOne(AdminUser::class, 'email', 'email');
    }
}
