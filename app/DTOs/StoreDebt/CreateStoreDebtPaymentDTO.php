<?php

declare(strict_types=1);

namespace App\DTOs\StoreDebt;

class CreateStoreDebtPaymentDTO
{
    public function __construct(
        public readonly int $storeId,
        public readonly int $marketerId,
        public readonly float $amount,
        public readonly float $remaining,
        public readonly ?string $note = null
    ) {}
}
