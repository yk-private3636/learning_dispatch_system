<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPrefixOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next): Response
    {
        $reqPath = $req->path();

        if(preg_match('/^' . \CommonConst::ADMIN_PREFIX . '/', $reqPath)){
            return $next($req);
        }

        abort(404);
    }
}
