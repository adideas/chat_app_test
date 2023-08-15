<?php

namespace App\Http\Flyway\Phone;

use Illuminate\Http\Request;

class PhoneDTO extends PhoneSimpleFlyway implements PhoneFlyway
{
    public function __construct(Request $request)
    {
        $this->phone = $request->input('phone', '');
    }
}
