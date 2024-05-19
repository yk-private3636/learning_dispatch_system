<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Services\Login\GeneralLoginService;
use App\Services\Common\StrService;
use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;

class GeneralLoginController extends Controller
{
	public function __construct(
		private GeneralLoginService $service
	){}

    public function index(): InertiaResponse
    {
    	return inertia('login/index');
    }

    public function authentication(LoginFormRequest $req): RedirectResponse
    {
        $validated = $req->validated();

    	$judge = $this->service->authenticationVerdict($validated);

    	if($judge === false){
    		return back()->withErrors([
    			\KeyConst::MSG => __('message.unsuccessful.auth')
    		]);
    	}

    	dd(user());
    }

    public function redirectToProvider(string $driverName): RedirectResponse
    {
        return $this->service->oAuthScreenRedirect($driverName);
    }

    public function handleProviderCallback(string $driverName)
    {
        try{
            $this->service->oAuthAfter($driverName);
        } catch (\Exception) {
            return to_route('general.login');
        }

        // TOP画面へ飛ばす予定
        // return 
    }    
}
