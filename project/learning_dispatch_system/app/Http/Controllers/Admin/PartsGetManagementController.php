<?php

namespace App\Http\Controllers\Admin;

use App\Consts\UsageStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PartsGetManagementController extends Controller
{
    public function usageStatusGroup(): JsonResponse 
    {
        $usageStatuies = UsageStatusEnum::toSelect();

        return response()->json(
            $usageStatuies,
            Response::HTTP_OK
        );
    }
}
