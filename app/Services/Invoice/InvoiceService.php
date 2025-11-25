<?php

declare(strict_types=1);

namespace App\Services\Invoice;

use App\DTOs\Invoice\CreateInvoiceDTO;
use App\Events\InvoiceCreated;
use App\Models\Invoice;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceService
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository
    ) {}

    public function getAllInvoices(?string $invoiceNumber = null, ?int $marketerId = null, ?int $storeId = null): LengthAwarePaginator
    {
        return $this->invoiceRepository->getAll($invoiceNumber, $marketerId, $storeId);
    }

    public function createInvoice(CreateInvoiceDTO $invoiceData): Invoice
    {
        return $this->invoiceRepository->create([
            'invoice_number' => $invoiceData->invoiceNumber,
            'marketer_id' => $invoiceData->marketerId,
            'store_id' => $invoiceData->storeId,
            'total_amount' => $invoiceData->totalAmount,
            'sent_to_whatsapp' => false,
        ]);
    }

    public function createInvoiceWithItems(CreateInvoiceDTO $invoiceData, array $items): Invoice
    {
        $invoice = $this->createInvoice($invoiceData);
        
        $totalAmount = 0;
        foreach ($items as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        $invoice->update(['total_amount' => $totalAmount]);
        $invoice = $invoice->fresh(['items']);
        
        InvoiceCreated::dispatch($invoice);
        
        return $invoice;
    }

    public function getInvoiceById(int $invoiceId): Invoice
    {
        return $this->invoiceRepository->findById($invoiceId);
    }

    public function updateInvoice(int $invoiceId, CreateInvoiceDTO $invoiceData): Invoice
    {
        return $this->invoiceRepository->update($invoiceId, [
            'invoice_number' => $invoiceData->invoiceNumber,
            'marketer_id' => $invoiceData->marketerId,
            'store_id' => $invoiceData->storeId,
            'total_amount' => $invoiceData->totalAmount,
        ]);
    }

    public function updateInvoiceWithItems(int $invoiceId, CreateInvoiceDTO $invoiceData, array $items): Invoice
    {
        $invoice = $this->updateInvoice($invoiceId, $invoiceData);
        $invoice->items()->delete();
        
        $totalAmount = 0;
        foreach ($items as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        $invoice->update(['total_amount' => $totalAmount]);
        
        return $invoice->fresh(['items']);
    }

    public function deleteInvoice(int $invoiceId): bool
    {
        $invoice = $this->invoiceRepository->findById($invoiceId);
        $invoice->items()->delete();
        return $this->invoiceRepository->delete($invoiceId);
    }
}