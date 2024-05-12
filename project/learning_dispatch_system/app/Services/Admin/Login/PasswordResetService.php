<?php

namespace App\Services\Admin\Login;

use App\Models\AdminUser;
use App\Models\ResetPasswordToken;
use App\Repositories\AdminUsersRepository;
use App\Repositories\ResetPasswordTokenRepository;
use App\Services\Abstract\PasswordResetAbstract;

class PasswordResetService extends PasswordResetAbstract
{
	public function __construct(
		private AdminUsersRepository $adminUser,
		private ResetPasswordTokenRepository $resetPasswordToken
	)
	{
		parent::__construct($resetPasswordToken);
	}

	public function tokenHistroyCreate(string $email, string $token): ResetPasswordToken
	{
		$userDivision = \UserEnum::ADMIN->division();

        return $this->resetPasswordToken->create([
        	'email' => $email,
        	'token' => $token,
        	'user_division' => $userDivision
        ]);
	}

	public function reset(string $token, string $password): AdminUser
	{
		$resetPasswordToken = $this->resetPasswordToken->tokenLinkAdminUser($token);
		$updData = $this->passwordResetUpdData($password);
		$adminUser = $this->adminUser->update($resetPasswordToken->adminUser, $updData);
		$this->resetPasswordToken->delete($resetPasswordToken);

		return $adminUser;
	}
}