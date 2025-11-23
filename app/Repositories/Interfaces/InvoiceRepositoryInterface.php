<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function findById(int $invoiceId): Invoice;
    public function create(array $invoiceData): Invoice;
    public function update(int $invoiceId, array $invoiceData): Invoice;
    public function delete(int $invoiceId): bool;
}