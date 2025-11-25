<?php

declare(strict_types=1);

namespace App\DTOs\Marketer;

final readonly class MarketerEarningsDTO
{
    public function __construct(
        public int $marketerId,
        public array $items,
        public float $totalEarnings
    ) {
    }
}
