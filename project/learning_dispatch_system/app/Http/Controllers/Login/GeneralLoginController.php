<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Services\Login\GeneralLoginService;
use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaView;

class GeneralLoginController extends Controller
{
	private GeneralLoginService $service; 

	public function __construct(
		GeneralLoginService $service
	){
		$this->service = $service;
	}

    public function index(): InertiaView
    {
    	return inertia('login/index');
    }

    public function authentication(LoginFormRequest $req): RedirectResponse
    {
    	$redirect = $this->service->authenticationVerdict($req);
    	
    	return $redirect;
    }
}
