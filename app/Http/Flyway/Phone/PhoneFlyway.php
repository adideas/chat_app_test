<?php

namespace App\Http\Flyway\Phone;

interface PhoneFlyway
{
    public function __toString(): string;

    public function getPhone(): string;
}
