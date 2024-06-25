<?php

namespace App\Repositories\Traits;

use App\Consts\UsageStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Expression;

trait SelectStatus
{
    public function selectUsageStatus(string $name = 'usage_status', string $as = 'usage_status'): Expression
    {
        $_ = fn(string|int $s) => $s;

        return DB::raw("(CASE {$name}
            WHEN {$_(UsageStatusEnum::ACCOUNT_USAGE->value)} THEN '{$_(UsageStatusEnum::ACCOUNT_USAGE->text())}'
            WHEN {$_(UsageStatusEnum::ACCOUNT_LEAVED->value)} THEN '{$_(UsageStatusEnum::ACCOUNT_LEAVED->text())}'
            WHEN {$_(UsageStatusEnum::ACCOUNT_LOCKD->value)} THEN '{$_(UsageStatusEnum::ACCOUNT_LOCKD->text())}'
            WHEN {$_(UsageStatusEnum::ACCOUNT_SUSPEND->value)} THEN '{$_(UsageStatusEnum::ACCOUNT_SUSPEND->text())}'
            WHEN {$_(UsageStatusEnum::ACCOUNT_DELETE_PENDING->value)} THEN '{$_(UsageStatusEnum::ACCOUNT_DELETE_PENDING->text())}'
            END) AS {$as}");
    }
}