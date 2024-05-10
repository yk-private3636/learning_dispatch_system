<?php

namespace App\Http\Controllers;

use App\Repositories\ResetPasswordTokenRepository;
use App\Services\UserService;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaView;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private int $statusCode; 
    private string $msg; 

    public function __construct(
        private UserService $service
    ){}

    public function adminAuthenticating(): JsonResponse
    {
        $judge = $this->service->adminAuthenticatingJudge();
        
        return response()->json([
            'judge' => $judge
        ], Response::HTTP_OK);
    }

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

    public function passwordReset(PasswordResetRequest $req): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $param = $req->safe()->only(['password', 'token']);
            $generalUser = $this->service->generalUserPasswordReset($param['token'], $param['password']);
            $this->service->passwordResetNotice($generalUser);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors([
                \KeyConst::MSG => __('message.err.system')
            ]);
        }

        return to_route('generalLogin')->with([
            \KeyConst::MSG => __('message.successful.passwordReset')
        ]);
    }

    public function adminPasswordResetAccurateToken(string $token): JsonResponse
    {
        $passwordResetToken = app()->make(ResetPasswordTokenRepository::class);

        $judge = $passwordResetToken->activateTokenExists($token);

        $this->statusCode = $judge ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

        return response()->json([
            'judge' => $judge
        ], $this->statusCode);
    }

    public function adminPasswordReset(PasswordResetRequest $req): JsonResponse
    {
        try {
            $validated = $req->safe()->only(['password', 'token']);
            $this->service->adminPasswordResetCall($validated);

            $this->statusCode = Response::HTTP_OK;
            $this->msg = __('message.successful.passwordReset');
        
        } catch (\Exception $e) {
            $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $this->msg = __('message.err.system');
        } finally {
            return response()->json([
                'msg' => $this->msg
            ], $this->statusCode);
        }
    }

}
