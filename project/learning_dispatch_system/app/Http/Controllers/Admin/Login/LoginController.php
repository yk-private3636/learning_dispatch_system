<?php

namespace App\Http\Controllers\Admin\Login;

use App\Services\Admin\Login\AdminLoginService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
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
        $judge = $this->service->authenticationVerdict($req);

        $statusCode = $judge ? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED;

        return response()->json([], $statusCode);
    }

}
