<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccurateToken
{
    public function __construct(
      private ResetPasswordTokenRepository $resetPasswordToken
    ){}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next): Response
    {
        $token = $req->route()->parameter('token');

        $judge = $this->resetPasswordToken->activateTokenExists($token);
        
        if($judge === false){
            abort(Response::HTTP_NOT_FOUND);
        }

        return $next($req);
    }
}
