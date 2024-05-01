<?php

namespace App\Http\Controllers\Admin\Login;

use App\Services\Admin\Login\AdminLoginService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct(
        private AdminLoginService $service
    ){
        $this->service = $service;
    }

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
            $statusCode = Response::HTTP_UNAUTHORIZED;

            $adminUser = $this->service->accountLockState($email);

            if($adminUser === null){
                $adminUser = $this->service->accountNotAvailable($email);
            }

            $msg = $this->service->authenticationFailMsg($adminUser?->mistake_num);

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $msg = __('message.err.system');
        } finally {
            return response()->json([
                'err_msg' => $msg
            ], $statusCode);
        }
    }

}
