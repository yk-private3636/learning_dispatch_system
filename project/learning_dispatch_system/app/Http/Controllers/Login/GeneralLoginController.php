<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Services\Login\GeneralLoginService;
use App\Services\Common\StrService;
use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaView;

class GeneralLoginController extends Controller
{
	public function __construct(
		private GeneralLoginService $service
	){}

    public function index(): InertiaView
    {
    	return inertia('login/index');
    }

    public function authentication(LoginFormRequest $req): RedirectResponse
    {
    	$judge = $this->service->authenticationVerdict($req);

    	if($judge === false){
    		return back()->withErrors([
    			\KeyConst::MSG => __('message.unsuccessful.auth')
    		]);
    	}

    	dd(user());
    }
}
