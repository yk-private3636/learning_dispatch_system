<?php

namespace App\Services\Common;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FilterService
{
	public static function brank(Collection|array $datas): Collection|array
    {
    	$judge = $datas instanceof Collection;
    	
    	$filterFn = function($v){ return blank($v); };
 
    	return $judge ? $datas->filter($filterFn) : Arr::where($datas, $filterFn);
    }
 
    public static function filled(Collection|array $datas): Collection|array
    {
    	$judge = $datas instanceof Collection;
 
    	$filterFn = function($v){ return filled($v); };
 
    	return $judge ? $datas->filter($filterFn) : Arr::where($datas, $filterFn);	
    }
 
}