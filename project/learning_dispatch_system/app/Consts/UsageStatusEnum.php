<?php

namespace App\Consts;

use App\Consts\Traits\EnumSelectTrans;

enum UsageStatusEnum: int
{
    use EnumSelectTrans;

    case ACCOUNT_USAGE = 1; // 利用中
	case ACCOUNT_LEAVED = 2; // 退会中
	case ACCOUNT_LOCKD = 3; // ロック中
	case ACCOUNT_SUSPEND = 4; // 停止中
	case ACCOUNT_DELETE_PENDING = 5; // 削除待ち

    public function text(): string
    {
        return match($this) {
            self::ACCOUNT_USAGE   => '利用中',
            self::ACCOUNT_LEAVED  => '退会中',
            self::ACCOUNT_LOCKD   => 'ロック中',
            self::ACCOUNT_SUSPEND => '停止中',
            self::ACCOUNT_DELETE_PENDING => '削除待ち'
        };
    }
}