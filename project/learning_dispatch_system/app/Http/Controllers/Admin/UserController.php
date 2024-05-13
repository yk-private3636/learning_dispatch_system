<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function adminAuthenticating(): JsonResponse
    {
        $guardName = \UserEnum::ADMIN->guardName();

        $judge = auth()->guard($guardName)->user() !== null;
        
        return response()->json([
            'judge' => $judge
        ], Response::HTTP_OK);
    }
}
