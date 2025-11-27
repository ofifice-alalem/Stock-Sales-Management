<?php

declare(strict_types=1);

namespace App\DTOs\Store;

readonly class StoreCardDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $phone,
        public string $address,
        public float $remaining
    ) {}
}
