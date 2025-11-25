<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Invoice;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class InvoiceCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Invoice $invoice
    ) {}
}
