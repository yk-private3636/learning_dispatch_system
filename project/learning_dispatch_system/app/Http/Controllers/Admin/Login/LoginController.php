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

    public function index(): View
    {
        return view('admin.index');
    }

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

            $msg = $this->service->authenticationFailMsg($adminUser); 

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
