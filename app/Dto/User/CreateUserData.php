<?php

namespace App\Dto\User;

readonly class CreateUserData
{

    public function __construct(
        public string  $uuid,
        public string  $email,
        public string  $password,
        public string  $name,
        public string  $userType,
        public ?string $phone = null,
        public ?string $birth = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
          'uuid' => $this->uuid,
          'email' => $this->email,
          'password' => $this->password,
          'name' => $this->name,
          'user_type' => $this->userType,
          'phone' => $this->phone,
          'birth' => $this->birth,
        ];
    }
}