<?php

declare(strict_types=1);

namespace App\DTOs\Marketer;

final readonly class MarketerStockDTO
{
    public function __construct(
        public int $marketerId,
        public string $marketerName,
        public string $marketerPhone,
        public array $products,
        public int $totalQuantity
    ) {}
}
