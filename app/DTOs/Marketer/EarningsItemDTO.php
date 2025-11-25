<?php

declare(strict_types=1);

namespace App\DTOs\Marketer;

final readonly class EarningsItemDTO
{
    public function __construct(
        public string $productName,
        public float $price,
        public int $quantity,
        public float $total
    ) {
    }
}
