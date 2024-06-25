<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Expression;

trait SelectNameMethod
{
    public function selectFullName(
        string $begin = 'family_name',
        string $end = 'name',
        string $as = 'name'
    ): Expression
    {
        return DB::raw("CONCAT({$begin}, ' ', {$end}) AS {$as}");
    }
}