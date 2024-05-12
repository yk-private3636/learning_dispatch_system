<?php

namespace App\Http\Requests\Traits;

use App\Services\Common\UrlService;
use App\Repositories\ResetPasswordTokenRepository;
use App\Rules\ActivateTokenExistsCkRule;
use Illuminate\Database\Query\Builder;

trait TokenRule
{
	public function getTokenRule(string $url): array
	{
		$judge = UrlService::adminSideJudge($url);

		$userDivision = $judge ? \UserEnum::ADMIN->division() : \UserEnum::GENERAL->division();

		return [
			new ActivateTokenExistsCkRule($userDivision)
		];
	}
}