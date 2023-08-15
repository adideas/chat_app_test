<?php

namespace App\ServiceLayer\Phone;

use App\Http\Flyway\Phone\PhoneFlyway;
use App\Models\Phone;

class PhoneUpdateOrCreate
{
    public function updateOrCreate(PhoneFlyway $phone): Phone
    {
        if (Phone::where('phone', $phone->getPhone())->exists()) {

            /** @var Phone|null $model */
            if ($model = Phone::where('phone', $phone->getPhone())->first()) {
                $model->setPhone($phone->getPhone());

                return $model;
            }

        }

        return Phone::from($phone);
    }
}
