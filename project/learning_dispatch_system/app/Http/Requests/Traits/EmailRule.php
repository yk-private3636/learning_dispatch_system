<?php

namespace App\Http\Requests\Traits;

use App\Repositories\GeneralUsersRepository;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

trait EmailRule
{
	public function getEmailRule(): array
	{
		return [
			'bail',
			'required',
			'email:rfc,dns'
		];
	}

	public function getEmailRuleWithExists(?int $usageStatus = null): array
	{
		$tableName = app()->make(GeneralUsersRepository::class)->tableName();

		return [
			...$this->getEmailRule(),
			Rule::exists($tableName, 'email')->where(function(Builder $query) use($usageStatus) {
				// $query->whereNull('deleted_at');

				if($usageStatus === null){
					return $query;
				}
				
				return $query->where('usage_status', $usageStatus);
			})
		];
	}

	public function getAdminEmailRuleWithExists(?int $usageStatus = null): array
	{
		$tableName = app()->make(AdminUsersRepository::class)->tableName();

		return [
			...$this->getEmailRule(),
			Rule::exists($tableName, 'email')->where(function(Builder $query) use($usageStatus) {
				// $query->whereNull('deleted_at');

				if($usageStatus === null){
					return $query;
				}
				
				return $query->where('usage_status', $usageStatus);
			})
		];
	}

	public function getEmailRequiredMsg(): string
	{
		return __('validate.required');
	}

	public function getEmailCombinMsg(): string
	{
		return __('validate.email');
	}

	public function getEmailExistsMsg(): string
	{
		return __('validate.exists.email');
	}
}