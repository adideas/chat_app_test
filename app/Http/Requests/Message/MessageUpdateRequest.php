<?php

namespace App\Http\Requests\Message;

use App\Http\Flyway\Message\MessageDTO;
use App\Http\Flyway\Message\MessageFlyway;
use Illuminate\Foundation\Http\FormRequest;

class MessageUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'min:4', 'max:255']
        ];
    }

    public function getDTO(): MessageFlyway
    {
        return new MessageDTO($this);
    }
}
