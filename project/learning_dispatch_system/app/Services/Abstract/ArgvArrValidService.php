<?php

namespace App\Services\Abstract;

use Illuminate\Support\Arr;
use App\Exceptions\ArgvArrInvalidException;

abstract class ArgvArrValidService
{
	abstract public function useKeys(string $fncName): array;

	protected function argvArrValid(array $argvArr, array $useKeys): void
	{
		if(count($argvArr) !== count($useKeys)){
			throw new ArgvArrInvalidException;
		}

		foreach($useKeys as $useKey){
			if(Arr::exists($argvArr, $useKey) === false){
				throw new ArgvArrInvalidException;
			}	
		}
	}
}