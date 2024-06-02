<?php

namespace App\Models;

use App\Models\GeneralUserAddInfo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GeneralUser extends Authenticatable
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $primaryKey = 'user_id'; // 主キーカラム名を指定
    protected $keyType = 'string'; // 主キーの型設定

    protected $fillable = [
        'user_id',
        'email',
        'password',
        'family_name',
        'name',
        'usage_status',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $append = [
        'full_name'
    ];

    /** アクセサ **/
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->family_name . ' ' . $this->name
        );
    }

    public function addInfo(): HasOne
    {
        return $this->hasOne(GeneralUserAddInfo::class, 'user_id');
    }
}
