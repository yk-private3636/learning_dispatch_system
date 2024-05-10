<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mail\PasswordResetMail;
use App\Models\GeneralUser;
use App\Models\AdminUser;
use App\Models\ResetPasswordToken;
use App\Repositories\AdminUsersRepository;
use App\Repositories\GeneralUsersRepository;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
	public function __construct(
		private GeneralUsersRepository $generalUser,
		private AdminUsersRepository $adminUser,
		private ResetPasswordTokenRepository $resetPasswordToken
	){}

	public function adminAuthenticatingJudge(): bool
	{
		$guardName = \UserEnum::ADMIN->guardName();
		return auth()->guard($guardName)->user() !== null;
	}

	public function generalUserPasswordReset(string $token, string $password): GeneralUser
	{
		$resetPasswordToken = $this->resetPasswordToken->tokenLinkGeneralUser($token);
		$updData = $this->passwordResetUpdData($password);
		$generalUser = $this->generalUser->update($resetPasswordToken->generalUser, $updData);
		$this->resetPasswordToken->delete($resetPasswordToken);

		return $generalUser;
	}

	public function passwordResetNotice(GeneralUser|AdminUser $user): void
	{
		$email = $user->email;
		$mailObj = new PasswordResetMail($user);

		SendMailJob::dispatch($user->email, $mailObj);
	}

	public function adminPasswordResetCall(string $token, string $password): void
	{
		$adminUser = $this->adminUser->firstOriginToken($token, $exeJudge = false);
		$updData = $this->passwordResetUpdData($password);
		$this->adminUser->update($adminUser, $updData);
	}

	private function passwordResetUpdData(string $password): array
	{
		return [
			'password' => Hash::make($password)
		];
	}
}


