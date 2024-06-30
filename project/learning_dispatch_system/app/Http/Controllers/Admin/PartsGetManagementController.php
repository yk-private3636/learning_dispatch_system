<?php

namespace App\Http\Controllers\Admin;

use App\Consts\UsageStatusEnum;
use App\Consts\UserEnum;
use App\Utils\EnumUtil;
use App\Http\Controllers\Traits\RtnCodeMsg;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PartsGetManagementController extends Controller
{
    use RtnCodeMsg;

    public function usageStatusGroup(): JsonResponse 
    {
        try {
            $usageStatuies = UsageStatusEnum::toSelect();
        } catch(\Exception) {
            $this->setErrorField();
            return response()->json([
                'msg' => $this->msg
            ], $this->statusCode);
        }

        return response()->json(
            $usageStatuies,
            Response::HTTP_OK
        );
    }

    public function userEnumsGroup(): JsonResponse
    {
        try {
            $cases = UserEnum::cases();
            $ptn = EnumUtil::bulkTransText($cases);
        } catch(\Exception) {
            $this->setErrorField();
            return response()->json([
                'msg' => $this->msg
            ], $this->statusCode);
        }
    
        return response()->json(
            $ptn,
            Response::HTTP_OK
        );
    }
}
