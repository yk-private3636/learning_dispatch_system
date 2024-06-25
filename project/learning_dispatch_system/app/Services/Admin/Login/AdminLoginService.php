<?php

namespace App\Services\Admin\Login;

use App\Consts\UsageStatusEnum;
use App\Models\AdminUser;
use App\Services\Abstract\LoginAbstract;
use App\Repositories\AdminUsersRepository;
use Illuminate\Support\Facades\DB;

class AdminLoginService extends LoginAbstract
{
	public function __construct(
		private AdminUsersRepository $adminUser,
	){}

	/**
	 * 認証が成功したかの判定を行う
	 * 
	 * @param string[] $credentials 認証条件
	 * @return bool 認証判定結果
	 */
	public function authenticationVerdict(array $credentials): bool
	{
    	$guardName = \UserEnum::ADMIN->guardName();
    	
    	return auth()->guard($guardName)->attempt($credentials);
	}

	/**
	 * 認証中ユーザーのパスワード試行回数を初期状態にする
	 * 
	 */
	public function accountLockStateInit(): void
	{
		$user = user();

		if($user === null) return;

		$updData = $this->accountStateInitUpdData();

		$this->adminUser->update($user, $updData);
	}

	/**
	 * 利用中ユーザーアカウントのパスワード試行回数をカウントアップ
	 * 
	 * @param \App\Models\AdminUser $adminUser 
	 * @return \App\Models\AdminUser
	 */
	public function accountMistaken(AdminUser $adminUser): AdminUser
	{
		$mistakeNum = $adminUser->mistake_num + 1;

		$updData = $this->accountLockStateUpdData($mistakeNum);

		// 更新後、最新化したユーザーを返却
		$adminUser = $this->adminUser->updateThenRefresh($adminUser, $updData);

		return $adminUser;
	}

	public function authenticationFail(?AdminUser $adminUser): ?AdminUser
	{
		return match ($adminUser?->usage_status) {
			UsageStatusEnum::ACCOUNT_USAGE->value   => $this->accountMistaken($adminUser),
			UsageStatusEnum::ACCOUNT_LOCKD->value   => $this->accountUnlockState($adminUser),
			UsageStatusEnum::ACCOUNT_SUSPEND->value => $adminUser,
			default                                 => null
		};
	}

	/**
	 * パスワード試行回数によって、画面表示メッセージの切り分け
	 * 
	 * @param int|null $mistakeNum 
	 * @return string
	 */
	public function authenticationFailMsg(?int $mistakeNum): string
	{
		return match($mistakeNum){
			\CommonConst::MISTAKE_STEP_FIR => __('message.mistake.step_fir'),
			\CommonConst::MISTAKE_STEP_SEC => __('message.mistake.step_sec'),
			\CommonConst::MISTAKE_STEP_THI => __('message.mistake.step_thi'),
			default                        => __('message.unsuccessful.auth')
		};
	}

	/**
	 * アカウントロック期間でなければ、利用ステータスを利用中に変更する
	 * 
	 * @param \App\Models\AdminUser $adminUser
	 * @return \App\Models\AdminUser
	 */
	public function accountUnlockState(AdminUser $adminUser): AdminUser
	{
		// ロック中か否か(true: ロック中 false: ロック解除中)
		if(now() <= $adminUser->lock_duration){
			return $adminUser;
		}

		$mistakeUser = $this->accountMistaken($adminUser);

		return $mistakeUser;
	}

	public function getMistakePossibilityUser(string $email): ?AdminUser
	{
		return $this->adminUser->whereStatuiesUniqueSharedLock($email, [
			UsageStatusEnum::ACCOUNT_USAGE,
			UsageStatusEnum::ACCOUNT_LOCKD,
			UsageStatusEnum::ACCOUNT_SUSPEND,
		]);
	}

	public function logout(): void
	{
		$guardName = \UserEnum::ADMIN->guardName();

		auth()->guard($guardName)->logout();
	}

	/**
	 * パスワード試行回数によって、更新パラメータの切り分け
	 * 
	 * @param int $mistakeNum 試行回数
	 * @return array 更新パラメータ
	 */
	private function accountLockStateUpdData(int $mistakeNum): array
	{
		return match($mistakeNum){
			\CommonConst::MISTAKE_STEP_FIR => $this->accountLockStateStepFirUpdData(),
			\CommonConst::MISTAKE_STEP_SEC => $this->accountLockStateStepSecUpdData(),
			\CommonConst::MISTAKE_STEP_THI => $this->accountLockStateStepThiUpdData(),
			default                        => $this->accountLockStateDefaltUpdData()
		};
	}

	/**
	 * パスワード試行回数STEP1(3回)の更新パラメータ取得
	 * 
	 * @return array 更新パラメータ
	 */
	private function accountLockStateStepFirUpdData(): array
	{
		return [
			'usage_status'  => UsageStatusEnum::ACCOUNT_LOCKD,
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => DB::raw("NOW() + INTERVAL 5 MINUTE")
		];
	}

	/**
	 * パスワード試行回数STEP2(6回)の更新パラメータ取得
	 * 
	 * @return array 更新パラメータ
	 */
	private function accountLockStateStepSecUpdData(): array
	{
		return [
			'usage_status'  => UsageStatusEnum::ACCOUNT_LOCKD,
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => DB::raw("NOW() + INTERVAL 1 HOUR")
		];
	}

	/**
	 * パスワード試行回数STEP3(9回)の更新パラメータ取得
	 * 
	 * @return array 更新パラメータ
	 */
	private function accountLockStateStepThiUpdData(): array
	{
		return [
			'usage_status'  => UsageStatusEnum::ACCOUNT_SUSPEND, 
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => null
		];
	}

	/**
	 * パスワード試行回数間違え後のデフォルト更新パラメータ取得
	 * 
	 * @return array 更新パラメータ
	 */
	private function accountLockStateDefaltUpdData(): array
	{
		return [
			'usage_status'  => UsageStatusEnum::ACCOUNT_USAGE,
			'mistake_num'   => DB::raw("mistake_num + 1"),
			'lock_duration' => null
		];
	}

	/**
	 * アカウント利用ステータス初期更新パラメータ
	 * 
	 * @return array 更新パラメータ
	 */
	private function accountStateInitUpdData(): array
	{
		return [
			'usage_status' => UsageStatusEnum::ACCOUNT_USAGE,
			'mistake_num'  => 0
		];
	}
}