<?php

namespace App\Http\Controllers\Login;

use App\Services\Login\PasswordResetService;
use App\Services\Common\StrService;
use App\Http\Requests\PasswordProcedureResetRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Interface\PasswordResetClient;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Response as InertiaView;

class PasswordResetController extends Controller implements PasswordResetClient
{
    public function __construct(
        private PasswordResetService $service
    ){}

    public function loginForgetShow(): InertiaView
    {
        return inertia('login/forget');
    }

    public function passwordResetShow(string $token): InertiaView
    {
        return inertia('login/passwordReset', [
            'token' => $token
        ]);
    }

    public function procedure(PasswordProcedureResetRequest $req): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $email = $req->validated()['email'];
            $token = StrService::createUuid();

            $passResetToken = $this->service->tokenHistroyCreate($email, $token);
            $this->service->passResetGuideNotice($passResetToken);
            DB::commit();

        } catch (\Exception) {
            DB::rollback();
            return back()->withErrors([
                \KeyConst::MSG => __('message.err.system')
            ]);
        }

        return to_route('login.forget.show')->with([
            \KeyConst::MSG => __('message.successful.passwordProcedureReset')
        ]);
    }

    public function passwordReset(PasswordResetRequest $req): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $param = $req->safe()->only(['password', 'token']);
            $generalUser = $this->service->reset($param['token'], $param['password']);
            $this->service->passwordResetNotice($generalUser);
            DB::commit();

        } catch (\Exception) {
            DB::rollback();
            return back()->withErrors([
                \KeyConst::MSG => __('message.err.system')
            ]);
        }

        return to_route('generalLogin')->with([
            \KeyConst::MSG => __('message.successful.passwordReset')
        ]);
    }
}
