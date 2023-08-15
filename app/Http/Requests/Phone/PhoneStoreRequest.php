<?php

namespace App\Http\Requests\Phone;

use App\Http\Flyway\Phone\PhoneDTO;
use App\Http\Flyway\Phone\PhoneFlyway;
use Illuminate\Foundation\Http\FormRequest;

class PhoneStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'min:11', 'max:11']
        ];
    }

    public function getDTO(): PhoneFlyway
    {
        return new PhoneDTO($this);
    }
}
