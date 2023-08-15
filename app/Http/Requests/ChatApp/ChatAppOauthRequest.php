<?php

namespace App\Http\Requests\ChatApp;

use App\Http\Flyway\ChatApp\ChatAppDTO;
use Illuminate\Foundation\Http\FormRequest;

class ChatAppOauthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['email', 'string', 'required'],
            'password' => ['string', 'required'],
            'appId' => ['string', 'required'],
        ];
    }

    public function getDTO(): ChatAppDTO
    {
        return new ChatAppDTO($this);
    }
}
