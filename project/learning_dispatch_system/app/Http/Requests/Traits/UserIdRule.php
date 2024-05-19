<?php

namespace App\Http\Requests\Traits;

use App\Repositories\GeneralUsersRepository;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

trait UserIdRule
{

	private const USER_ID_DIGITS = 18;

	public function getUserIdRule(?int $usageStatus = null): array
	{
		$tableName = app()->make(GeneralUsersRepository::class)->tableName();

		return [
			'bail',
			'required',
			'max:' . self::USER_ID_DIGITS,
			Rule::unique($tableName, 'user_id')->where(function(Builder $query) use($usageStatus) {
				if($usageStatus === null){
					return $query;
				}

				return $query->where('usage_status', $usageStatus);
			})
		];
	}

	public function getUserIdRequiredMsg(): string
	{
		return __('validate.required');
	}

	public function geUserIdMaxMsg(): string
	{
		return __('validate.max', ['digits' => self::USER_ID_DIGITS]);
	}

	public function geUserIdUniqueMsg(): string
	{
		return __('validate.unique', ['attribute' => 'ユーザーID']);
	}
}