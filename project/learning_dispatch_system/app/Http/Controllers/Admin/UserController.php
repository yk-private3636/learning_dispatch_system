<?php

namespace App\Http\Controllers\Admin;

use App\Consts\UserEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function authenticating(): JsonResponse
    {
        $guardName = UserEnum::ADMIN->guardName();
        $judge = auth()->guard($guardName)->user() !== null;
        
        return response()->json([
            'judge' => $judge
        ], Response::HTTP_OK);
    }
}
