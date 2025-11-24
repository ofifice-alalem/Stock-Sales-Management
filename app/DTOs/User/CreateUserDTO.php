<?php

declare(strict_types=1);

namespace App\DTOs\User;

readonly class CreateUserDTO
{
    public function __construct(
        public int $roleId,
        public string $name,
        public string $phone,
        public string $whatsappNumber,
        public string $username,
        public string $password,
        public bool $isActive
    ) {}
}
