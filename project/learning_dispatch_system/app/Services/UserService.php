<?php

namespace App\Services;

use App\Services\Abstract\ArgvArrValidService;
use App\Repositories\AdminUsersRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends ArgvArrValidService
{
	public function __construct(
		private AdminUsersRepository $adminUser
	){}

	public function adminAuthenticatingJudge(): bool
	{
		$guardName = \UserEnum::ADMIN->guardName();
        return auth()->guard($guardName)->user() !== null;
	}

	public function adminPasswordResetCall(array $useParams): void
	{
		$useKeys = $this->useKeys(__FUNCTION__);
		$this->argvArrValid($useParams, $useKeys);
	
		$token = $useParams['token'];
		$password = $useParams['password'];
		$adminUser = $this->adminUser->firstOriginToken($token, $exeJudge = false);
		$updData = $this->passwordResetUpdData($password);
		$this->adminUser->update($adminUser, $updData);
	}

	public function useKeys(string $fncName): array
	{
		return match ($fncName) {
			'adminPasswordResetCall' => [
				'password',
				'token',
			],
		};
	}

	private function passwordResetUpdData(string $password): array
	{
		return [
			'password' => Hash::make($password)
		];
	}
}


