<?php

use App\Services\Common\UserService;
use Illuminate\Foundation\Auth\User;

if(function_exists('user') === false)
{
	function user(): ?User
	{
		return UserService::auth();
	}
}
