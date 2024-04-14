<?php

namespace App\Services\Common;

use App\Consts\UserEnum;
use Illuminate\Support\Facades\Auth;


class UserService
{
	public static function cases(): array
	{
		return UserEnum::cases();
	}

	public static function auth(): ?object
	{
		$users = self::cases();

		foreach($users as $user){
			$guardName = $user->guardName();
			$auth = Auth::guard($guardName)?->user();

			if(is_null($auth) === false){
				return $auth;
			}
		}

		return null;
	}
}