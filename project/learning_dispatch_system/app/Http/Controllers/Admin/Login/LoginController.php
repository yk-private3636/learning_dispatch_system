<?php

namespace App\Http\Controllers\Admin\Login;

use App\Services\Admin\Login\AdminLoginService;
use App\Services\Common\StrService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login\LoginFormRequest;
use App\Http\Requests\Admin\Login\PasswordProcedureResetRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    private int $statusCode; 
    private string $msg; 
    
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

            $this->statusCode = Response::HTTP_UNAUTHORIZED;
            $this->msg = $this->service->authenticationFailMsg($adminUser?->mistake_num);

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $this->msg = __('message.err.system');
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
        $email = $req->validated()['email'];
        $token = StrService::createUuid();

        $passResetToken = $this->service->passResetProcedureRegistration($email, $token);

        $this->service->passResetGuideNotice($passResetToken);
    }

}
