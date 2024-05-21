<?php

namespace App\Services\Common;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FilterService
{
	public static function blank(Collection|array $datas): Collection|array
    {
    	$judge = $datas instanceof Collection;
    	
    	$filterFn = fn($v) => blank($v);
 
    	return $judge ? $datas->filter($filterFn) : Arr::where($datas, $filterFn);
    }
 
    public static function filled(Collection|array $datas): Collection|array
    {
    	$judge = $datas instanceof Collection;
 
        $filterFn = fn($v) => filled($v);
 
    	return $judge ? $datas->filter($filterFn) : Arr::where($datas, $filterFn);	
    }
 
}