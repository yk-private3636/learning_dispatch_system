<?php

namespace App\Utils;

use App\Consts\Interface\TextTransInterface;
use App\Exceptions\ImproperParamException;

class EnumUtil
{
    public static function  bulkTransText(array $cases): array
    {
        $trans = [];

        foreach($cases as $case) {
            if($case instanceof TextTransInterface === false){
                throw new ImproperParamException;
            }

            $trans[] = $case->getText();
        }
     
        return $trans;
    }
}