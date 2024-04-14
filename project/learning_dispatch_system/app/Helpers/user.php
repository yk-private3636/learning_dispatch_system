<?php

use App\Services\Common\UserService;

if(function_exists('user') === false)
{
	function user(): ?object
	{
		return UserService::auth();
	}
}
