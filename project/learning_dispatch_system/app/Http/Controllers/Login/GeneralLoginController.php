<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Services\Login\GeneralLoginService;
use App\Services\Common\StrService;
use App\Http\Requests\Login\PasswordProcedureResetRequest;
use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
    			'auth' => __('message.unsuccessful.auth')
    		]);
    	}

    	dd(user());
    	return to_route('generalLogin');
    }
    
    public function passwordProcedureReset(PasswordProcedureResetRequest $req): RedirectResponse
    {
       DB::beginTransaction();

        try {

            $email = $req->validated()['email'];
            $token = StrService::createUuid();

            $passResetToken = $this->service->passResetProcedureRegistration($email, $token);
            $this->service->passResetGuideNotice($passResetToken);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors([
                \KeyConst::MSG => __('message.err.system')
            ]);
        }

        return to_route('login.forget.show')->with([
            \KeyConst::MSG => __('message.successful.passwordProcedureReset')
        ]);
    }
}
