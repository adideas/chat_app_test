<?php

namespace App\Http\Flyway\ChatApp;

use Illuminate\Http\Request;

class ChatAppDTO
{
    private mixed $appId;
    private mixed $password;
    private mixed $email;
    public function __construct(Request $request)
    {
        $this->appId = $request->input('appId');
        $this->password = $request->input('password');
        $this->email = $request->input('email');
    }

    public function getAppId(): mixed
    {
        return $this->appId;
    }

    public function getEmail(): mixed
    {
        return $this->email;
    }

    public function getPassword(): mixed
    {
        return $this->password;
    }
}
