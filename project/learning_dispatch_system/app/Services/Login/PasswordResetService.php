<?php

namespace App\Services\Login;

use App\Models\GeneralUser;
use App\Models\ResetPasswordToken;
use App\Repositories\GeneralUsersRepository;
use App\Repositories\ResetPasswordTokenRepository;
use App\Services\Abstract\PasswordResetAbstract;

class PasswordResetService extends PasswordResetAbstract
{
	public function __construct(
		private GeneralUsersRepository $generalUser,
		private ResetPasswordTokenRepository $resetPasswordToken
	)
	{
		parent::__construct($resetPasswordToken);
	}

	public function tokenHistroyCreate(string $email, string $token): ResetPasswordToken
	{
		$userDivision = \UserEnum::GENERAL->division();

        return $this->resetPasswordToken->create([
        	'email' => $email,
        	'token' => $token,
        	'user_division' => $userDivision
        ]);
	}

	public function reset(string $token, string $password): GeneralUser
	{
		$resetPasswordToken = $this->resetPasswordToken->tokenLinkGeneralUser($token);
		$updData = $this->passwordResetUpdData($password);
		$generalUser = $this->generalUser->update($resetPasswordToken->generalUser, $updData);
		$this->resetPasswordToken->delete($resetPasswordToken);

		return $generalUser;
	}
}