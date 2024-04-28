<?php

namespace App\Services\Admin\Login;

use App\Consts\UserEnum;
use App\Http\Requests\Admin\Login\LoginFormRequest;
use Illuminate\Http\Request;

class AdminLoginService
{
	public function authenticationVerdict(LoginFormRequest $req): bool
	{
    	$guardName = UserEnum::ADMIN->guardName();
    	
    	$credentials = $req->validated();
    	
    	return auth()->guard($guardName)->attempt($credentials);
	}
}