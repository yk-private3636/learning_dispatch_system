<?php

namespace App\Services\Login;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GeneralLoginService
{
	private function indexUseParams(): array
	{
		return [
			'user_id',
			'password'
		];
	}

	public function authenticationVerdict(Request $req): RedirectResponse
	{
		$useKeys = $this->indexUseParams();

    	$credentials = $req->only($useKeys);
    	
    	$judge = auth()->attempt($credentials);

    	if($judge === false){
    		return back()->withErrors([
    			'auth' => __('message.unsuccessful.auth')
    		]);
    	}

    	dd(user());
    	return to_route('generalLogin');
	}
}