<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Common\UrlService;
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
        $req->attributes->add([\KeyConst::AT_MIDDLEWARE_JUDGE => true]);
        
        $reqPath = $req->path();
        $token = $req->route()->parameter('token');

        $judge = UrlService::adminSideJudge($reqPath);

        $userDivision = $judge ? \UserEnum::ADMIN->division() : \UserEnum::GENERAL->division();
        $exists = $this->resetPasswordToken->activateTokenExists($token, $userDivision);

        if($exists === false){
            $req->attributes->add([\KeyConst::AT_MIDDLEWARE_JUDGE => false]);
            abort(Response::HTTP_NOT_FOUND);
        }

        return $next($req);
    }
}
