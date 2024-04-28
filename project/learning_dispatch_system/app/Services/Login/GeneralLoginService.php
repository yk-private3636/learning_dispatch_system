<?php

namespace App\Services\Login;

use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\RedirectResponse;

class GeneralLoginService
{

	public function authenticationVerdict(LoginFormRequest $req): bool
	{
    	$credentials = $req->validated();

    	return auth()->attempt($credentials);
	}
}