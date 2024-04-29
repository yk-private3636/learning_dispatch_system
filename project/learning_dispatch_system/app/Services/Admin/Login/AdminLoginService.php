<?php

namespace App\Services\Admin\Login;

use App\Consts\UserEnum;
use App\Models\AdminUser;
use App\Repositories\AdminUsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoginService
{
	public function __construct(
		private AdminUsersRepository $adminUser
	){
		$this->adminUser = $adminUser;
	}

	public function authenticationVerdict(array $credentials): bool
	{
    	$guardName = UserEnum::ADMIN->guardName();
    	
    	return auth()->guard($guardName)->attempt($credentials);
	}

	public function accountLockStateInit(): void
	{

	}

	public function accountLockState(string $email): ?AdminUser
	{
		$adminUser = $this->adminUser->whereUniqueSharedLock($email);

		if($adminUser === null){
			$adminUser = $this->accountUnlockState($email);
			$usageStatus = $adminUser?->usage_status;
			if($usageStatus === null) return null;
			if($usageStatus === \CommonConst::ACCOUNT_LOCKD) return $adminUser;
		}

		$mistakeNum = $adminUser->mistake_num + 1;

		$updData = $this->accountLockStateUpdData($mistakeNum);

		$adminUser = $this->adminUser->updateThenRefresh($adminUser, $updData);

		return $adminUser;
	}

	public function authenticationFailMsg(?AdminUser $adminUser): string
	{
		return match($adminUser?->mistake_num){
			\CommonConst::MISTAKE_STEP_FIR => __('message.mistake.step_fir'),
			\CommonConst::MISTAKE_STEP_SEC => __('message.mistake.step_sec'),
			\CommonConst::MISTAKE_STEP_THI => __('message.mistake.step_thi'),
			default                        => __('message.unsuccessful.auth')
		};
	}

	private function accountUnlockState(string $email): ?AdminUser
	{
		$adminUser = $this->adminUser->whereUniqueSharedLock($email, \CommonConst::ACCOUNT_LOCKD);

		if($adminUser === null){
			return null;
		}

		if(now() <= $adminUser->lock_duration){
			return $adminUser;
		}

		$updData = $this->accountUsageSwithUpdData();
		$adminUser = $this->adminUser->update($adminUser, $updData);

		return $adminUser;
	}

	private function accountLockStateUpdData(int $mistakeNum): array
	{
		return match($mistakeNum){
			\CommonConst::MISTAKE_STEP_FIR => $this->accountLockStateStepFirUpdData(),
			\CommonConst::MISTAKE_STEP_SEC => $this->accountLockStateStepSecUpdData(),
			\CommonConst::MISTAKE_STEP_THI => $this->accountLockStateStepThiUpdData(),
			default                        => $this->accountLockStateDefaltUpdData()
		};
	}

	private function accountLockStateStepFirUpdData(): array
	{
		return [
			'usage_status'  => \CommonConst::ACCOUNT_LOCKD,
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => DB::raw("NOW() + INTERVAL 5 MINUTE")
		];
	}

	private function accountLockStateStepSecUpdData(): array
	{
		return [
			'usage_status'  => \CommonConst::ACCOUNT_LOCKD,
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => DB::raw("NOW() + INTERVAL 1 HOUR")
		];
	}

	private function accountLockStateStepThiUpdData(): array
	{
		return [
			'usage_status'  => \CommonConst::ACCOUNT_SUSPEND, 
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => null
		];
	}

	private function accountLockStateDefaltUpdData(): array
	{
		return [
			'mistake_num' => DB::raw("mistake_num + 1")
		];
	}

	private function accountUsageSwithUpdData(): array
	{
		return [
			'usage_status' => \CommonConst::ACCOUNT_USAGE
		];
	}
}