<?php

namespace App\Http\Controllers\Admin\Login;

use App\Services\Admin\Login\AdminLoginService;
use App\Services\Common\StrService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RtnCodeMsg;
use App\Http\Requests\Admin\Login\LoginFormRequest;
use App\Http\Requests\Admin\Login\PasswordProcedureResetRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use RtnCodeMsg;
    
    public function __construct(
        private AdminLoginService $service
    ){}

    /**
     * ログインページ表示
     * 
     * @return \Illuminate\View\View ログインページ
     */
    public function index(): View
    {
        return view('admin.index');
    }

    /**
     * 認証ステップ
     * 
     * @param \App\Http\Requests\Admin\Login\LoginFormRequest $req リクエストパラメータ
     * @return \Illuminate\Http\JsonResponse json形式で返却
     */
    public function authentication(LoginFormRequest $req): JsonResponse
    {
        $validated = $req->validated();

        $judge = $this->service->authenticationVerdict($validated);

        if($judge){
            $this->service->accountLockStateInit();
            return response()->json([], Response::HTTP_OK);
        }

        try{
            DB::beginTransaction();

            $email = $validated['email'];

            $adminUser = $this->service->accountLockState($email);

            if($adminUser === null){
                $adminUser = $this->service->accountNotAvailable($email);
            }

            $msg = $this->service->authenticationFailMsg($adminUser?->mistake_num);
            $this->setErrorField($msg, Response::HTTP_UNAUTHORIZED);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            $this->setErrorField();
        } finally {
            return response()->json([
                'err_msg' => $this->msg
            ], $this->statusCode);
        }
    }

    /**
     * パスワードリセット前段階
     * 
     * @param \App\Http\Requests\Admin\Login\PasswordProcedureResetRequest $req リクエストパラメータ
     * @return \Illuminate\Http\JsonResponse json形式で返却
     */
    public function passwordProcedureReset(PasswordProcedureResetRequest $req): JsonResponse
    {
        try {
            DB::beginTransaction();

            $email = $req->validated()['email'];
            $token = StrService::createUuid();

            $passResetToken = $this->service->passResetProcedureRegistration($email, $token);
            $this->service->passResetGuideNotice($passResetToken);

            $this->setSuccessField(__('message.mail.passwordReset'));

            DB::commit();
        } catch (\Exception) {
            DB::rollback();
            $this->setErrorField();
        } finally {
            return response()->json([
                'msg' => $this->msg
            ], $this->statusCode);
        }

    }


}
