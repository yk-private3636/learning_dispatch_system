<?php

namespace App\Http\Requests\Traits;

use App\Repositories\ResetPasswordTokenRepository;
use App\Rules\ActivateTokenExistsCkRule;
use Illuminate\Database\Query\Builder;

trait TokenRule
{
	public function getTokenRule(): array
	{
		return [
			new ActivateTokenExistsCkRule
		];
	}
}