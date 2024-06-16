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
use Illuminate\Support\Facades\Redis;
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

            $mistakenUser = $this->service->getMistakePossibilityUser($email);

            $adminUser = $this->service->authenticationFail($mistakenUser);

            $msg = $this->service->authenticationFailMsg($adminUser?->mistake_num);
            $this->setErrorField($msg, Response::HTTP_UNAUTHORIZED);

            DB::commit();
        } catch(\Exception) {
            DB::rollback();
            $this->setErrorField();
        }
        
        return response()->json([
            'err_msg' => $this->msg
        ], $this->statusCode);
    }

    public function logout(Request $req): JsonResponse
    {
        try {
            $this->service->logout();

            $req->session()->invalidate();
    
            $req->session()->regenerateToken();

            $this->setSuccessField(__('message.successful.logout'));

        } catch (\Exception) {
            $this->setErrorField(__('message.unsuccessful.logout'));
        }

        return response()->json([
            'success' => $this->success,
            'msg' => $this->msg
        ], $this->statusCode);
    }
}
