<?php

declare(strict_types=1);

namespace App\DTOs\Marketer;

final readonly class StockTransactionDTO
{
    public function __construct(
        public int $marketerId,
        public array $items
    ) {}
}
