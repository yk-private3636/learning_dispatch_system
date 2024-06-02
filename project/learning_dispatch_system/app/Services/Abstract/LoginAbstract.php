<?php

namespace App\Services\Abstract;

use App\Services\UserService;
use App\Repositories\GeneralUsersRepository;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;

abstract class LoginAbstract
{
	public function __construct(
		private UserService $userService,
		private GeneralUsersRepository $generalUser
	){}

	abstract protected function authenticationVerdict(array $credentials): bool;
	abstract protected function logout(): void;

	public function oAuthProvider(string $driverName): Provider
	{
        return Socialite::driver($driverName);
	}

	public function oAuthAfter(string $driverName): void
	{
		$user = Socialite::with($driverName)->user();
		$email = $user->getEmail();

		$generalUser = $this->generalUser->first($email);
		
		if($generalUser === null){
			$generalUser = $this->generalUser->create([
				'user_id'     => $this->userService->uniqueUserId(),
				'email'       => $email,
				'family_name' => $driverName,
				'name'        => __('text.authenticating')
			]);
		}

		auth()->login($generalUser);
	}
}