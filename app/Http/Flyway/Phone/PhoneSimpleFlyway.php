<?php

namespace App\Http\Flyway\Phone;

use App\Models\Phone;

class PhoneSimpleFlyway implements PhoneFlyway
{
    protected string $uuid = '';
    protected string $phone = '';
    protected ?int $created_at = 0;
    protected ?int $updated_at = 0;

    public function __construct(?Phone $phone = null)
    {
        if ($phone) {
            $this->uuid = $phone->getIdentify();
            $this->phone = $phone->getPhone();
            $this->created_at = $phone->getAttribute($phone->getCreatedAtColumn());
            $this->updated_at = $phone->getAttribute($phone->getUpdatedAtColumn());
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?int
    {
        return $this->updated_at;
    }

    public function __toString(): string
    {
        return json_encode([
            'uuid' => $this->uuid,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
}
