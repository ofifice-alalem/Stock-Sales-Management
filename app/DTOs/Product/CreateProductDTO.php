<?php

declare(strict_types=1);

namespace App\DTOs\Product;

readonly class CreateProductDTO
{
    public function __construct(
        public string $name,
        public string $unit,
        public string $description
    ) {}
}