<?php

namespace App\Consts\Traits;

trait EnumSelectTrans
{
    public static function toSelect(): array
    {
        $cases = static::cases();

        $selecies = array_map(function($case){
            return [
                'value' => $case->value,
                'text'  => $case->text()
            ];
        }, $cases);

        return [
            ['value' => \CommonConst::SELECT_INIT_VAL, 'text' => __('text.select.all')],
            ...$selecies
        ];
    }
}