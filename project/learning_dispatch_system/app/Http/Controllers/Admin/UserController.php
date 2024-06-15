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

        $user = auth()->guard($guardName)->user();
        
        return response()->json([
            'user' => $user->only([
                'email',
                'family_name',
                'name'
            ])
        ], Response::HTTP_OK);
    }
}
