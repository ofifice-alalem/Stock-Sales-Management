<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Invoice;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAll(?string $invoiceNumber = null, ?int $marketerId = null, ?int $storeId = null): LengthAwarePaginator
    {
        $query = Invoice::with(['store', 'marketer', 'items']);
        
        if ($invoiceNumber) {
            $query->where('invoice_number', 'like', '%' . $invoiceNumber . '%');
        }
        
        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }
        
        if ($storeId) {
            $query->where('store_id', $storeId);
        }
        
        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function findById(int $invoiceId): Invoice
    {
        return Invoice::with(['store', 'marketer', 'items.product'])->findOrFail($invoiceId);
    }

    public function create(array $invoiceData): Invoice
    {
        return Invoice::create($invoiceData);
    }

    public function update(int $invoiceId, array $invoiceData): Invoice
    {
        $invoice = $this->findById($invoiceId);
        $invoice->update($invoiceData);
        return $invoice->fresh();
    }

    public function delete(int $invoiceId): bool
    {
        return Invoice::destroy($invoiceId) > 0;
    }
}