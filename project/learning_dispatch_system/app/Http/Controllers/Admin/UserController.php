<?php

namespace App\Http\Controllers\Admin;

use App\Dto\User\AdminSearchDTO;
use App\Services\Admin\UserService;
use App\Http\Requests\Admin\User\SearchRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RtnCodeMsg;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use RtnCodeMsg;

    public function __construct(
        private UserService $service
    )
    {}

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

    public function index(SearchRequest $req): JsonResponse
    {
        try {
            $validated = $req->validated();

            $searchDto = new AdminSearchDTO(
                $validated['email'] ?? null,
                $validated['name'] ?? null,
                $validated['usageStatus'] ?? null,
            );

            $users = $this->service->selectUsers($searchDto);
        } catch (\Exception) {
            $this->setErrorField();
            return response()->json([
                'msg' => $this->msg
            ], $this->statusCode);
        }

        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }
}
