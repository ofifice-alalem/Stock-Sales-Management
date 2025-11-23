<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

readonly class LoginRequestDTO
{
    public function __construct(
        public string $username,
        public string $password
    ) {}
}