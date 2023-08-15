<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Phone;
use App\Models\PivotMessagePhone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class MessageRelationPhoneController extends Controller
{
    public function getPhones(Message $message): Collection
    {
        return $message->phone()->select(['phone'])->get();
    }

    public function delPhone(Message $message, Phone $phone): Response
    {
        PivotMessagePhone::where(PivotMessagePhone::MESSAGE_UUID, $message->getIdentify())
            ->where(PivotMessagePhone::PHONE_UUID, $phone->getIdentify())
            ->delete();

        return new Response([], 200);
    }

    public function addPhone(Message $message, Phone $phone): Response
    {
        $exists = PivotMessagePhone::where(PivotMessagePhone::MESSAGE_UUID, $message->getIdentify())
            ->where(PivotMessagePhone::PHONE_UUID, $phone->getIdentify())
            ->exists();

        if (!$exists) {
            PivotMessagePhone::create([
                PivotMessagePhone::MESSAGE_UUID => $message->getIdentify(),
                PivotMessagePhone::PHONE_UUID => $phone->getIdentify(),
            ]);
        }

        return new Response([], 200);
    }
}
