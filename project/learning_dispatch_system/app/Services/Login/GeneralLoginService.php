<?php

namespace App\Services\Login;

use App\Services\Abstract\LoginAbstract;
use App\Services\UserService;
use App\Repositories\GeneralUsersRepository;

class GeneralLoginService extends LoginAbstract
{
	public function __construct(
		private UserService $userService,
		private GeneralUsersRepository $generalUser
	){
		parent::__construct(
			$userService,
			$generalUser
		);
	}

	public function authenticationVerdict(array $credentials): bool
	{
		$generalUser = $this->generalUser->getOAuthUser($credentials['user_id']);

		if($generalUser !== null){
			return false;
		}
		
    	return auth()->attempt($credentials);
	}
}