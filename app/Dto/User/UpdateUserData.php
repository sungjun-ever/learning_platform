<?php

namespace App\Dto\User;

readonly class UpdateUserData
{

    public function __construct(
        public string $name,
        public ?string $phone = null,
        public ?string $birth = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'birth' => $this->birth,
        ];
    }
}