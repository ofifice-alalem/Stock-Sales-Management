<?php

declare(strict_types=1);

namespace App\DTOs\Invoice;

readonly class CreateInvoiceDTO
{
    public function __construct(
        public string $invoiceNumber,
        public int $marketerId,
        public int $storeId,
        public ?float $totalAmount = null
    ) {}
}