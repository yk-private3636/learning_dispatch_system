<?php

namespace App\Http\Controllers\Admin\Login;

use App\Services\Admin\Login\PasswordResetService;
use App\Http\Requests\PasswordProcedureResetRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RtnCodeMsg;
use App\Http\Controllers\Interface\PasswordResetClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetController extends Controller implements PasswordResetClient
{
    use RtnCodeMsg;

    public function __construct(
        private PasswordResetService $service
    ){}

    public function procedure(PasswordProcedureResetRequest $req): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $email = $req->validated()['email'];
            $token = $this->service->createToken();

            $passResetToken = $this->service->tokenHistroyCreate($email, $token);
            $this->service->passResetGuideNotice($passResetToken);

            $this->setSuccessField(__('message.mail.passwordReset'));
            DB::commit();

        } catch (\Exception) {
            DB::rollback();
            $this->setErrorField();
        }

        return response()->json([
            'msg' => $this->msg
        ], $this->statusCode);
    }

    public function passwordReset(PasswordResetRequest $req): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $param = $req->safe()->only(['password', 'token']);
            $adminUser = $this->service->reset($param['token'], $param['password']);
            $this->service->passwordResetNotice($adminUser);
            
            $this->setSuccessField(__('message.successful.passwordReset'));    
            DB::commit();

        } catch (\Exception) {
            DB::rollback();
            $this->setErrorField();
        }

        return response()->json([
            'msg' => $this->msg
        ], $this->statusCode);
    }

    public function passwordResetAccurateToken(Request $req): JsonResponse
    {
        if($req->attributes->get(\KeyConst::AT_MIDDLEWARE_JUDGE) !== true){
            return response()->json([
                'judge' => false
            ], Response::HTTP_NOT_FOUND);   
        }

        return response()->json([
            'judge' => true
        ], Response::HTTP_OK);
    }
}
