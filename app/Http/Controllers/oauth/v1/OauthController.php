<?php

namespace App\Http\Controllers\oauth\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OauthController extends Controller
{
    public function login(): Response
    {
        return new Response([], 200);
    }

    public function check(): Response
    {
        return new Response([], Auth::check() ? 200 : 401);
    }

    public function logout(): Response
    {
        Auth::logout();
        return new Response([], 200);
    }
}
