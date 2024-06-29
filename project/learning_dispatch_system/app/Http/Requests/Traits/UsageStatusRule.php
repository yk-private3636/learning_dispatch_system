<?php

namespace App\Http\Requests\Traits;

use App\Consts\UsageStatusEnum;
use Illuminate\Validation\Rule;

trait UsageStatusRule
{
    protected bool $initValJudge = false;

    public function getUsageStatusRule(string $key = 'usageStatus'): array
    {
        $usageStatus = $this->get($key);

        if($usageStatus === null) {
            return [];
        }

        $this->initValJudge = $usageStatus == \CommonConst::SELECT_INIT_VAL;
        if($this->initValJudge){
            return [];
        }

        return [
            Rule::enum(UsageStatusEnum::class)
        ];
    }

    public function getUsageStatusEnumMsg(): string
    {
        return __('valdate.enum', ['attribute' => __('attribute.usageStatus')]);
    }
}