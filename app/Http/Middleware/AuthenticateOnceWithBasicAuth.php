<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Response;

class AuthenticateOnceWithBasicAuth extends AuthenticateWithBasicAuth
{
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        try {
            return parent::handle($request, $next, $guard, $field);
        } catch (\Throwable $e) {
            throw_if($request->header('Accept') != 'application/json', $e);
            return new Response([], 401, []);
        }
    }
}
