<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Services\Login\GeneralLoginService;
use App\Services\Common\StrService;
use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\RedirectResponse as BaseRedirectResponse;
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

        return to_route('top');
    }

    public function redirectToProvider(string $driverName): BaseRedirectResponse
    {
        return $this->service->oAuthProvider($driverName)
                ->redirect();
    }

    public function handleProviderCallback(string $driverName): RedirectResponse
    {
        try{
            $this->service->oAuthAfter($driverName);
        } catch (\Exception) {
            return to_route('general.login');
        }

        return to_route('top');
    }

    public function logout(Request $req): RedirectResponse
    {
        $this->service->logout();

        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return to_route('general.login')->with([
            \KeyConst::MSG => __('message.successful.logout')
        ]);
    }
}
