<?php

namespace App\Http\Requests\Traits;

use App\Repositories\AdminUsersRepository;
use App\Repositories\GeneralUsersRepository;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

trait EmailRule
{
	const EMAIL_MAX_DIGITS = 255;

	public function getEmailRule(): array
	{
		return [
			'bail',
			'required',
			'max:' . self::EMAIL_MAX_DIGITS,
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

	public function getEmailRuleWithUnique(?int $usageStatus = null): array
	{
		$tableName = app()->make(GeneralUsersRepository::class)->tableName();

		return [
			...$this->getEmailRule(),
			Rule::unique($tableName, 'email')->where(function(Builder $query) use($usageStatus) {
				// $query->whereNull('deleted_at');

				if($usageStatus === null){
					return $query;
				}
				
				return $query->where('usage_status', $usageStatus);
			})
		];
	}

	public function getAdminEmailRuleWithUnique(?int $usageStatus = null): array
	{
		$tableName = app()->make(AdminUsersRepository::class)->tableName();

		return [
			...$this->getEmailRule(),
			Rule::unique($tableName, 'email')->where(function(Builder $query) use($usageStatus) {
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

	public function getEmailMaxMsg(): string
	{
		return __('validate.max', ['digits' => self::EMAIL_MAX_DIGITS]);
	}

	public function getEmailCombinMsg(): string
	{
		return __('validate.email');
	}

	public function getEmailExistsMsg(): string
	{
		return __('validate.exists.email');
	}

	public function getEmailUniqueMsg(): string
	{
		return __('validate.unique', ['attribute' => 'メールアドレス']);
	}
}